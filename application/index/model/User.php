<?php
namespace app\index\model;

use think\Model;

class User extends Model
{
    protected $table = 'user';

    public function userAttentionUser()
    {
        return $this->hasMany('UserAttentionUser', 'user1_id');
    }

    public function userAttentionTheme()
    {
        return $this->hasMany('UserAttentionTheme', 'user_id');
    }

    public function userCollection()
    {
        return $this->hasMany('UserCollection', 'user_id');
    }

    public function article()
    {
        return $this->hasMany('Article', 'user_id');
    }

    public function articleComments()
    {
        return $this->hasMany('ArticleComments', 'user_id');
    }



    public function getUserInfoById($id)
    {
        try {
            $info = $this->findOneUserById($id);

            if(!is_null($info['data'])) {
                $user = $this->get($info['data']['id']);
                $fans_num = $this->alias('u')
                    ->join('user_attention_user uau', 'u.id = uau.user1_id')
                    ->where(['u.id' => $id])->count();
                $follows_num = $this->alias('u')
                    ->join('user_attention_user uau', 'u.id = uau.user2_id')
                    ->where(['u.id' => $id])
                    ->count();
                $article_likes_num = $user->hasWhere('article', ['status' => 1])->count('likes');
                $comment_likes_num = $user->hasWhere('articleComments', ['status' => 1])->count('likes');
//                $themes_num = $user->hasWhere('userAttentionUser')->count();
//                $collection_num = $user->hasWhere('userCollection')->count();

                $info['data']['fans'] = $fans_num;
                $info['data']['follows'] = $follows_num;
                $info['data']['likes'] = $article_likes_num + $comment_likes_num;
//                $info['data']['themes'] = $themes_num;
//                $info['data']['collection'] = $collection_num;
                return ['code' => 0, 'msg' => 'Success!', 'data' => $info['data']];
            } else {
                return ['code' => 10003, 'msg' => 'User does not exist', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function findOneUserByCardno($cardno)
    {
        try {
            $res = $this->where([
                'cardno' => $cardno,
                'status' => 1
            ])->find();

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res->toArray()];
            } else {
                return ['code' => 10003, 'msg' => $this->getError(), 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }

    }

    public function findOneUserById($id)
    {
        try {
            $res = $this->where([
                'id' => $id,
                'status' => 1
            ])->find();

            if(!is_null($res)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
            } else {
                return ['code' => 10003, 'msg' => $this->getError(), 'data' => null];
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
                'token'    => $data['token'],
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

    public function updateLogin($id, $token)
    {
        try {
            $res = $this->save([
                'token'           => $token,
                'last_login_time' => time(),
            ],['id' => $id]);

            if($res !== false) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
            } else {
                return ['code' => 1, 'msg' => 'Update user login information failed!', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function changeUserNicknameById($id, $newNickname)
    {
        try {
            $isExit = $this->checkNicknameExit($id, $newNickname);
            if (!$isExit) {
                $res = $this->save([
                    'nickname' => $newNickname,
                ],['id' => $id]);

                if($res !== false) {
                    return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
                } else {
                    return ['code' => 10004, 'msg' => 'Failed to update user nickname.', 'data' => null];
                }
            } else {
                return ['code' => 10008, 'msg' => 'Nickname already exists..', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function checkNicknameExit($id, $newNickname)
    {
        try {
            $res = $this->where('nickname', $newNickname)->find();

            if(is_null($res) || $id == $res['id']) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function changeUserIntroductionById($id, $introduction)
    {
        try {
            $res = $this->save([
                'introduction' => $introduction,
            ],['id' => $id]);

            if($res !== false) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
            } else {
                return ['code' => 10005, 'msg' => 'Failed to update user profile.', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function uploadUserAvatar($id, $path)
    {
        try {
            $res = $this->save([
                'avatar' => $path,
            ],['id' => $id]);

            if($res !== false) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
            } else {
                return ['code' => 10006, 'msg' => 'Failed to upload the picture.', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function uploadUserHomeImg($id, $path)
    {
        try {
            $res = $this->save([
                'home_img' => $path,
            ],['id' => $id]);

            if($res !== false) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $res];
            } else {
                return ['code' => 10007, 'msg' => 'Failed to upload the picture.', 'data' => null];
            }
        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }

    public function getAllFriendsById($id)
    {
        try {
            $friends = $this->alias('u')
                ->join('user_attention_user uau', 'u.id = uau.user1_id')
                ->field('u.id,u.nickname,u.avatar,u.introduction')
                ->where(['u.id' => $id])
                ->find();

            if (!is_null($friends)) {
                return ['code' => 0, 'msg' => 'Success!', 'data' => $friends->toArray()];
            } else {
                return ['code' => 10009, 'msg' => 'User is not following any other user', 'data' => null];
            }

        } catch (PDOException $PDOE) {
            return ['code' => 10001, 'msg' => $PDOE->getMessage(), 'data' => null];
        }
    }
}