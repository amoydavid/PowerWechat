<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OpenPlatform\Authorizer\MiniProgram\Tester;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Tester\Client;
use PowerWeChat\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testBind()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpPostJson('wxa/bind_tester', ['wechatid' => 'bar'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->bind('bar'));
    }

    public function testUnbind()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpPostJson('wxa/unbind_tester', ['wechatid' => 'bar'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->unbind('bar'));
    }
}
