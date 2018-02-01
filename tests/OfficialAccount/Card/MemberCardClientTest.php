<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OfficialAccount\Card;

use PowerWeChat\OfficialAccount\Card\MemberCardClient;
use PowerWeChat\Tests\TestCase;

class MemberCardClientTest extends TestCase
{
    public function testActivate()
    {
        $client = $this->mockApiClient(MemberCardClient::class);

        $params = [
            'foo' => 'bar',
        ];
        $client->expects()->httpPostJson('card/membercard/activate', $params)->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->activate($params));
    }

    public function testSetActivateForm()
    {
        $client = $this->mockApiClient(MemberCardClient::class);

        $params = [
            'card_id' => 'mock-card-id',
            'foo' => 'bar',
        ];
        $client->expects()->httpPostJson('card/membercard/activateuserform/set', $params)->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->setActivationForm('mock-card-id', $params));
    }

    public function testGetUser()
    {
        $client = $this->mockApiClient(MemberCardClient::class);

        $params = [
            'card_id' => 'mock-card-id',
            'code' => 'mock-code',
        ];
        $client->expects()->httpPostJson('card/membercard/userinfo/get', $params)->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->getUser('mock-card-id', 'mock-code'));
    }

    public function testUpdateUser()
    {
        $client = $this->mockApiClient(MemberCardClient::class);

        $client->expects()->httpPostJson('card/membercard/updateuser', ['foo' => 'bar'])->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->updateUser(['foo' => 'bar']));
    }
}
