<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Work\Message;

use PowerWeChat\Tests\TestCase;
use PowerWeChat\Work\Message\Client;
use PowerWeChat\Work\Message\Messenger;

class ClientTest extends TestCase
{
    public function testMessage()
    {
        $client = $this->mockApiClient(Client::class);

        $this->assertInstanceOf(Messenger::class, $client->message('hello'));
    }

    public function testSend()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpPostJson('cgi-bin/message/send', ['foo' => 'bar'])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->send(['foo' => 'bar']));
    }
}
