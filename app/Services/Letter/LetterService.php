<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 11:51
 */

namespace App\Services\Letter;


use App\Enums\Letter\LetterReadStatus;
use Illuminate\Support\Facades\DB;
use Exception;

class LetterService
{
    protected static $model;

    public function __construct()
    {
        self::$model = app('model');
    }

    /**
     * 留言
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function leaveMessage(array $param)
    {
        $letterModel        = self::$model->letterModel;
        $letterContentModel = self::$model->letterContentModel;

        $messageData = [
            'sender_guid' => $param['guid'],
            'receiver_guid' => $param['receiver_guid'],
            'is_read'   => LetterReadStatus::NOTREAD
        ];

        DB::beginTransaction();
        try{
            $content = $letterContentModel->create([
                'content' => $param['content']
            ]);

            $messageData['content_id'] = $content->id;

            $letterModel->create($messageData);

        }catch (Exception $e) {
            app('log')->debug('留言失败'. $e);
            DB::rollBack();
            return [
                'code' => 200,
                'result' => [
                    'info' => '留言失败'
                ]
            ];
        }

        DB::commit();

        return [
            'code' => 200,
            'result' => [
                'info' => '留言成功'
            ]
        ];
    }


    /**
     * 获取用户留言列表
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function list(array $param)
    {

        // TODO 获取用户的头像昵称
        $letterModel        = self::$model->letterModel;

        // 获取多个留言
        $letter = $letterModel->where('receiver_guid', $param['guid'])
            ->groupBy('sender_guid')
            ->selectRaw('sender_guid,max(content_id) as content_id,max(created_at)')
            ->get()
            ->map(function ($item) use($letterModel, $param) {
                // 每个人把最新一条放列表上
                $item->content = $item->letterContent()->value('content');
                // 每个人留言多少未读
                $read = $letterModel->where('sender_guid', $item->sender_guid)
                    ->where('receiver_guid', $param['guid'])
                    ->where('is_read', LetterReadStatus::NOTREAD)
                    ->count();

                $item->read = $read;
                return $item;
            });

        return [
            'code' => 200,
            'result' => [
                'list' => $letter
            ]
        ];
    }


    /**
     * 获取留言详情
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function detail(array $param)
    {
        $letterModel = self::$model->letterModel;

        // 发送者  和接收者
        $where = [
            'sender_guid' => $param['sender_guid'],
            'receiver_guid' => $param['guid']
        ];

        $orWhere = [
            'sender_guid' => $param['guid'],
            'receiver_guid' => $param['sender_guid']
        ];

        $content = $letterModel->where($where)->orWhere(function ($query) use ($orWhere) {
            $query->where($orWhere);
        })->orderBy('id')->get();

        foreach ($content as $v) {
            // 获取内容
            $v->content =$v->letterContent()->value('content');

            // 发送者在左边  接受者在右边
            if ($v->sender_guid === $param['sender_guid']) {
                $v->position = 'left';
            }else{
                $v->position = 'right';
            }
        }

        // 我查看对方我给我留的言  把留言作为已读
        $letterModel->where($where)->where('is_read', LetterReadStatus::NOTREAD)->update(['is_read'=>LetterReadStatus::READED]);

        return [
            'code' => 200,
            'result' => [
                'content' => $content
            ]
        ];
    }


    /**
     * 删除留言 TODO  存在对列表删除  和对单条信息删除
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function delete(array $param)
    {
        // 对列表进行删除吧
        $letterModel        = self::$model->letterModel;

        $letterDelRes = $letterModel->where('sender_guid', $param['sender_guid'])->where('receiver_guid', $param['guid'])->delete();

        if ($letterDelRes < 1) {
            return [
                'code' => 200,
                'result' => [
                    'info' => '删除失败'
                ]
            ];
        }


        return [
            'code' => 200,
            'result' => [
                'info' => '删除成功'
            ]
        ];
    }

    /**
     * 一键已读
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function readAllMessage(array $param)
    {
        $letterModel        = self::$model->letterModel;

        $letterModel->where('receiver_guid', $param['guid'])->update(['is_read'=>LetterReadStatus::READED]);

        return [
            'code' => 200,
            'result' => [
                'info' => '一键已读成功'
            ]
        ];
    }

}