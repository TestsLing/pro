<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 16:56
 */

namespace App\Http\Controllers\Upload\QiNiuYun;


use App\Http\Controllers\Controller;
use App\Services\Upload\QiNiuYun\QiNiuYunService;
use Illuminate\Http\Request;

class QiNiuYunController extends Controller
{
    protected static $qiNiuYunService;

    public function __construct(QiNiuYunService $qiNiuYunService)
    {
        self::$qiNiuYunService = $qiNiuYunService;
    }

    /**
     * 添加产品
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @author: 憧憬
     */
    public function getQiNiuYunToken(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [

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

        $param['guid'] = $request->input('guid');

        // 将业务参数传给相关服务做业务处理
        $result = self::$qiNiuYunService->getQiNiuYunToken($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

}