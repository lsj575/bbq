<?php
namespace app\home\model;

use think\Model;

class Userinfo extends Model
{
    protected $table = 'member';

    public function GetUserMessageAvatar($id)
    {
        try {
            $res = $this->where('id', $id)->find();
            $return = $res->UserMessage()
                ->where('status', 1)
                ->select()
                ->source_avatar;

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $return];
            } else {
                return ['code' => 1, 'msg' => $this->getError(), 'data' => ''];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => ''];
        }
    }

    public function GetUserMessage($id)
    {
        try {
            $res = $this->where('id', $id)->find();
            $return = $res->UserMessage()
                ->where('status', 1)
                ->select();

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
            } else {
                return ['code' => 1, 'msg' => $this->getError(), 'data' => ''];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => ''];
        }
    }

    public function UserMessage()
    {
        return $this->hasMany('Usermessage', 'member_id');
    }
}