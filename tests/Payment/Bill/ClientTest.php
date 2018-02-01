<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Payment\Bill;

use PowerWeChat\Kernel\Http\Response;
use PowerWeChat\Kernel\Http\StreamResponse;
use PowerWeChat\Payment\Application;
use PowerWeChat\Payment\Bill\Client;
use PowerWeChat\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $app = new Application([
            'app_id' => 'mock-appid',
            ]);

        $client = $this->mockApiClient(Client::class, ['download'], $app)->makePartial();

        $params = [
            'appid' => 'mock-appid',
            'bill_date' => 20171010,
            'bill_type' => 'ALL',
        ];
        // stream response
        $client->expects()->requestRaw('pay/downloadbill', $params)->andReturn(new Response(200, ['text/plain'], 'mock-content'))->once();
        $this->assertInstanceOf(StreamResponse::class, $client->get('20171010'));

        $response = new Response(200, ['Content-Type' => ['text/plain']], '<xml><return_code><![CDATA[FAIL]]></return_code>
<return_msg><![CDATA[invalid bill_date]]></return_msg>
<error_code><![CDATA[20001]]></error_code>
</xml>');
        $client->expects()->requestRaw('pay/downloadbill', $params)->andReturn($response)->once();

        $result = $client->get('20171010');
        $this->assertArraySubset([
            'return_code' => 'FAIL',
            'return_msg' => 'invalid bill_date',
            'error_code' => 20001,
        ], $result);
    }
}
