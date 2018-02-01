<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OpenPlatform\Authorizer\MiniProgram\Domain;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Domain\Client;
use PowerWeChat\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testModify()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));

        $client->expects()->httpPostJson('wxa/modify_domain', ['foo' => 'bar'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->modify(['foo' => 'bar']));
    }
}
