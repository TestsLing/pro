<?php
namespace App\Tools;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Redis;

/**
 * 公共类
 *
 * Class Common
 * @package App\Tools
 */
class Common
{
    /**
     * 返回uuid
     * @return string
     */
    public static function getUuid()
    {
        $key = array_rand([1, 2]);

        switch ($key){
            case 0:
                $uuid = Uuid::uuid1();
                break;
            case 1:
                $uuid = Uuid::uuid4();
                break;
        }

        return $uuid->getHex();
    }

    /**
     * CURL方法
     *
     * @param $url
     * @param bool $params
     * @param int $isPostxPay($payParam);
     * @param int $https
     * @return bool|mixed
     */
    public static function curl($url, $params = false, $isPost = 1, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }

        $url = env('DOMAIN_SERVERS') . $url;

        $data = ['param' => json_encode($params)];

        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($data)) {
                    $data = http_build_query($data);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $data);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);

        // 判断curl是否成功
        if (empty($response)) {
            //dd('12123');
            return false;
        }

        // 解析CURL返回值
        $curl = json_decode($response, true);

        // 判断CURL返回值是否成功
        if (empty($curl)) {
            $debug = env('DEV');
            if ($debug) {
                return $response;
            }
            return false;
        } else {
            return $curl;
        }
    }

    /**
     * 加密算法
     *
     * @param $user
     * @param $pwd
     * @param int $position
     * @return string
     */
    public static function cryptString($user, $pwd, $position = 3)
    {
        $subUser  = substr($user, 0, $position);
        $cryptPwd = md5($pwd);
        return md5(md5($cryptPwd . $subUser));
    }

    /**
     * 返回curl结果
     *
     * @param $curl
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public static function returnCurlResult($curl)
    {
        if (empty($curl)) {
            return response('请求失败,请重试!', 500);
        } else {
            if ($curl['ServerNo'] == 'SN200') {
                return response($curl['ResultData'], 200);
            } else if ($curl['ServerNo'] == 'SN400') {
                return response($curl['ResultData'], 400);
            } else {
                return response($curl['ResultData'], 500);
            }
        }
    }

    /**
     * 手机号码验证
     * 移动号码段:139、138、137、136、135、134、150、151、152、157、158、159、182、183、187、188、147
     * 联通号码段:130、131、132、136、185、186、145
     * 电信号码段:133、153、180、189
     * @param $phone
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public static function checkCellphone($phone)
    {
        if (strlen($phone) != "11") {
            return false;
        }

        if (preg_match("/^1(3|4|5|6|7|8|9)\\d{9}$/", $phone)) {
            return true;
        }
        return false;
    }

    /**
     * 判断是否是手机
     *
     * @return bool
     * @author   cxs
     * @date    20170810
     */
    public static function isMobile(){
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
            return TRUE;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])){
            return stristr($_SERVER['HTTP_VIA'], "wap") ? TRUE : FALSE;// 找不到为flase,否则为TRUE
        }
        // 判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array (
                'mobile',       'nokia',        'sony',         'ericsson',         'mot',
                'samsung',      'htc',          'sgh',          'lg',               'sharp',
                'sie-',         'philips',      'panasonic',    'alcatel',          'lenovo',
                'iphone',       'ipod',         'blackberry',   'meizu',            'android',
                'netfront',     'symbian',      'ucweb',        'windowsce',        'palm',
                'operamini',    'operamobi',    'openwave',     'nexusone',         'cldc',
                'midp',         'wap'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
                return TRUE;
            }
        }
        if (isset ($_SERVER['HTTP_ACCEPT'])){ // 协议法，因为有可能不准确，放到最后判断
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== FALSE) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === FALSE || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))){
                return TRUE;
            }
        }
        return FALSE;
    }


    /**
     * CURL方法
     *
     * @param $url
     * @param bool $params
     * @param int $isPost
     * @param int $https
     * @return bool|mixed
     */
    public static function curlClient($url, $params = false, $isPost = 1, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }

        $url = env('DOMAIN_ADMIN') . $url;

        $data = ['param' => json_encode($params)];

        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($data)) {
                    $data = http_build_query($data);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $data);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);

        // 判断curl是否成功
        if (empty($response)) {
            //dd('12123');
            return false;
        }

        // 解析CURL返回值
        $curl = json_decode($response, true);

        // 判断CURL返回值是否成功
        if (empty($curl)) {
            $debug = env('DEV');
            if ($debug) {
                return $response;
            }
            return false;
        } else {
            return $curl;
        }
    }

    /**
     * 根据整型时间戳和给定时区，返回日期
     *
     * @param int $intTime
     * @param string $timeZone
     * @return false|string
     */
    public static function intTimeToDate(int $intTime, string $timeZone, string $format = "Y-m-d H:i:s")
    {
        date_default_timezone_set($timeZone);
        return date($format, $intTime);
    }

    /**
     * 根据给定的两个整数时间戳和时区，判断这两个时间戳是否在同一天内
     *
     * @param int $firstIntTime
     * @param int $secondIntTime
     * @param string $timeZone
     * @return bool
     * @author 胡必腾
     */
    public static function isSameDay(int $firstIntTime, int $secondIntTime, string $timeZone)
    {
        date_default_timezone_set($timeZone);

        $firstDay = date("Y-m-d", $firstIntTime);
        $secondDay = date("Y-m-d", $secondIntTime);

        if ($firstDay === $secondDay) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断整数时间戳$firstIntTime，在特定时区$timeZone下对应的日期(具体到天)，是否在$secondIntTime对应日期(具体到天)之前
     *
     * @param int $firstIntTime
     * @param int $secondIntTime
     * @param string $timeZone
     * @return bool
     * @author 胡必腾
     */
    public static function beforeToday(int $firstIntTime, int $secondIntTime,string $timeZone)
    {
        date_default_timezone_set($timeZone);

        $firstDay = date("Y-m-d", $firstIntTime);
        $secondDay = date("Y-m-d", $secondIntTime);

        if ($firstDay <= $secondDay) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string guid
     * @throws \Exception
     */
    public static function getGuid()
    {
        return Uuid::uuid4()->getHex();
    }


    /**
     * 对数组多个键进行排序
     * array_orderby($data, 'volume', SORT_DESC, 'edition', SORT_DESC, 'price', SORT_DESC)
     * @return mixed
     * @author 憧憬
     */
    public static function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }


    /**
     * 获取区间内所有日期
     * @param $startDate
     * @param $endDate
     * @return array
     * @author: 憧憬
     */
    public static function getDateFromRange($startDate, $endDate){

        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);

        // 计算日期段内有多少天
        $days = ($endTimestamp-$startTimestamp)/86400+1;

        // 保存每天日期
        $date = array();

        for($i=0; $i<$days; $i++){
            $date[] = date('Y-m-d', $startTimestamp+(86400*$i));
        }

        return $date;
    }


    /**
     * @param string $month
     * @param string $format
     * @param bool $dateTimeZone
     * @return array
     * @throws \Exception
     * @author: 憧憬
     */
    public static function getMonthDays($month = "this month", $format = "Y-m-d", $dateTimeZone = false, $isDefaultVal = false)
    {
        if (!$dateTimeZone) $dateTimeZone = new \DateTimeZone("PRC");
        $start = new \DateTime("first day of $month", $dateTimeZone);
        $end = new \DateTime("last day of $month", $dateTimeZone);

        $days = array();
        for ($time = $start; $time <= $end; $time = $time->modify("+1 day")) {

            if ($isDefaultVal) {
                $days[$time->format($format)] = ['x'=>$time->format($format), 'y'=>0];
            }else{
                $days[] = $time->format($format);
            }
        }
        return $days;
    }


    /**
     * 获取平台访问量
     * @param string $type GET SET
     * @param $guid string 用户guid 用于存储最后访问的用户
     * @return mixed int 默认返回平台访问量总数 GET返回平台所有访问量 和总数
     * @author: 憧憬
     */
    public static function incrPlatformVisit($guid = null, $type = 'GET')
    {
        $pkey = 'HASH:index:platform:visit';
        $ukey = 'HASH:index:platform:user:visit';

        $total = Redis::hget($pkey, 'total');

        switch ($type) {
            case 'GET':
                $user = Redis::lrange($ukey, 0, -1);

                return [
                    'total' => $total ?? 0,
                    'user'  => $user
                ];

                break;
            case 'SET':
                // 写入平台数据
                $total = Redis::hincrby($pkey,'total',1);
                Redis::hset($pkey,'end_visit_time',time());
                Redis::hset($pkey,'end_visit_guid', $guid);

                // 记录用户访问数据
                Redis::lpush($ukey, time() .':'. $guid);
                break;
        }

        return [
            'total' => $total ?? 0,
            'user'  => $guid
        ];
    }


    /**
     * 对每个用户访问量进行增加
     * @param $guid
     * @param callable $callBack 达到阈值需要执行的函数
     * @return mixed
     * @author: 憧憬
     */
    public static function incrUserVisit($guid, callable $callBack)
    {
        $visitTotal = config('visit.total');
        $visitIncr = config('visit.incr');
        $visitOverTime = config('visit.over_time_threshold');
        $visitOverIncr = config('visit.incr_threshold');

        $key = "HASH:index:user:$guid:visit";

        $sum = Redis::hincrby($key,'total', $visitTotal);
        $incr = Redis::hincrby($key,'increment',$visitIncr);
        $ctiem = Redis::hget($key,'ctime');

        if ($ctiem){
            if ($ctiem+$visitOverTime < time()) {
                Redis::hset($key,'ctime',time());
                Redis::hset($key,'increment',0);
                try{
                    $callBack($sum);
                }catch (\Exception $e){
                    \Log::info('回调失败');
                }
            }
        }else{
            Redis::hset($key,'ctime',time());
        }

        if ($incr > $visitOverIncr){
            Redis::hset($key,'increment',0);
            Redis::hset($key,'ctime',time());
            try{
                $callBack($sum);
            }catch (\Exception $e){
                \Log::info('回调失败');
            }
        }
        return $sum;
    }
}
