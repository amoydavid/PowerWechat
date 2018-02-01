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

use PowerWeChat\OfficialAccount\Card\MovieTicketClient;
use PowerWeChat\Tests\TestCase;

class MovieTicketClientTest extends TestCase
{
    public function testUpdateUser()
    {
        $client = $this->mockApiClient(MovieTicketClient::class);

        $client->expects()->httpPostJson('card/movieticket/updateuser', ['foo' => 'bar'])->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->updateUser(['foo' => 'bar']));
    }
}
