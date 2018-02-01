<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Work\Auth;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\Tests\TestCase;
use PowerWeChat\Work\Auth\AccessToken;

class AccessTokenTest extends TestCase
{
    public function testGetCredentials()
    {
        $app = new ServiceContainer([
            'corp_id' => '1234',
            'secret' => 'secret',
        ]);
        $accessToken = \Mockery::mock(AccessToken::class, [$app])->makePartial()->shouldAllowMockingProtectedMethods();

        $this->assertSame([
            'corpid' => '1234',
            'corpsecret' => 'secret',
        ], $accessToken->getCredentials());
    }

    public function testEndpoint()
    {
        $this->assertSame('cgi-bin/gettoken', (new AccessToken(new ServiceContainer()))->getEndpoint());
    }
}
