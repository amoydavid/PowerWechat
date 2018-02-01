<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OpenPlatform\Server\Handlers;

use PowerWeChat\Kernel\Contracts\EventHandlerInterface;

/**
 * Class Authorized.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Authorized implements EventHandlerInterface
{
    /**
     * {@inheritdoc}.
     */
    public function handle($payload = null)
    {
        // Do nothing for the time being.
    }
}
