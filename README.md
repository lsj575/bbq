BBQv1.0
===============

[TOC]



## 目录结构（待完善）

目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─common             公共模块目录（可以更改）
│  ├─module_name        模块目录
│  │  ├─config.php      模块配置文件
│  │  ├─common.php      模块函数文件
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录
│  │  ├─view            视图目录
│  │  └─ ...            更多类库目录
│  │
│  ├─command.php        命令行工具配置文件
│  ├─common.php         公共函数文件
│  ├─config.php         公共配置文件
│  ├─route.php          路由配置文件
│  ├─tags.php           应用行为扩展定义文件
│  └─database.php       数据库配置文件
│
├─public                WEB目录（对外访问目录）
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─thinkphp              框架系统目录
│  ├─lang               语言文件目录
│  ├─library            框架类库目录
│  │  ├─think           Think类库包目录
│  │  └─traits          系统Trait目录
│  │
│  ├─tpl                系统模板目录
│  ├─base.php           基础定义文件
│  ├─console.php        控制台入口文件
│  ├─convention.php     框架惯例配置文件
│  ├─helper.php         助手函数文件
│  ├─phpunit.xml        phpunit配置文件
│  └─start.php          框架入口文件
│
├─extend                扩展类库目录
├─runtime               应用的运行时目录（可写，可定制）
├─vendor                第三方类库目录（Composer依赖库）
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
~~~

## 命名规范

遵循PSR-2命名规范和PSR-4自动加载规范，并且注意如下规范：

### 目录和文件

*   目录不强制规范，驼峰和小写+下划线模式均支持；
*   类库、函数文件统一以`.php`为后缀；
*   类的文件名均以命名空间定义，并且命名空间的路径和类库文件所在路径一致；
*   类名和类文件名保持一致，统一采用驼峰法命名（首字母大写）；

### 函数和类、属性命名
*   类的命名采用驼峰法，并且首字母大写，例如 `User`、`UserType` ；
*   函数的命名使用小写字母和下划线（小写字母开头）的方式，例如 `get_client_ip`；
*   方法的命名使用驼峰法，并且首字母小写，例如 `getUserName`；
*   属性的命名使用驼峰法，并且首字母小写，例如 `tableName`、`instance`；
*   以双下划线“__”打头的函数或方法作为魔法方法，例如 `__call` 和 `__autoload`；

### 常量和配置
*   常量以大写字母和下划线命名，例如 `APP_PATH`和 `THINK_PATH`；
*   配置参数以小写字母和下划线命名，例如 `url_route_on` 和`url_convert`；

### 数据表和字段
*   数据表和字段采用小写加下划线方式命名，并注意字段名不要以下划线开头，例如 `think_user` 表和 `user_name`字段，不建议使用驼峰和中文作为数据表字段命名。



## API

### 登录

#### 获取手机验证码

> POST:www.example.com/bbq/public/api/version/identify

- HEADER:

  | 参数     | 值                                                           |
  | -------- | ------------------------------------------------------------ |
  | sign     | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type | android or ios                                               |
  | did      | 当前手机的序列号                                             |

- post参数

  | 参数 | 值     |
  | ---- | ------ |
  | id   | 手机号 |

- version为bbq版本，例如v1

- 返回数据

  ```json
  {
      "status": 1,
      "message": "OK",
      "data": []
  }
  ```


#### 手机登陆

> POST:www.example.com/bbq/public/api/version/login

- HEADER:

  | 参数     | 值                                                           |
  | -------- | ------------------------------------------------------------ |
  | sign     | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type | android or ios                                               |
  | did      | 当前手机的序列号                                             |

- post参数

  | 参数  | 值                     |
  | ----- | ---------------------- |
  | phone | 手机号                 |
  | code  | 前一步获取的手机验证码 |

- version为bbq版本，例如v1

- 返回数据

  ```json
  {
      "status": 1,
      "message": "登录成功",
      "data": {
          "token": "c290dda8d0e2b81983797b9f85c8d396763dc2e7208317fdece04a1547e3e372180176377590cad64bb10e45780e0732a7732f3782cef89b7fce34aa473d5fc990efcb31214832cb8a6ea896b75877d2"
      }
  }
  ```


#### 身份认证

##### 获取智慧理工大首页信息

> GET:www.example.com/bbq/public/api/version/lgdindex

- HEADER:

  | 参数     | 值                                                           |
  | -------- | ------------------------------------------------------------ |
  | sign     | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type | android or ios                                               |
  | did      | 当前手机的序列号                                             |

- version为bbq版本，例如v1

- 返回数据

  ```json
  {
      "status": 1,
      "message": "ok",
      "data": {
          "lt": "LT-19188-RTecN4dpFf9PBX926tKZLZEfhV7k1K-tpass",
          "postUrl": "/tpass/login;jsessionid=l4Uz9UBBOVcS349e8WRmRWBGSmCW5nts_9qEZlfGKmUAM_rTn2a4!-907077861?service=http%3A%2F%2Fzhlgd.whut.edu.cn%2Ftp_up%2F"
      }
  }
  ```

