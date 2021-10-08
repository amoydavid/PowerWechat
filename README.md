# PowerWeChat

Base on EasyWeChat(#ba6e21f)

Thanks!

## Requirement

1. PHP >= 7.0
2. **[Composer](https://getcomposer.org/)**
3. openssl 拓展
4. fileinfo 拓展（素材管理模块需要用到）

## Installation

```shell
$ composer require "amoydavid/powerwechat" -vvv
```
## Update

目前已经可支持 composer2

## Usage

基本使用（以服务端为例）:

```php
<?php

use PowerWeChat\Factory;

$options = [
    'app_id'    => 'wx3cf0f39249eb0exxx',
    'secret'    => 'f1c242f4f28f735d4687abb469072xxx',
    'token'     => 'powerwechat',
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log',
    ],
    // ...
];

$app = Factory::officialAccount($options);

$server = $app->server;
$user = $app->user;

$server->push(function($message) use ($user) {
    $fromUser = $user->get($message['FromUserName']);

    return "{$fromUser->nickname} 您好！欢迎关注 PowerWeChat!";
});

$server->serve()->send();
```


## Contribution

[Contribution Guide](.github/CONTRIBUTING.md)

## License

MIT
