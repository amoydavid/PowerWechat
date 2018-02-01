<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OpenPlatform\Server;

use PowerWeChat\OpenPlatform\Application;
use PowerWeChat\OpenPlatform\Server\Guard;
use PowerWeChat\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GuardTest extends TestCase
{
    public function testResolve()
    {
        $request = Request::create('/path/to/resource', 'POST', [], [], [], [
        'CONTENT_TYPE' => ['application/xml'],
    ], '<xml><AppId>wx-appid</AppId><InfoType>component_verify_ticket</InfoType></xml>');

        $app = new Application([], [
            'request' => $request,
        ]);
        $guard = \Mockery::mock(Guard::class, [$app])->makePartial();

        $this->assertInstanceOf(Response::class, $guard->resolve());
        $this->assertSame('success', $guard->resolve()->getContent());
    }
}
