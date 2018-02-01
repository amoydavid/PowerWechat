<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OfficialAccount\Server;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\OfficialAccount\Server\Guard;
use PowerWeChat\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;

class GuardTest extends TestCase
{
    public function testShouldReturnRawResponse()
    {
        $request = Request::create('/path/to/server?foo=bar');
        $app = new ServiceContainer([], ['request' => $request]);
        $guard = \Mockery::mock(Guard::class, [$app])->makePartial();
        $this->assertFalse($guard->shouldReturnRawResponse());

        $request = Request::create('/path/to/server?echostr=hello');
        $app = new ServiceContainer([], ['request' => $request]);
        $guard = \Mockery::mock(Guard::class, [$app])->makePartial();
        $this->assertTrue($guard->shouldReturnRawResponse());
    }
}
