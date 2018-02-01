<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\MiniProgram\Sns;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\MiniProgram\Auth\Client;
use PowerWeChat\Tests\TestCase;

class AuthTest extends TestCase
{
    public function testGetSessionKey()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id', 'secret' => 'mock-secret']));

        $client->expects()->httpGet('sns/jscode2session', [
            'appid' => 'app-id',
            'secret' => 'mock-secret',
            'js_code' => 'js-code',
            'grant_type' => 'authorization_code',
        ])->andReturn('mock-result')->once();

        $this->assertSame('mock-result', $client->session('js-code'));
    }
}