- `lt`和`postUrl`用途参考zhlgd登陆流程.md

##### 模拟登陆智慧理工大

> POST:www.example.com/bbq/public/api/version/lgdlogin

- HEADER

  | 参数 |      |
  | ---- | ---- |
  |      |      |
  |      |      |
  |      |      |

### 用户信息

#### 获取用户信息

> GET:www.example.com/bbq/public/api/version/user/read

- HEADER

  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- version为bbq版本，例如v1

- 返回数据

  ```json
  {
      "status": 1,
      "message": "ok",
      "data": "0d3caa223cc70ad3e901f75e76243844cce59ec4e66ea8d7a11c8716ef70ed18780e25e5f02d05d0e53decd06cab0537201329665bae2c1dcdb1fe938d0e5d4cc70e7fee91e673e57fdf8ef900243de33b31d9850c482d3b6772358c11a424c7ad8ff687c831c9429af9a73692b28d1b868a0f1b44c8317d4fc09ccf3246387c3a668c646dbd0c89b2333d3006da63c46fe822d307edc36f6271a1e18a06b4bcceb76f1b99ae59f93afba4b310a547db6a7b37e99204006861f07e18b030f65707394a2b011ac8e74f52ee9a34af11876c861763d17d06882c577710610a0b24bdb4dd3f16ba182b94db313e67911c946e770d1ede3341fe292d864f3e22d53ebd33fa0d999345ab5e81026201f4c5bffb2e868d77548b949a731014e20b400ae62919806fabb603a14b110cbd22bf20efc89b451152894bb073c24e014193e0d418c4befb552a08e6ee7cb9eced15fcef6b9b48e15928caaf083c628fec821c76a25ac169e96426b6bc2284fde92180a3b7215535d451d327a9c0f00e3e1cae057626e8ea29ae2a2981333483fb11e2"
  }
  ```

  - data是用通用加密方法加密过后的用户信息，用相应方式解密即可得到json字符串

    ```json
    {"id":2,"nickname":"小Q17396177273","password":null,"sno":null,"phone":"17396177273","avatar":null,"realname":null,"sex":2,"home_img":null,"signature":null,"college":null,"token":"2e7696f8e0426fc5d901f7557b67862a6addf298","time_out":1558403830,"is_position":0,"create_time":"2018-11-22 09:57:10","update_time":"2018-11-22 09:57:10","last_login_time":1542851830,"type":0,"status":1}
    ```

#### 修改用户信息

> PUT:www.example.com/bbq/public/api/v1/user/:id

- HEADER
  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- put参数（raw data）

  - 参数

    | 参数      | 值                 |
    | --------- | ------------------ |
    | nickname  | 用户昵称（可选）   |
    | avatar    | 头像（可选）       |
    | signature | 个性签名（可选）   |
    | home_img  | 个人主页图（可选） |

  - put参数不能全为空

  - 样例

    ```nickname=BBQ首席烧烤师
    nickname=BBQ首席烧烤师
    ```

- version为bbq版本，例如v1

- 返回数据

  ```
  {
      "status": 1,
      "message": "ok",
      "data": []
  }
  ```


### 主题

#### 获取主题

> GET:www.example.com/api/version/theme

- HEADER:

| 参数     | 值                                                           |
| -------- | ------------------------------------------------------------ |
| sign     | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
| app_type | andorid or ios                                               |
| did      | 当前手机的序列号                                             |


- version为bbq版本，例如v1

- 返回数据

  ```json
  {
      "status": 1,
      "message": "OK",
      "data": [
          {
              "theme_id": 1,
              "theme_name": "BBQ开发交流",
              "img_url": "20180509\\dc425e3b159797af24bf97a6a247cb51.jpg"
          }
      ]
  }
  ```

### 动态

#### 发布动态

> POST:www.example.com/bbq/public/api/v1/article

- HEADER
  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- post参数

  | 参数            | 值                       |
  | --------------- | ------------------------ |
  | theme_id        | 发布到对应主题的主题id   |
  | user_id         | 发布动态的用户id         |
  | content         | 动态内容（没有则为空）   |
  | img             | 动态的图片（没有则为空） |
  | allow_watermark | 是否添加图片水印         |
  | allow_comment   | 是否允许评论             |

  - content和img不能同时为空

- version为bbq版本，例如v1

- 返回数据

  ```
  {
      "status": 1,
      "message": "ok",
      "data": []
  }
  ```
#### 更新动态

> PUT:www.example.com/bbq/public/api/v1/article/:id

- HEADER
  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- put参数（raw data）

  ```
  content=更新动态测试&allow_comment=1&allow_watermark=1&img=&user_id=2&theme_id=1
  ```

- version为bbq版本，例如v1

- 返回数据

  ```
  {
      "status": 1,
      "message": "ok",
      "data": []
  }
  ```

##### 获取某主题下的所有动态

> GET:www.example.com/bbq/public/api/v1/articles/theme?theme_id=1

- HEADER:

  | 参数     | 值                                                           |
  | -------- | ------------------------------------------------------------ |
  | sign     | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type | andorid or ios                                               |
  | did      | 当前手机的序列号                                               |


