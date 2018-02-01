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

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\OpenPlatform\Auth\AccessToken;
use PowerWeChat\OpenPlatform\Auth\VerifyTicket;
use PowerWeChat\Tests\TestCase;

class AccessTokenTest extends TestCase
{
    public function testGetCredentials()
    {
        $verifyTicket = \Mockery::mock(VerifyTicket::class, function ($mock) {
            $mock->expects()->getTicket()->andReturn('ticket@123456')->once();
        });

        $app = new ServiceContainer([
            'app_id' => 'mock-app-id',
            'secret' => 'mock-secret',
        ], ['verify_ticket' => $verifyTicket]);
        $token = \Mockery::mock(AccessToken::class, [$app])->makePartial()->shouldAllowMockingProtectedMethods();

        $this->assertSame([
            'component_appid' => 'mock-app-id',
            'component_appsecret' => 'mock-secret',
            'component_verify_ticket' => 'ticket@123456',
        ], $token->getCredentials());
    }
}
