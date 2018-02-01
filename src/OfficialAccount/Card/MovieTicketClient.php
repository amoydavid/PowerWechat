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

/**
 * Class MovieTicketClient.
 *
 * @author overtrue <i@overtrue.me>
 */
class MovieTicketClient extends Client
{
    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     */
    public function updateUser(array $params)
    {
        return $this->httpPostJson('card/movieticket/updateuser', $params);
    }
}
