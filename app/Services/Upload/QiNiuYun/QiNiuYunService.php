<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 17:02
 */

namespace App\Services\Upload\QiNiuYun;


use Qiniu\Auth;

class QiNiuYunService
{
    public function getQiNiuYunToken(array $param)
    {
        $accessKey = config('qiniu.qiniu_access_key');
        $secretKey = config('qiniu.QINIU_SECRET_KEY');
        $bucket    = config('qiniu.qiniu_test_bucket');
        $upUrl    = config('qiniu.upurl');
        // 简单上传凭证
        $expires = config('qiniu.expires');

        /**
         * 可以根据上传文件类型设置
         */
//        if ($param['type'] == 3) {
//            $policy = (object)[
//                'returnBody' => '{"name":$(fname),"size":$(fsize),"type":$(mimeType),"key":$(key)}',
//                'detectMime' => 0
//            ];
//        } else {
//            $policy = (object)[
//                'mimeLimit' => 'image/*',
//                'returnBody' => '{"name":$(fname),"size":$(fsize),"type":$(mimeType),"w":$(imageInfo.width),"h":$(imageInfo.height),"key":$(key)}'
//            ];
//
//        }

        $policy = (object)[
            'mimeLimit' => 'image/*',
            'returnBody' => '{"name":$(fname),"size":$(fsize),"type":$(mimeType),"w":$(imageInfo.width),"h":$(imageInfo.height),"key":$(key)}'
        ];

        // 初始化Auth状态
        $auth = new Auth($accessKey, $secretKey);
        $upToken = $auth->uploadToken($bucket, null, $expires, $policy, true);
        app('log')->info('qiniu uptoken=' . json_encode($upToken));
        if ($upToken) {
            return [
                'code' => 200,
                'result' => [
                    'uptoken' => $upToken,
                    'upUrl' => $upUrl,
                ]
            ];
        } else {
            return [
                'code' => 500,
                'result' => [
                    'info' => '生成token失败!'
                ]
            ];
        }
    }
}