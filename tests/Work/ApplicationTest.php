<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Work;

use PowerWeChat\Tests\TestCase;
use PowerWeChat\Work\Application;
use PowerWeChat\Work\Base\Client;

class ApplicationTest extends TestCase
{
    public function testInstances()
    {
        $app = new Application([
            'corp_id' => 'xwnaka223',
            'agent_id' => 102093,
            'secret' => 'secret',
        ]);

        $this->assertInstanceOf(\PowerWeChat\Work\OA\Client::class, $app->oa);
        $this->assertInstanceOf(\PowerWeChat\Work\Auth\AccessToken::class, $app->access_token);
        $this->assertInstanceOf(\PowerWeChat\Work\Agent\Client::class, $app->agent);
        $this->assertInstanceOf(\PowerWeChat\Work\Department\Client::class, $app->department);
        $this->assertInstanceOf(\PowerWeChat\Work\Media\Client::class, $app->media);
        $this->assertInstanceOf(\PowerWeChat\Work\Menu\Client::class, $app->menu);
        $this->assertInstanceOf(\PowerWeChat\Work\Message\Client::class, $app->message);
        $this->assertInstanceOf(\PowerWeChat\Work\Message\Messenger::class, $app->messenger);
        $this->assertInstanceOf(\PowerWeChat\Work\Server\Guard::class, $app->server);
        $this->assertInstanceOf(\PowerWeChat\BasicService\Jssdk\Client::class, $app->jssdk);
        $this->assertInstanceOf(\Overtrue\Socialite\Providers\WeWorkProvider::class, $app->oauth);
    }

    public function testBaseCall()
    {
        $client = \Mockery::mock(Client::class);
        $client->expects()->getCallbackIp(1, 2, 3)->andReturn('mock-result');

        $app = new Application([]);
        $app['base'] = $client;

        $this->assertSame('mock-result', $app->getCallbackIp(1, 2, 3));
    }
}
