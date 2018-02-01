<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OpenPlatform;

use PowerWeChat\OpenPlatform\Server\Handlers\Unauthorized;
use PowerWeChat\Tests\TestCase;

class UnauthorizedTest extends TestCase
{
    public function testHandle()
    {
        $handler = new Unauthorized();

        $this->assertNull($handler->handle());
    }
}