- version为bbq版本，例如v1

- 返回数据

  ```json
  {
      "status": 1,
      "message": "OK",
      "data": [
          {
              "article_id": 2,
              "content": "更新动态测试",
              "img": "",
              "likes": 0,
              "user_nickname": "BBQ首席烧烤师",
              "user_avatar": null,
              "create_time": "2018-11-22 09:57:10"
          }
      ]
  }
  ```


### 图片

#### 获取accessToken

> GET: www.example.com/api/version/accesstoen

- version为bbq版本，例如v1

- 返回数据

  ```json
  
  ```


### 点赞相关

#### 点赞
> POST:www.example.com/bbq/public/api/v1/upvote

- HEADER
  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- post参数

  | 参数 | 值     |
  | ---- | ------ |
  | id   | 动态id |

- version为bbq版本，例如v1

- 返回数据

  - 成功

    ```json
    {
        "status": 1,
        "message": "ok",
        "data": []
    }
    ```
  - 失败

    ```json
    {
        "status": 0,
        "message": "已点赞,请勿重复点赞",
        "data": []
    }
    ```

#### 取消点赞
> DELETE:www.example.com/bbq/public/api/v1/upvote

- HEADER
  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- delete参数（x-www-form-urlecode）

  | 参数 | 值     |
  | ---- | ------ |
  | id   | 动态id |

- version为bbq版本，例如v1

- 返回数据

  - 成功

    ```json
    {
        "status": 1,
        "message": "ok",
        "data": []
    }
    ```
  - 失败

    ```json
    {
        "status": 0,
        "message": "没有被点赞过，无法取消",
        "data": []
    }
    ```

#### 获取是否被点赞
> GET:www.example.com/bbq/public/api/v1/upvote/:id 

- HEADER
  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- version为bbq版本，例如v1

- 返回数据

  - 被点赞

    ```json
    {
        "status": 1,
        "message": "OK",
        "data": {
            "isUpvote": 1
        }
    }
    ```
  - 未被点赞

    ```json
    {
        "status": 1,
        "message": "OK",
        "data": {
            "isUpvote": 0
        }
    }
    ```

### 关注相关

#### 关注主题
> POST:www.example.com/bbq/public/api/v1/attention/theme

- HEADER
  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- post参数

  | 参数 | 值     |
  | ---- | ------ |
  | id   | 主题id |

- version为bbq版本，例如v1

- 返回数据

  - 成功

    ```json
    {
        "status": 1,
        "message": "ok",
        "data": []
    }
    ```
  - 失败

    ```json
    {
        "status": 0,
        "message": "已关注,请勿重复关注",
        "data": []
    }
    ```

#### 取消点赞
> DELETE:www.example.com/bbq/public/api/v1/attention/theme

- HEADER
  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- delete参数（x-www-form-urlecode）

  | 参数 | 值     |
  | ---- | ------ |
  | id   | 主题id |

- version为bbq版本，例如v1

- 返回数据

  - 成功

    ```json
    {
        "status": 1,
        "message": "ok",
        "data": []
    }
    ```
  - 失败

    ```json
    {
        "status": 0,
        "message": "没有被关注过，无法取消",
        "data": []
    }
    ```

#### 获取是否被点赞
> GET:www.example.com/bbq/public/api/v1/attention/theme/:id 

- HEADER
  | 参数              | 值                                                           |
  | ----------------- | ------------------------------------------------------------ |
  | sign              | 通过加密，将数据传输，每次请求sign都不同（详情参考加密一节） |
  | app_type          | andorid or ios                                               |
  | did               | 当前手机的序列号                                             |
  | access_user_token | 手机登陆后获取的token                                        |

- version为bbq版本，例如v1

- 返回数据

  - 被关注

    ```json
    {
        "status": 1,
        "message": "OK",
        "data": {
            "isAttention": 1
        }
    }
    ```
  - 未被关注

    ```json
    {
        "status": 1,
        "message": "OK",
        "data": {
            "isAttention": 0
        }
    }
    ```

## 后台

### 图片

- 获取accessToken

  > GET: www.example.com/admin/image/getaccesstoken

  - 返回样例

    ```json
    {
        "data": {
            "acesstoken": "f3d623e13b223d7ef6242259764cac44"
        },
        "code": 1,
        "msg": "OK"
    }
    ```

    ​

##加密

###通用AES加密

- 第一步

  > 将数据用字符\0进行填充，使字符串长度为16的倍数

- 第二步

  > AES加密，采用AES-128-CBC
  >
  > key: token_bbq_123789
  >
  > iv: token1234BBQ4321
  >
  > option: openssl_raw_data (js: pkcs7)

- 第三步

  > 将ASCII 字符的字符串转换为十六进制值

###sign加密

- 第一步

  > 将手机设备号（did）、手机型号（app_type）和当前时间（time）进行字符串拼接成形如：
  >
  > 'did=v1&app_type=v2&time=v3'的格式

- 第二步

  > 用通用AES加密方法，将第一步中的字符串进行加密

## 附录

