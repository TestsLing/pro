<?php
/**
 * Created by 憧憬.
 * User: 憧憬
 * Date: 2019/3/21
 * Time: 21:39
 */

namespace App\Tools;

use App\Models\StatusUserBindModel;
use App\Models\UserInfoModel;
use App\Models\CardInfoModel;
use App\Models\LawyerUserModel;
use App\Models\UserCardModel;
use Illuminate\Support\Facades\DB;

class UserService
{

    private static $statusUserBindModel = null;
    private static $userInfoModel = null;
    private static $lawyerUserModel = null;
    private static $cardInfoModel = null;
    private static $userCardModel = null;

    public function __construct(
        StatusUserBindModel $statusUserBindModel,
        CardInfoModel $cardInfoModel,
        LawyerUserModel $lawyerUserModel,
        UserCardModel $userCardModel,
        UserInfoModel $userInfoModel
    )
    {
        self::$statusUserBindModel = $statusUserBindModel;
        self::$userInfoModel = $userInfoModel;
        self::$cardInfoModel = $cardInfoModel;
        self::$lawyerUserModel = $lawyerUserModel;
        self::$userCardModel = $userCardModel;
    }

    /**
     * 整合主账号数据
     * @param $master
     * @param $slave
     * @return array
     * @author 憧憬
     */
    public function mergeUser($master, $slave)
    {
        /**
         * 如果是涉及到两个账号关联  那么主账号肯定是所有状态都是1  涉及到一些名片的东西需要考虑
         */

        DB::beginTransaction();
        $masterInfo = self::$statusUserBindModel->where('guid', $master)->first();
        $slaveUserInfo = self::$userInfoModel->where('guid', $slave)->first();
        $masterUserInfo = self::$userInfoModel->where('guid', $master)->first();

        $masterInfo->phone = 1;
        $masterInfo->wx = 1;
        $masterInfo->auth_wx = 1;

        $masterInfoRes = $masterInfo->save();

        if (!$masterInfoRes) {
            DB::rollBack();
            return [
                'code' => 520,
                'result' => [
                    'info' => '更新失败'
                ]
            ];
        }

        if ($masterUserInfo->is_has_website == 0) {
            $masterUserInfo->is_has_website = $slaveUserInfo->is_has_website;
            $masterUserInfo->website = $slaveUserInfo->website;

            $masterUserInfoRes = $masterUserInfo->save();

            if (!$masterUserInfoRes) {
                DB::rollBack();
                return [
                    'code' => 520,
                    'result' => [
                        'info' => '更新失败'
                    ]
                ];
            }
        }

        if ($masterUserInfo->v_auth == 0) {
            $masterUserInfo->v_auth = $slaveUserInfo->v_auth;
            $masterUserInfoRes = $masterUserInfo->save();
            if (!$masterUserInfoRes) {
                DB::rollBack();
                return [
                    'code' => 520,
                    'result' => [
                        'info' => '更新失败'
                    ]
                ];
            }
        }

        DB::commit();
        return [
            'code' => 200,
            'result' => [
                'info' => '整合成功'
            ]
        ];
    }


    public function createCoreUser()
    {

    }


    /**
     * 创建默认名片
     * @return array
     * @author: 憧憬
     */
    public function createDefaultCardForUser($userGuid, $avatar, $nickName)
    {

        try{
            // 写入默认名片
            $cardInfo = [
                'send_guid' => '870cd1b8146449cd92b0f59ee1571af7',
                'receive_guid' => $userGuid,
                'card_id' => 0,
                'stars' => 0,
                'add_time' => time(),
            ];
            self::$userCardModel->create($cardInfo);

            // 构建客户表关系
            $lawyerUser = [
                'card_id' => 0,
                'user_guid' => $userGuid,
                'avatar' => $avatar,
                'real_name' => $nickName,
                'communicate_time' => time(),
                'end_visit_time' => time(),
            ];

            self::$lawyerUserModel->create($lawyerUser);

        }catch (\Exception $e) {
            return [
                'code' => 500,
                'result' => [
                    'info' => '创建客户失败'
                ]
            ];
        }

        return [
            'code' => 200,
            'result' => [
                'info' => '创建成功'
            ]
        ];
    }
}