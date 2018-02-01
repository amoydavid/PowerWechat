<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Work;

use PowerWeChat\Kernel\ServiceContainer;

/**
 * Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \PowerWeChat\Work\OA\Client                   $oa
 * @property \PowerWeChat\Work\Auth\AccessToken            $access_token
 * @property \PowerWeChat\Work\Agent\Client                $agent
 * @property \PowerWeChat\Work\Department\Client           $department
 * @property \PowerWeChat\Work\Media\Client                $media
 * @property \PowerWeChat\Work\Menu\Client                 $menu
 * @property \PowerWeChat\Work\Message\Client              $message
 * @property \PowerWeChat\Work\Message\Messenger           $messenger
 * @property \PowerWeChat\Work\User\Client                 $user
 * @property \PowerWeChat\Work\User\TagClient              $tag
 * @property \PowerWeChat\Work\Server\ServiceProvider      $server
 * @property \PowerWeChat\BasicService\Jssdk\Client        $jssdk
 * @property \Overtrue\Socialite\Providers\WeWorkProvider $oauth
 *
 * @method mixed getCallbackIp()
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        OA\ServiceProvider::class,
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Menu\ServiceProvider::class,
        OAuth\ServiceProvider::class,
        User\ServiceProvider::class,
        Agent\ServiceProvider::class,
        Media\ServiceProvider::class,
        Message\ServiceProvider::class,
        Department\ServiceProvider::class,
        Server\ServiceProvider::class,
        Jssdk\ServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected $defaultConfig = [
        // http://docs.guzzlephp.org/en/stable/request-options.html
        'http' => [
            'base_uri' => 'https://qyapi.weixin.qq.com/',
        ],
    ];

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return $this['base']->$method(...$arguments);
    }
}
