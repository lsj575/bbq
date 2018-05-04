<?php
namespace app\index\model;

use think\Model;

class User extends Model
{
    protected $table = 'user';

    public function findOneUser($cardno)
    {
        try {
            $res = $this->where('cardno', $cardno)->find();

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res->toArray()];
            } else {
                return ['code' => 1, 'msg' => $this->getError(), 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }

    }

    public function insertOneUser($data)
    {
        try {
            $this->data([
                'realname' => $data['realname'],
                'cardno'   => $data['cardno'],
                'nickname' => $data['cardno'],
                'sex'      => $data['sex'],
                'college'  => $data['college'],
                'reg_time' => time(),
                'last_login_time' => time(),
            ]);

            $res = $this->save();

            if($res !== false) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => null];
            } else {
                return ['code' => 10002, 'msg' => 'New user failed!', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function updateLoginTime($id)
    {
        try {
            $res = $this->save([
                'last_login_time' => time(),
            ],['id' => $id]);

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
            } else {
                return ['code' => 1, 'msg' => 'Update user login information failed!', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }
}