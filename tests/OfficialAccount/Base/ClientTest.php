<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OfficialAccount\Base;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\OfficialAccount\Base\Client;
use PowerWeChat\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testClearQuota()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => '123456']));

        $client->expects()->httpPostJson('cgi-bin/clear_quota', [
            'appid' => '123456',
        ])->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->clearQuota());
    }

    public function testGetValidIps()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('cgi-bin/getcallbackip')->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->getValidIps());
    }
}
