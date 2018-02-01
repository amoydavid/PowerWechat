<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OpenPlatform\Server\Handlers;

use PowerWeChat\Kernel\Contracts\EventHandlerInterface;
use PowerWeChat\OpenPlatform\Application;

/**
 * Class VerifyTicketRefreshed.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class VerifyTicketRefreshed implements EventHandlerInterface
{
    /**
     * @var \PowerWeChat\OpenPlatform\Application
     */
    protected $app;

    /**
     * Constructor.
     *
     * @param \PowerWeChat\OpenPlatform\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}.
     */
    public function handle($payload = null)
    {
        if (!empty($payload['ComponentVerifyTicket'])) {
            $this->app['verify_ticket']->setTicket($payload['ComponentVerifyTicket']);
        }
    }
}
