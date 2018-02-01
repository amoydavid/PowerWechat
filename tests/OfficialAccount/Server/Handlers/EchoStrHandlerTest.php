<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OfficialAccount\Server\Handlers;

use PowerWeChat\Kernel\Decorators\FinallyResult;
use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\OfficialAccount\Server\Handlers\EchoStrHandler;
use PowerWeChat\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;

class EchoStrHandlerTest extends TestCase
{
    public function testHandle()
    {
        $request = Request::create('/path/to/resource?echostr=mock-echostr');

        $app = new ServiceContainer([], [
            'request' => $request,
        ]);
        $handler = new EchoStrHandler($app);

        $result = $handler->handle();
        $this->assertInstanceOf(FinallyResult::class, $result);
        $this->assertSame('mock-echostr', $result->content);
    }

    public function testHandleWithoutEchoStr()
    {
        $request = Request::create('/path/to/resource?foo=bar');
        $app = new ServiceContainer([], [
            'request' => $request,
        ]);
        $handler = new EchoStrHandler($app);

        $this->assertNull($handler->handle());
    }
}
