<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Kernel\Events;

use PowerWeChat\Kernel\AccessToken;

/**
 * Class AccessTokenRefreshed.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class AccessTokenRefreshed
{
    /**
     * @var \PowerWeChat\Kernel\AccessToken
     */
    public $accessToken;

    /**
     * @param \PowerWeChat\Kernel\AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
