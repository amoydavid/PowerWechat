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

use PowerWeChat\OfficialAccount\ShakeAround\Client;
use PowerWeChat\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testRegister()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpPostJson('shakearound/account/register', ['foo' => 'bar'])->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->register(['foo' => 'bar']));
    }

    public function testStatus()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('shakearound/account/auditstatus')->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->status());
    }

    public function testUser()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('shakearound/user/getshakeinfo', ['ticket' => 'mock-ticket'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->user('mock-ticket'));

        $client->expects()->httpGet('shakearound/user/getshakeinfo', ['ticket' => 'mock-ticket', 'need_poi' => 1])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->user('mock-ticket', true));

        $client->expects()->httpGet('shakearound/user/getshakeinfo', ['ticket' => 'mock-ticket', 'need_poi' => 1])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->userWithPoi('mock-ticket', true));
    }
}
