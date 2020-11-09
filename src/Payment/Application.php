<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Payment;

use Closure;
use PowerWeChat\BasicService;
use PowerWeChat\Kernel\Exceptions\InvalidArgumentException;
use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\Kernel\Support;
use PowerWeChat\OfficialAccount;

/**
 * Class Application.
 *
 * @property \PowerWeChat\Payment\Bill\Client               $bill
 * @property \PowerWeChat\Payment\Jssdk\Client              $jssdk
 * @property \PowerWeChat\Payment\Order\Client              $order
 * @property \PowerWeChat\Payment\Refund\Client             $refund
 * @property \PowerWeChat\Payment\Coupon\Client             $coupon
 * @property \PowerWeChat\Payment\Reverse\Client            $reverse
 * @property \PowerWeChat\Payment\Redpack\Client            $redpack
 * @property \PowerWeChat\BasicService\Url\Client           $url
 * @property \PowerWeChat\Payment\Transfer\Client           $transfer
 * @property \PowerWeChat\Payment\Security\Client           $security
 * @property \PowerWeChat\Payment\Merchant\Client           $merchant
 * @property \PowerWeChat\Payment\ProfitSharing\Client      $profit_sharing
 * @property \PowerWeChat\OfficialAccount\Auth\AccessToken  $access_token
 *
 * @method mixed pay(array $attributes)
 * @method mixed authCodeToOpenid(string $authCode)
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        OfficialAccount\Auth\ServiceProvider::class,
        BasicService\Url\ServiceProvider::class,
        Base\ServiceProvider::class,
        Bill\ServiceProvider::class,
        Coupon\ServiceProvider::class,
        Jssdk\ServiceProvider::class,
        Merchant\ServiceProvider::class,
        Order\ServiceProvider::class,
        Redpack\ServiceProvider::class,
        Refund\ServiceProvider::class,
        Reverse\ServiceProvider::class,
        Sandbox\ServiceProvider::class,
        Transfer\ServiceProvider::class,
        Security\ServiceProvider::class,
        ProfitSharing\ServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected $defaultConfig = [
        'http' => [
            'base_uri' => 'https://api.mch.weixin.qq.com/',
        ],
    ];

    /**
     * Build payment scheme for product.
     *
     * @param string $productId
     *
     * @return string
     */
    public function scheme(string $productId): string
    {
        $params = [
            'appid' => $this['config']->app_id,
            'mch_id' => $this['config']->mch_id,
            'time_stamp' => time(),
            'nonce_str' => uniqid(),
            'product_id' => $productId,
        ];

        $params['sign'] = Support\generate_sign($params, $this['config']->key);

        return 'weixin://wxpay/bizpayurl?'.http_build_query($params);
    }

    /**
     * @param string $codeUrl
     *
     * @return string
     */
    public function codeUrlScheme(string $codeUrl)
    {
        return \sprintf('weixin://wxpay/bizpayurl?sr=%s', $codeUrl);
    }

    /**
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @codeCoverageIgnore
     *
     * @throws \PowerWeChat\Kernel\Exceptions\Exception
     */
    public function handlePaidNotify(Closure $closure)
    {
        return (new Notify\Paid($this))->handle($closure);
    }

    /**
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @codeCoverageIgnore
     *
     * @throws \PowerWeChat\Kernel\Exceptions\Exception
     */
    public function handleRefundedNotify(Closure $closure)
    {
        return (new Notify\Refunded($this))->handle($closure);
    }

    /**
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @codeCoverageIgnore
     *
     * @throws \PowerWeChat\Kernel\Exceptions\Exception
     */
    public function handleScannedNotify(Closure $closure)
    {
        return (new Notify\Scanned($this))->handle($closure);
    }

    /**
     * Set sub-merchant.
     *
     * @param string      $mchId
     * @param string|null $appId
     *
     * @return $this
     */
    public function setSubMerchant(string $mchId, string $appId = null)
    {
        $this['config']->set('sub_mch_id', $mchId);
        $this['config']->set('sub_appid', $appId);

        return $this;
    }

    /**
     * @return bool
     */
    public function inSandbox(): bool
    {
        return (bool) $this['config']->get('sandbox');
    }

    /**
     * @param string|null $endpoint
     *
     * @return string
     *
     * @throws \PowerWechat\Kernel\Exceptions\InvalidArgumentException
     */
    public function getKey(string $endpoint = null)
    {
        if ('sandboxnew/pay/getsignkey' === $endpoint) {
            return $this['config']->key;
        }
        $key = $this->inSandbox() ? $this['sandbox']->getKey() : $this['config']->key;
        if (32 !== strlen($key)) {
            throw new InvalidArgumentException(sprintf("'%s' should be 32 chars length.", $key));
        }
        return $key;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this['base'], $name], $arguments);
    }
}
