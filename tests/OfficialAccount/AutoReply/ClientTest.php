<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OfficialAccount\AutoReply;

use PowerWeChat\OfficialAccount\AutoReply\Client;
use PowerWeChat\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testCurrent()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/get_current_autoreply_info')->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->current());
    }
}
