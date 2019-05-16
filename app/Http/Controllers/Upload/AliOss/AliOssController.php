<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 16:56
 */

namespace App\Http\Controllers\Upload\AliOss;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Services\Upload\AliOss\AliOssService;

class AliOssController extends Controller
{
    protected static $aliOssService;

    public function __construct(AliOssService $aliOssService)
    {
        self::$aliOssService = $aliOssService;
    }

    public function getAliOSSPolicy(Request $request)
    {
        // 根据上传文件类型  区分type

        // 定义业务参数验证规则
        $paramRule = [
            'type' => [
                'required',
                Rule::in([0,1,2,3,4,5,6,7,8,9,10,11,12])
            ]
        ];

        // 验证参数
        $validateResult = $this->validateParam($request, $paramRule);

        // 根据验证结果确定是否返回响应还是获取业务参数
        if ($validateResult['code'] == 200) {
            // 获取验证后的业务参数
            $param = $validateResult['result'];
        } else {
            return $validateResult['result'];
        }

        // 将业务参数传给相关服务做业务处理
        $result = self::$aliOssService->getAliOSSPolicy($param);


        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

}