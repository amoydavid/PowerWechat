<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OpenPlatform\Authorizer\Aggregate\Account;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\OpenPlatform\Authorizer\Aggregate\Account\Client;
use PowerWeChat\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testCreate()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));

        $client->expects()->httpPostJson('cgi-bin/open/create', ['appid' => 'app-id'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->create());
    }

    public function testBindTo()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));

        $client->expects()->httpPostJson('cgi-bin/open/bind', ['appid' => 'app-id', 'open_appid' => 'open-app-id'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->bindTo('open-app-id'));
    }

    public function testUnbindFrom()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));

        $client->expects()->httpPostJson('cgi-bin/open/unbind', ['appid' => 'app-id', 'open_appid' => 'open-app-id'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->unbindFrom('open-app-id'));
    }

    public function testGetBinding()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));

        $client->expects()->httpPostJson('cgi-bin/open/get', ['appid' => 'app-id'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->getBinding());
    }
}
