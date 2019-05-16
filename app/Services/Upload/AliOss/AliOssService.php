<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 17:02
 */

namespace App\Services\Upload\AliOss;


class AliOssService
{
    public function __construct()
    {

    }

    public function genPolicy(string $dir, $expire = 3600)
    {
        $id     = config('alioss.access_key_id');
        $key    = config('alioss.access_key_secret');

        // $host = 'http://bucket-name.oss-cn-hangzhou.aliyuncs.com';
        $host        = 'https://' . config('alioss.bucket') . '.' . config('alioss.end_point');
        $callbackUrl = config('alioss.call_back_url');

        $callback_param = array('callbackUrl'=>$callbackUrl,
            'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}',
            'callbackBodyType'=>"application/x-www-form-urlencoded");
        $callback_string = json_encode($callback_param);

        $base64_callback_body = base64_encode($callback_string);
        $now = time();
        //$expire = 30;  //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问。
        $end = $now + $expire;
        $expiration = $this->gmtIso8601($end);

        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;

        // 表示用户上传的数据，必须是以$dir开始，不然上传会失败，这一步不是必须项，只是为了安全起见，防止用户通过policy上传到别人的目录。
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;


        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['callback'] = $base64_callback_body;
        $response['dir'] = $dir;  // 这个参数是设置用户上传文件时指定的前缀。
        // echo json_encode($response);
        //return json_encode($response);
        return $response;
    }

    private function gmtIso8601($time)
    {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }

    public function getAliOSSPolicy($param)
    {

        // 根据类型上传到不同目录
        switch ($param['type']) {
            case 1:
                $dir = 'cardheadimg/';
                break;
            default:
                $dir = '';
                break;
        }

        $policy = $this->genPolicy($dir, 3600);

        return [
            'code' => 200,
            'result' => [
                'policy' => $policy,
            ]
        ];
    }

}