<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OpenWork;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\OpenWork\Work\Application as Work;

/**
 * Application.
 *
 * @author xiaomin <keacefull@gmail.com>
 *
 * @property \PowerWeChat\OpenWork\Server\Guard            $server
 * @property \PowerWeChat\OpenWork\Corp\Client             $corp
 * @property \PowerWeChat\OpenWork\Provider\Client         $provider
 * @property \PowerWeChat\OpenWork\SuiteAuth\AccessToken   $suite_access_token
 * @property \PowerWeChat\OpenWork\Auth\AccessToken        $provider_access_token
 * @property \PowerWeChat\OpenWork\SuiteAuth\SuiteTicket   $suite_ticket
 * @property \PowerWeChat\OpenWork\MiniProgram\Auth\Client $mini_program
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        SuiteAuth\ServiceProvider::class,
        Server\ServiceProvider::class,
        Corp\ServiceProvider::class,
        Provider\ServiceProvider::class,
        MiniProgram\ServiceProvider::class,
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
    public function miniProgram(): \PowerWeChat\Work\MiniProgram\Application
    {
        return new \PowerWeChat\Work\MiniProgram\Application($this->getConfig());
    }

    /**
     * @param string $authCorpId    企业 corp_id
     * @param string $permanentCode 企业永久授权码
     *
     * @return Work
     */
    public function work(string $authCorpId, string $permanentCode): Work
    {
        return new Work($authCorpId, $permanentCode, $this);
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
