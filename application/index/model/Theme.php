<?php
namespace app\index\model;

use think\Model;

class Theme extends Model
{
    protected $table = 'theme';

    public function addTheme($data)
    {
        try {
            $theme = $this->findThemeByThemeName($data['themename']);
            if ($theme['code'] == 0) {
                return ['code' => 20004, 'msg' => 'The topic already exists.', 'data' => null];
            }

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
                return ['code' => 20003, 'msg' => "No corresponding topic found.", 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function findThemeByThemeName($themeName)
    {
        try {
            $res = $this->where([
                'user_id' => $themeName,
                'status' => 1
            ])->find();

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res->toArray()];
            } else {
                return ['code' => 20003, 'msg' => "No corresponding topic found.", 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function findAllTheme()
    {
        try {
            $res = $this->where([])->select();

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
            } else {
                return ['code' => 20005, 'msg' => "No topic.", 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }
}