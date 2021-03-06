<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-15
 * Time: 10:41
 */

namespace App\Http\Controllers\Tag;


use App\Services\Tag\TagService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected static $tagService;

    public function __construct(TagService $tagService)
    {
        self::$tagService = $tagService;
    }

    public function create(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'title' => 'required'
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
        $result = self::$tagService->create($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

    public function all(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'tag' => 'array'
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
        $result = self::$tagService->all($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }


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
        $result = self::$tagService->list($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }



    public function edit(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'id' => 'required|integer',
            'title' => 'required|string'
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
        $result = self::$tagService->edit($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }


    public function delete(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'id' => 'required|integer'
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
        $result = self::$tagService->delete($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

    public function prohibit(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'id' => 'required|integer'
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
        $result = self::$tagService->prohibit($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }
}