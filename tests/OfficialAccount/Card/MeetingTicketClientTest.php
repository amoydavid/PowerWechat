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

use PowerWeChat\OfficialAccount\Card\MeetingTicketClient;
use PowerWeChat\Tests\TestCase;

class MeetingTicketClientTest extends TestCase
{
    public function testUpdateUser()
    {
        $client = $this->mockApiClient(MeetingTicketClient::class);

        $params = [
            'foo' => 'bar',
        ];
        $client->expects()->httpPostJson('card/meetingticket/updateuser', $params)->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->updateUser($params));
    }
}
