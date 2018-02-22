<?php
namespace app\index\model;

use think\Model;

class Member extends Model
{
    protected $table = 'member';

    public function FindOneUser($cardno)
    {
        try {
            $res = $this->where('cardno', $cardno)->select();

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
            } else {
                return ['code' => 1, 'msg' => $this->getError(), 'data' => ''];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => ''];
        }

    }

    public function InsertOneUser($Data)
    {
        try {
            if ($Data['cardno']){
                $this->data([
                    'cardno' => $Data['cardno'],
                    'nickname' => $Data['cardno'],
                    'realname' => $Data['name'],
                    'college' => $Data['deptcodename'],
                    'sex' => $Data['sex'],
                    'reg_time' => time(),
                    'last_login_time' => time(),
                    'role' => 3,
                    'login' => 1,
                ]);
            } else {
                $this->data([
                    'cardno' => $Data['cardNo'],
                    'nickname' => $Data['cardno'],
                    'realname' => $Data['realName'],
                    'college' => $Data['dept']['name'],
                    'sex' => $Data['gender'],
                    'reg_time' => time(),
                    'last_login_time' => time(),
                    'role' => 3,
                    'login' => 1,
                ]);
            }

            $res = $this->save();

            if($res !== false) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => ''];
            } else {
                return ['code' => 10002, 'msg' => $this->getError(), 'data' => ''];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => ''];
        }
    }
}