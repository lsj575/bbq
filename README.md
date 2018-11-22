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


### 图片

#### 获取accessToken

> GET: www.example.com/api/version/accesstoen

- version为bbq版本，例如v1

- 返回数据

  ```json

  ```

  ​


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

### 加密

#### 通用AES加密

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

#### sign加密

- 第一步

  > 将手机设备号（did）、手机型号（app_type）和当前时间（time）进行字符串拼接成形如：
  >
  > 'did=v1&app_type=v2&time=v3'的格式

- 第二步

  > 用通用AES加密方法，将第一步中的字符串进行加密

## 附录

