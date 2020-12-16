<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Payment\Marketing;

use PowerWeChat\Payment\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Pay the order.
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function reduceCoupon(array $params)
    {
        $params['appid'] = $this->app['config']->app_id;

        $openid = $params['openid'] ?? '';
        unset($params['openid']);

        return $this->request($this->wrap("v3/marketing/favor/users/{$openid}/coupons"), $params);
    }

    /**
     * Get openid by auth code.
     *
     * @param string $authCode
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function authCodeToOpenid(string $authCode)
    {
        return $this->request('tools/authcodetoopenid', [
            'appid' => $this->app['config']->app_id,
            'auth_code' => $authCode,
        ]);
    }
}
