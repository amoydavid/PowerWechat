<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\MiniProgram;

use PowerWeChat\BasicService;
use PowerWeChat\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \PowerWeChat\MiniProgram\Auth\AccessToken            $access_token
 * @property \PowerWeChat\MiniProgram\DataCube\Client             $data_cube
 * @property \PowerWeChat\MiniProgram\AppCode\Client              $app_code
 * @property \PowerWeChat\MiniProgram\Auth\Client                 $auth
 * @property \PowerWeChat\OfficialAccount\Server\Guard            $server
 * @property \PowerWeChat\MiniProgram\Encryptor                   $encryptor
 * @property \PowerWeChat\MiniProgram\Plugin\Client               $plugin
 * @property \PowerWeChat\MiniProgram\Mall\Client                 $mall
 * @property \PowerWeChat\MiniProgram\TemplateMessage\Client      $template_message
 * @property \PowerWeChat\MiniProgram\SubscribeMessage\Client     $subscribe_message
 * @property \PowerWeChat\OfficialAccount\CustomerService\Client  $customer_service
 * @property \PowerWeChat\BasicService\Media\Client               $media
 * @property \PowerWeChat\MiniProgram\Message\Client              $message
 * @property \PowerWeChat\BasicService\ContentSecurity\Client     $content_security
 * @property \PowerWeChat\MiniProgram\UniformMessage\Client       $uniform_message
 * @property \PowerWeChat\MiniProgram\Business\Client             $business
 * @property \PowerWeChat\MiniProgram\Express\Client              $express
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        Server\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        SubscribeMessage\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        Message\ServiceProvider::class,
        UniformMessage\ServiceProvider::class,
        Plugin\ServiceProvider::class,
        Mall\ServiceProvider::class,
        Express\ServiceProvider::class,
        // Base services
        BasicService\Media\ServiceProvider::class,
        BasicService\ContentSecurity\ServiceProvider::class,
        Business\ServiceProvider::class,
    ];
}
