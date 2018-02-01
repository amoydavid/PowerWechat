<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OpenPlatform\Authorizer\Server;

use PowerWeChat\Kernel\ServerGuard;

/**
 * Class Guard.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Guard extends ServerGuard
{
    /**
     * Get token from OpenPlatform encryptor.
     *
     * @return string
     */
    protected function getToken()
    {
        return $this->app['encryptor']->getToken();
    }
}
