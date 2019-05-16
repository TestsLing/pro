<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    'access_key_id' => env('ALIOSS_ACCESS_KEY_ID', ''),
    'access_key_secret' => env('ALIOSS_ACCESS_KEY_SECRET', ''),
    'bucket' => env('ALIOSS_BUCKET', ''),
    'bucket_domain' => env('ALIOSS_BUCKET_DOMAIN', ''),
    'internal_bucket_domain' => env('ALIOSS_BUCKET_DOMAIN', ''),
    'end_point' => env('ALIOSS_END_POINT', ''),
    'internal_end_point' => env('ALIOSS_INTERNAL_END_POINT', ''),
    'call_back_url' => env('ALIOSS_CALL_BACK_URL', '')
];
