<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Test\OfficialAccount\Card;

use PowerWeChat\OfficialAccount\Application;
use PowerWeChat\OfficialAccount\Card\BoardingPassClient;
use PowerWeChat\OfficialAccount\Card\Card;
use PowerWeChat\OfficialAccount\Card\Client;
use PowerWeChat\OfficialAccount\Card\CodeClient;
use PowerWeChat\OfficialAccount\Card\CoinClient;
use PowerWeChat\OfficialAccount\Card\GeneralCardClient;
use PowerWeChat\OfficialAccount\Card\JssdkClient;
use PowerWeChat\OfficialAccount\Card\MeetingTicketClient;
use PowerWeChat\OfficialAccount\Card\MemberCardClient;
use PowerWeChat\OfficialAccount\Card\MovieTicketClient;
use PowerWeChat\OfficialAccount\Card\SubMerchantClient;
use PowerWeChat\Tests\TestCase;

class CardTest extends TestCase
{
    public function testBasicProperties()
    {
        $app = new Application();
        $card = new Card($app);

        $this->assertInstanceOf(Client::class, $card);
        $this->assertInstanceOf(BoardingPassClient::class, $card->boarding_pass);
        $this->assertInstanceOf(MeetingTicketClient::class, $card->meeting_ticket);
        $this->assertInstanceOf(MovieTicketClient::class, $card->movie_ticket);
        $this->assertInstanceOf(CoinClient::class, $card->coin);
        $this->assertInstanceOf(MemberCardClient::class, $card->member_card);
        $this->assertInstanceOf(GeneralCardClient::class, $card->general_card);
        $this->assertInstanceOf(CodeClient::class, $card->code);
        $this->assertInstanceOf(SubMerchantClient::class, $card->sub_merchant);
        $this->assertInstanceOf(JssdkClient::class, $card->jssdk);

        try {
            $card->foo;
            $this->fail('No expected exception thrown.');
        } catch (\Exception $e) {
            $this->assertSame('No card service named "foo".', $e->getMessage());
        }
    }
}
