<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OfficialAccount\ShakeAround;

use PowerWeChat\Kernel\Exceptions\InvalidArgumentException;
use PowerWeChat\OfficialAccount\Application;
use PowerWeChat\OfficialAccount\ShakeAround\Client;
use PowerWeChat\OfficialAccount\ShakeAround\DeviceClient;
use PowerWeChat\OfficialAccount\ShakeAround\GroupClient;
use PowerWeChat\OfficialAccount\ShakeAround\MaterialClient;
use PowerWeChat\OfficialAccount\ShakeAround\RelationClient;
use PowerWeChat\OfficialAccount\ShakeAround\ShakeAround;
use PowerWeChat\OfficialAccount\ShakeAround\StatsClient;
use PowerWeChat\Tests\TestCase;

class ShakeAroundTest extends TestCase
{
    public function testInstances()
    {
        $app = new Application();
        $shakeAround = new ShakeAround($app);

        $this->assertInstanceOf(Client::class, $shakeAround);
        $this->assertInstanceOf(DeviceClient::class, $shakeAround->device);
        $this->assertInstanceOf(GroupClient::class, $shakeAround->group);
        $this->assertInstanceOf(MaterialClient::class, $shakeAround->material);
        $this->assertInstanceOf(RelationClient::class, $shakeAround->relation);
        $this->assertInstanceOf(StatsClient::class, $shakeAround->stats);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No shake_around service named "foo".', $shakeAround->foo);
    }
}
