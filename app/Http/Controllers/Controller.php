<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $rule = [
        'guid' => 'required|string|size:32',
        'param' => 'required|json',
        'version'=> 'required',
        'platform' => 'required',
        'signature' => 'required|string|size:32',
        'time' => 'required'
    ];


    /**
     * 封装验证
     *
     * @param Request $request
     * @param array $paramRule
     * @return Response|array
     */
    public function validateParam(Request $request, array $paramRule)
    {
        $validator = Validator::make($request->all(), $this->rule);

        if ($validator->fails()) {
            return [
                'code' => 501,
                'result' => response(['info' => $validator->errors()->first()], 501)
            ];
        }

        $param = json_decode($request->input('param'), true);
        foreach ($param as $k => $v) {
            if (!array_key_exists($k, $paramRule)) {
                unset($param[$k]);
            }
        }

        $validatorParam = Validator::make($param, $paramRule);

        if ($validatorParam->fails()) {
            return [
                'code' => 501,
                'result' => response(['info' => $validatorParam->errors()->first()], 501)
            ];
        }

        return [
            'code' => 200,
            'result' => $param
        ];
    }
}
