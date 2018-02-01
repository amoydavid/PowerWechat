<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Work\OAuth;

use PowerWeChat\Kernel\AccessToken;
use PowerWeChat\Tests\TestCase;
use PowerWeChat\Work\Application;
use PowerWeChat\Work\OAuth\AccessTokenDelegate;

class AccessTokenDelegateTest extends TestCase
{
    public function testGetToken()
    {
        $accessToken = \Mockery::mock(AccessToken::class);
        $accessToken->allows()->getToken()->andReturn(['access_token' => 'mock-token']);

        $delegate = new AccessTokenDelegate(new Application([], [
            'access_token' => $accessToken,
        ]));

        $this->assertSame('mock-token', $delegate->getToken());
    }
}
