<?php
namespace app\index\model;

use think\Model;

class Theme extends Model
{
    protected $table = 'theme';

    public function addTheme($data)
    {
        try {
            $this->data([
                'user_id' => $data['userID'],
                'theme_name' => $data['themename'],
                'theme_introduction' => $data['introduction'],
                'background_img' => $data['path'],
                'create_time' => time(),
                'update_time' => time(),
            ]);

            $res = $this->save();

            if($res !== false) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => null];
            } else {
                return ['code' => 20002, 'msg' => 'New theme failed!', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function findThemeByUserId($userID)
    {
        try {
            $res = $this->where([
                'user_id' => $userID,
                'status' => 1
            ])->find();

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res->toArray()];
            } else {
                return ['code' => 20003, 'msg' => $this->getError(), 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }
}