<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OfficialAccount\Card;

use PowerWeChat\Kernel\Exceptions\InvalidArgumentException;

/**
 * Class Card.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @property \PowerWeChat\OfficialAccount\Card\CodeClient $code
 * @property \PowerWeChat\OfficialAccount\Card\MeetingTicketClient $meeting_ticket
 * @property \PowerWeChat\OfficialAccount\Card\MemberCardClient $member_card
 * @property \PowerWeChat\OfficialAccount\Card\GeneralCardClient $general_card
 * @property \PowerWeChat\OfficialAccount\Card\MovieTicketClient $movie_ticket
 * @property \PowerWeChat\OfficialAccount\Card\CoinClient $coin
 * @property \PowerWeChat\OfficialAccount\Card\SubMerchantClient $sub_merchant
 * @property \PowerWeChat\OfficialAccount\Card\BoardingPassClient $boarding_pass
 * @property \PowerWeChat\OfficialAccount\Card\JssdkClient $jssdk
 */
class Card extends Client
{
    /**
     * @param string $property
     *
     * @return mixed
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function __get($property)
    {
        if (isset($this->app["card.{$property}"])) {
            return $this->app["card.{$property}"];
        }

        throw new InvalidArgumentException(sprintf('No card service named "%s".', $property));
    }
}
