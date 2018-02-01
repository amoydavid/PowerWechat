<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OpenPlatform\Auth;

use PowerWeChat\OpenPlatform\Application;
use PowerWeChat\OpenPlatform\Auth\VerifyTicket;
use PowerWeChat\Tests\TestCase;
use Psr\SimpleCache\CacheInterface;

class VerifyTicketTest extends TestCase
{
    public function testSetTicket()
    {
        $client = \Mockery::mock(VerifyTicket::class.'[getCache]', [new Application(['app_id' => 'app-id'])], function ($mock) {
            $cache = \Mockery::mock(CacheInterface::class, function ($mock) {
                $mock->expects()->set('easywechat.open_platform.verify_ticket.app-id', 'ticket@654321', 3600)->once();
            });
            $mock->allows()->getCache()->andReturn($cache);
        });

        $this->assertInstanceOf(VerifyTicket::class, $client->setTicket('ticket@654321'));
    }

    public function testGetTicket()
    {
        $client = \Mockery::mock(VerifyTicket::class.'[getCache]', [new Application(['app_id' => 'app-id'])], function ($mock) {
            $cache = \Mockery::mock(CacheInterface::class, function ($mock) {
                $mock->expects()->get('easywechat.open_platform.verify_ticket.app-id')->andReturn('ticket@123456')->once();
            });
            $mock->allows()->getCache()->andReturn($cache);
        });

        $this->assertSame('ticket@123456', $client->getTicket());
    }

    public function testGetTicketAndThrowException()
    {
        $client = \Mockery::mock(VerifyTicket::class.'[getCache]', [new Application(['app_id' => 'app-id'])], function ($mock) {
            $cache = \Mockery::mock(CacheInterface::class, function ($mock) {
                $mock->expects()->get('easywechat.open_platform.verify_ticket.app-id')->andReturn(null)->once();
            });
            $mock->allows()->getCache()->andReturn($cache);
        });

        $this->expectException('PowerWeChat\Kernel\Exceptions\RuntimeException');
        $this->expectExceptionMessage('Credential "component_verify_ticket" does not exist in cache.');
        $client->getTicket();
    }
}
