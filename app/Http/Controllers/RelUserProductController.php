<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-14
 * Time: 11:38
 */

namespace App\Http\Controllers;


use App\Services\RelUserProductService;
use Illuminate\Http\Request;

class RelUserProductController extends Controller
{
    protected static $relUserProductService;

    public function __construct(RelUserProductService $relUserProductService)
    {
        self::$relUserProductService = $relUserProductService;
    }


    /**
     * 获取用户创建的产品列表
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @author: 憧憬
     */
    public function list(Request $request)
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
        $result = self::$relUserProductService->list($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }
}