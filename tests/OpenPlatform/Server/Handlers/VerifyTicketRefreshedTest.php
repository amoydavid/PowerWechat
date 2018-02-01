<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OpenPlatform;

use PowerWeChat\OpenPlatform\Application;
use PowerWeChat\OpenPlatform\Auth\VerifyTicket;
use PowerWeChat\OpenPlatform\Server\Handlers\VerifyTicketRefreshed;
use PowerWeChat\Tests\TestCase;

class VerifyTicketRefreshedTest extends TestCase
{
    public function testHandle()
    {
        $app = new Application();
        $app['verify_ticket'] = \Mockery::mock(VerifyTicket::class, function ($mock) {
            $mock->expects()->setTicket('ticket')->once();
        });
        $handler = new VerifyTicketRefreshed($app);

        $this->assertNull($handler->handle([
            'ComponentVerifyTicket' => 'ticket',
        ]));
    }
}
