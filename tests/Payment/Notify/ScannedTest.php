<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Payment\Notify;

use PowerWeChat\Kernel\Support\XML;
use PowerWeChat\Payment\Application;
use PowerWeChat\Payment\Notify\Scanned;
use PowerWeChat\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ScannedTest extends TestCase
{
    private function makeApp($config = [])
    {
        return new Application(array_merge([
            'app_id' => 'mock-app-id',
            'mch_id' => 'mock-mch-id',
            'key' => 'foo-merchant-key',
        ], $config));
    }

    public function testScannedNotify()
    {
        $app = $this->makeApp();
        $app['request'] = Request::create('', 'POST', [], [], [], [], '<xml>
<foo>bar</foo>
<sign>280F9CB28E99DC917792FCC7AC1B88C4</sign>
</xml>');

        $notify = new Scanned($app);

        $that = $this;
        $response = $notify->handle(function ($message) use ($that) {
            $that->assertSame([
                'foo' => 'bar',
                'sign' => '280F9CB28E99DC917792FCC7AC1B88C4',
            ], $message);

            return 'prepay-id';
        });

        // return prepay_id.
        $this->assertInstanceOf(Response::class, $response);
        $result = XML::parse($response->getContent());
        $this->assertArrayHasKey('return_code', $result);
        $this->assertArrayHasKey('return_msg', $result);
        $this->assertArrayHasKey('result_code', $result);
        $this->assertArrayHasKey('err_code_des', $result);
        $this->assertArrayHasKey('appid', $result);
        $this->assertArrayHasKey('mch_id', $result);
        $this->assertArrayHasKey('nonce_str', $result);
        $this->assertArrayHasKey('prepay_id', $result);
        $this->assertArrayHasKey('sign', $result);

        $response = $notify->handle(function ($msg, $fail) {
            $fail('something-went-wrong...');
        });

        $this->assertArraySubset([
            'return_code' => 'FAIL',
            'return_msg' => 'something-went-wrong...',
            'result_code' => 'FAIL',
            'err_code_des' => null,
        ], XML::parse($response->getContent()));
    }

    public function testAlert()
    {
        $app = $this->makeApp();
        $app['request'] = Request::create('', 'POST', [], [], [], [], '<xml>
<foo>bar</foo>
</xml>');

        $notify = new Scanned($app);
        $response = $notify->handle(function ($msg, $fail, $alert) {
            $alert('sold out!');
        });

        $this->assertArraySubset([
            'return_code' => 'SUCCESS',
            'return_msg' => null,
            'result_code' => 'FAIL',
            'err_code_des' => 'sold out!',
        ], XML::parse($response->getContent()));
    }
}
