<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Work\Server\Handlers;

use PowerWeChat\Kernel\Decorators\FinallyResult;
use PowerWeChat\Kernel\Encryptor;
use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\Tests\TestCase;
use PowerWeChat\Work\Server\Handlers\EchoStrHandler;
use Symfony\Component\HttpFoundation\Request;

class EchoStrHandlerTest extends TestCase
{
    public function testHandle()
    {
        $time = time();
        $nonce = 'foo';
        $signature = 'mock-signature';
        $request = Request::create('/path/to/resource?foo=bar', 'GET', [
            'timestamp' => $time,
            'nonce' => $nonce,
            'msg_signature' => $signature,
            'echostr' => 'mock-encrypted-echostr',
        ]);
        $encryptor = \Mockery::mock(Encryptor::class);
        $encryptor->allows()->decrypt('mock-encrypted-echostr', $signature, $nonce, $time)->andReturn('mock-decrypted-echostr');
        $app = new ServiceContainer([], [
            'request' => $request,
            'encryptor' => $encryptor,
        ]);
        $handler = new EchoStrHandler($app);

        $result = $handler->handle();
        $this->assertInstanceOf(FinallyResult::class, $result);
        $this->assertSame('mock-decrypted-echostr', $result->content);
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
