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

use PowerWeChat\OfficialAccount\Card\BoardingPassClient;
use PowerWeChat\Tests\TestCase;

class BoardingPassClientTest extends TestCase
{
    public function testCheckin()
    {
        $client = $this->mockApiClient(BoardingPassClient::class);

        $params = [
            'foo' => 'bar',
        ];
        $client->expects()->httpPostJson('card/boardingpass/checkin', $params)->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->checkin($params));
    }
}
