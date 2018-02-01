<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Payment;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\Payment\Application;
use PowerWeChat\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testMagicCall()
    {
        $app = new Application([
            'app_id' => 'wx123456',
            'mch_id' => 'foo-merchant-id',
        ]);

        $this->assertInstanceOf(\PowerWeChat\BasicService\Url\Client::class, $app->url);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Auth\AccessToken::class, $app->access_token);
        $this->assertInstanceOf(\PowerWeChat\Payment\Coupon\Client::class, $app->coupon);
        $this->assertInstanceOf(\PowerWeChat\Payment\Bill\Client::class, $app->bill);
        $this->assertInstanceOf(\PowerWeChat\Payment\Order\Client::class, $app->order);
        $this->assertInstanceOf(\PowerWeChat\Payment\Refund\Client::class, $app->refund);
        $this->assertInstanceOf(\PowerWeChat\Payment\Reverse\Client::class, $app->reverse);
        $this->assertInstanceOf(\PowerWeChat\Payment\Sandbox\Client::class, $app->sandbox);
        $this->assertInstanceOf(\PowerWeChat\Payment\Redpack\Client::class, $app->redpack);
        $this->assertInstanceOf(\PowerWeChat\Payment\Transfer\Client::class, $app->transfer);
        $this->assertInstanceOf(\PowerWeChat\Payment\Jssdk\Client::class, $app->jssdk);

        // test calling nonexistent method
        $this->expectException(\PHPUnit\Framework\Error\Warning::class);
        $app->noncexistentMethod('foo');
    }

    public function testScheme()
    {
        $app = new Application([
            'app_id' => 'wx123456',
            'mch_id' => 'foo-merchant-id',
        ]);

        $this->assertStringStartsWith('weixin://wxpay/bizpayurl?appid=wx123456&mch_id=foo-merchant-id&time_stamp=', $app->scheme('product-id'));
    }

    public function testSetSubMerchant()
    {
        $app = new Application([
            'app_id' => 'wx123456',
            'mch_id' => 'foo-merchant-id',
        ]);
        $this->assertInstanceOf(Application::class, $app->setSubMerchant('sub-mchid', 'sub-appid'));

        $this->assertSame('sub-mchid', $app->config['sub_mch_id']);
        $this->assertSame('sub-appid', $app->config['sub_appid']);
    }

    public function testInSandbox()
    {
        $app = new Application([
            'sandbox' => true,
        ]);
        $this->assertTrue($app->inSandbox());

        $app = new Application([]);
        $this->assertFalse($app->inSandbox());
    }

    public function testGetKey()
    {
        $app = new Application(['key' => 'mock-key']);
        $this->assertSame('mock-key', $app->getKey());
    }

    public function testGetKeyInSandboxMode()
    {
        $app = new Application([
            'sandbox' => true,
            'key' => 'keyxxx',
        ]);
        $sandbox = \Mockery::mock(\PowerWeChat\Payment\Sandbox\Client::class.'[getKey]', new ServiceContainer());
        $sandbox->expects()->getKey()->andReturn('123');
        $app['sandbox'] = $sandbox;

        $this->assertSame('123', $app->getKey('foo'));
        $this->assertSame('keyxxx', $app->getKey('sandboxnew/pay/getsignkey'));
    }
}
