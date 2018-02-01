<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Work\Base;

use PowerWeChat\Tests\TestCase;
use PowerWeChat\Work\Base\Client;

class ClientTest extends TestCase
{
    public function testGetCallbackIp()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('cgi-bin/getcallbackip')->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->getCallbackIp());
    }
}
