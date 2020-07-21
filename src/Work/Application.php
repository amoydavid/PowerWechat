<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Work;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\Work\MiniProgram\Application as MiniProgram;

/**
 * Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \PowerWeChat\Work\OA\Client                        $oa
 * @property \PowerWeChat\Work\Auth\AccessToken                 $access_token
 * @property \PowerWeChat\Work\Agent\Client                     $agent
 * @property \PowerWeChat\Work\Department\Client                $department
 * @property \PowerWeChat\Work\Media\Client                     $media
 * @property \PowerWeChat\Work\Menu\Client                      $menu
 * @property \PowerWeChat\Work\Message\Client                   $message
 * @property \PowerWeChat\Work\Message\Messenger                $messenger
 * @property \PowerWeChat\Work\User\Client                      $user
 * @property \PowerWeChat\Work\User\TagClient                   $tag
 * @property \PowerWeChat\Work\Server\Guard                     $server
 * @property \PowerWeChat\Work\Jssdk\Client                     $jssdk
 * @property \Overtrue\Socialite\Providers\WeWork              $oauth
 * @property \PowerWeChat\Work\Invoice\Client                   $invoice
 * @property \PowerWeChat\Work\Chat\Client                      $chat
 * @property \PowerWeChat\Work\ExternalContact\Client           $external_contact
 * @property \PowerWeChat\Work\ExternalContact\ContactWayClient $contact_way
 * @property \PowerWeChat\Work\ExternalContact\StatisticsClient $external_contact_statistics
 * @property \PowerWeChat\Work\ExternalContact\MessageClient    $external_contact_message
 * @property \PowerWeChat\Work\GroupRobot\Client                $group_robot
 * @property \PowerWeChat\Work\GroupRobot\Messenger             $group_robot_messenger
 * @property \PowerWeChat\Work\Calendar\Client                  $calendar
 * @property \PowerWeChat\Work\Schedule\Client                  $schedule
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
        Invoice\ServiceProvider::class,
        Chat\ServiceProvider::class,
        ExternalContact\ServiceProvider::class,
        GroupRobot\ServiceProvider::class,
        Calendar\ServiceProvider::class,
        Schedule\ServiceProvider::class,
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
     * Creates the miniProgram application.
     *
     * @return \PowerWeChat\Work\MiniProgram\Application
     */
    public function miniProgram(): MiniProgram
    {
        return new MiniProgram($this->getConfig());
    }

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
