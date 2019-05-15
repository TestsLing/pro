<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-14
 * Time: 10:12
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{

    protected static $productService;

    public function __construct(ProductService $productService)
    {
        self::$productService = $productService;
    }

    /**
     * 添加产品
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @author: 憧憬
     */
    public function create(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'title' => 'required',
            'thumb' => 'required|string',
            'thumb_desc' => 'required|string',
            'img' => 'required|array',
            'desc' => 'required|string'
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
        $result = self::$productService->create($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }


    /**
     * 获取产品详情
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @author: 憧憬
     */
    public function detail(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'product_guid' => 'required|size:32',
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
        $result = self::$productService->detail($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

    /**
     * 获取产品列表
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @author: 憧憬
     */
    public function list(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'page' => 'integer',
            'limit' => 'integer',
            'title' => 'string',
            'styleTag' => 'array',
            'desc' => 'string'
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
        $result = self::$productService->list($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

    /**
     * 修改产品资料
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @author: 憧憬
     */
    public function edit(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'product_guid' => 'required|size:32',
            'title' => 'string',
            'thumb' => 'string',
            'thumb_desc' => 'string',
            'img' => 'array',
            'desc' => 'string'
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
        $result = self::$productService->edit($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }


    /**
     * 删除产品
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @author: 憧憬
     */
    public function delete(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'product_guid' => 'required|size:32',
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
        $result = self::$productService->delete($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

}