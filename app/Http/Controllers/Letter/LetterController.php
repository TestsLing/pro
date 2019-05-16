<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 11:51
 */

namespace App\Http\Controllers\Letter;


use App\Http\Controllers\Controller;
use App\Services\Letter\LetterService;
use Illuminate\Http\Request;

class LetterController extends Controller
{

    protected static $letterService;

    public function __construct(LetterService $letterService)
    {
        self::$letterService = $letterService;
    }

    public function leaveMessage(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'receiver_guid' => 'required|size:32',
            'content' => 'required'
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
        $result = self::$letterService->leaveMessage($param);

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
        $result = self::$letterService->list($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

    public function detail(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'sender_guid' => 'required|size:32'
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
        $result = self::$letterService->detail($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

    public function delete(Request $request)
    {
        // 定义业务参数验证规则
        $paramRule = [
            'sender_guid' => 'required|size:32'
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
        $result = self::$letterService->delete($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }

    public function readAllMessage(Request $request)
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
        $result = self::$letterService->readAllMessage($param);

        // 根据业务处理结果做出响应
        return response($result['result'], $result['code']);
    }
}