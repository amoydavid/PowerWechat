<?php
/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PowerWeChat\MiniProgram\Plugin;
use PowerWeChat\Kernel\BaseClient;
/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * @param string $appId
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function apply($appId)
    {
        return $this->httpPostJson('wxa/plugin', [
            'action' => 'apply',
            'plugin_appid' => $appId,
        ]);
    }
    /**
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function list()
    {
        return $this->httpPostJson('wxa/plugin', [
            'action' => 'list',
        ]);
    }
    /**
     * @param string $appId
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function unbind($appId)
    {
        return $this->httpPostJson('wxa/plugin', [
            'action' => 'unbind',
            'plugin_appid' => $appId,
        ]);
    }

    /**
     * @param $appId
     * @param $user_version
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function update($appId,$user_version)
    {
        return $this->httpPostJson('wxa/plugin', [
            'action' => 'update',
            'user_version'=>$user_version,
            'plugin_appid' => $appId,
        ]);
    }
    
}