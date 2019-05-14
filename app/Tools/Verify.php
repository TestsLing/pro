<?php
namespace App\Tools;

use App\Services\Smallprogram\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Verify
{
    // 静态变量
    private static $userService = null;

    /**
     * 依赖注入
     * @param UserService $userService
     *
     * @return void
     *
     */
    public function __construct(
        UserService $userService
    )
    {
        self::$userService = $userService;
    }

    /**
     * 通用接口
     * @param $request
     * @return bool|string
     */
    public function common(Request $request)
    {
        if($request->all()){
            $data = $request->all();
            $ckTime = $this->checkTime($data['time']);
            if(!$ckTime) return 'SN002';
            // 判断只有在检测接口路由时才会检测版本
            if($request->path()=='checkVersion'){
                return "SN200";
            }
            if(!isset($data['guid'])) return 'SN004';
            if(!isset($data['version'])) return 'SN003';
            if(!isset($data['platform'])) return 'SN003';
            // 根据版本设计不同的验证());
            switch ($data['version']){
                case '1.0':
                    $temp = $this->checkCommon_v1($request);
                    break;
                default:
                    $temp = $this->checkCommon_v1($request);
                    break;
            }
            if($temp){
                return "SN200";
            }
            return "SN005";
        }
        return false;
    }

    /**
     * 非通用接口
     * @param $request
     * @return bool|string
     */
    public function proprietary(Request $request)
    {
        if($request->all()){
            $data = $request->all();
            $ckTime = $this->checkTime($data['time']);
            if(!$ckTime) return 'SN002';
            if(!isset($data['guid'])) return "SN004";
            if(!isset($data['version'])) return 'SN003';
            if(!isset($data['platform'])) return 'SN003';
            // 根据版本设计不同的验证
            switch ($data['version']){
                case '1.0':
                    $temp = $this->checkProprietary_v1($request);
                    break;
                default:
                    $temp = $this->checkProprietary_v1($request);
                    break;
            }

            if($temp){
                app('log')->info('snsnsnsnssnsn===' . json_encode($temp));
                // return "SN200";
                switch ($temp){
                    case 'SN007':
                        return 'SN007';
                        break;
                    case 'SN006':
                        return 'SN008';
                        break;
                    case 'SN009':
                        return 'SN009';
                        break;
                    default:
                        return 'SN200';
                        break;
                }
            }
            return "SN005";
        }
        return false;
    }

    /**
     * 时间验证
     * @param $time
     * @return bool|string
     */
    public function checkTime($time)
    {
        $Time_difference = abs(time()-$time);
//        if($Time_difference>30){
//            return false;
//        }
        return true;
    }

    /**
     * 通用接口验证
     * @param $request
     * @return bool
     */
    private function checkCommon_v1(Request $request)
    {
        app('log')->info('request ====', $request->all());
        $data = $request->all();
        $path = $request->path();
        $time = $data['time'];
        $guid = 'ff0340e9ccab0aca99407185b3286a28';
        $param = $data['param'];
        $cryptToken = "lawyer";
        $platform = $data['platform'];
        $signature = md5($path.$time.$guid.$platform.$param.$cryptToken);
        if($signature!=$data['signature']){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 非通用接口验证
     * @param $request
     * @return bool
     */
    private function checkProprietary_v1($request)
    {
        app('log')->info('check request=', $request->all());
        app('log')->info('request path=' . $request->path());
        $data = $request->all();
        $path = $request->path();
        $param = $data['param'];
        $guid = $data['guid'];
        $platform = $data['platform'];
        $signature = $data['signature'];
        $time = $data['time'];
        $user = $this->user($guid, $platform);
        if(!$user) return 'SN007';  // 用户不存在

        $tokenTime = $user['expire_time'];
        if($time > $tokenTime){
            return 'SN009';     // token超时 重新登录
        }

        $token = $user['token'];
        app('log')->info('token ='.$token);
        $hashs = [
            [2, 8, 19, 25, 30, 31],
            [31, 20, 3, 25, 4, 8],
            [25, 31, 0, 9, 13, 17],
            [29, 2, 11, 17, 1, 25],
            [10, 15, 18, 29, 2, 3],
            [5, 10, 15, 17, 18, 22],
            [9, 0, 5, 2, 13, 28],
            [8, 20, 22, 27, 19, 21],
        ];
        $strs =substr($token,3,1);
        $strs.=substr($token,5,1);
        $strs.=substr($token,7,1);
        $code = hexdec($strs);
        $str1 = $code%8;
        $arr =$hashs["$str1"];
        $m = null;
        foreach($arr as $v){
            $m.= substr($token,$v,1);
        }
        app('log')->info('mmm ='.$m);
        app('log')->info('str to sing=' . $time.$guid.$platform.$param.$m);
        $str = md5($path.$time.$guid.$platform.$param.$m);
        app('log')->info('str  and  signature=' . $str . '=' . $signature);
        if($signature == $str){
            return 'SN200';
        }else{
            return false;
        }
    }

    /**
     * 路由判断方法
     * @param $path
     * @return bool
     */
    public function inPath($path)
    {
        $paths = ['index/send/smscode','login','test/checkmiddleware', 'index', 'register', 'afterSale', 'test', 'wxlogin', 'appwxlogin','common/getcardlist','is-visitor-enable', 'config/get-app-config'];
        return in_array($path, $paths);
    }

    /**
     * 参数拼装
     * @param $info
     * @return Response
     */
    public function potting(Response $info)
    {
        if($info->getStatusCode()==200){
            return response()->json(['serverTime'=>time(),'ServerNo'=>'SN200','ResultData'=>$info->original]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>'SN'.$info->getStatusCode(),'ResultData'=>$info->original]);
        }
    }

    /**
     * 获取App用户资料
     *
     * @param string $guid
     * @param string $platform
     * @return array|bool
     * @author 王思地
     */
    public function user($guid, $platform)
    {
        if (empty($guid) || empty($platform)) {
            return false;
        }

        $user = self::$userService->getUserToken($guid, $platform);
        // $user = Common::curl('/getToken', $param, 0);
        //app('log')->info(json_encode($user));
        /*
        if (!empty($user) && $user['ServerNo'] == 'SN200') {
            return $user['ResultData'];
        }
        */
        return $user;
    }
}
