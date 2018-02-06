<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Payment\Transfer;

use PowerWeChat\Kernel\Exceptions\InvalidConfigException;
use PowerWeChat\Kernel\Exceptions\RuntimeException;
use PowerWeChat\Payment\Kernel\BaseClient;
use function PowerWeChat\Kernel\Support\get_server_ip;
use function PowerWeChat\Kernel\Support\rsa_public_encrypt;

/**
 * Class Client.
 *
 * @author AC <alexever@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Query MerchantPay to balance.
     *
     * @param string $partnerTradeNo
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function queryBalanceOrder(string $partnerTradeNo)
    {
        $params = [
            'appid' => $this->app['config']->app_id,
            'mch_id' => $this->app['config']->mch_id,
            'partner_trade_no' => $partnerTradeNo,
        ];

        return $this->safeRequest('mmpaymkttransfers/gettransferinfo', $params);
    }

    /**
     * Send MerchantPay to balance.
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function toBalance(array $params)
    {
        $base = [
            'mch_id' => null,
            'mchid' => $this->app['config']->mch_id,
            'mch_appid' => $this->app['config']->app_id,
        ];

        if (empty($params['spbill_create_ip'])) {
            $params['spbill_create_ip'] = get_server_ip();
        }

        return $this->safeRequest('mmpaymkttransfers/promotion/transfers', array_merge($base, $params));
    }

    /**
     * Query MerchantPay order to BankCard.
     *
     * @param string $partnerTradeNo
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function queryBankCardOrder(string $partnerTradeNo)
    {
        $params = [
            'mch_id' => $this->app['config']->mch_id,
            'partner_trade_no' => $partnerTradeNo,
        ];

        return $this->safeRequest('mmpaysptrans/query_bank', $params);
    }

    /**
     * Send MerchantPay to BankCard.
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \PowerWeChat\Kernel\Exceptions\RuntimeException
     */
    public function toBankCard(array $params)
    {
        foreach (['bank_code', 'partner_trade_no', 'enc_bank_no', 'enc_true_name', 'amount'] as $key) {
            if (empty($params[$key])) {
                throw new RuntimeException(\sprintf('"%s" is required.', $key));
            }
        }

        if($this->app['config']->get('auto_download_rsa_public_key') && $this->app['config']->get('rsa_public_key_dir')) {
            $publicKey = $this->autoGetRsaPemContent();
        } else {
            $publicKey = file_get_contents($this->app['config']->get('rsa_public_key_path'));
        }


        $params['enc_bank_no'] = rsa_public_encrypt($params['enc_bank_no'], $publicKey);
        $params['enc_true_name'] = rsa_public_encrypt($params['enc_true_name'], $publicKey);

        return $this->safeRequest('mmpaysptrans/pay_bank', $params);
    }


    /**
     * @return bool|string
     * @throws InvalidConfigException
     */
    private function autoGetRsaPemContent()
    {
        if(!($this->app['config']->get('auto_download_rsa_public_key') && $this->app['config']->get('rsa_public_key_dir'))) {
            return '';
        }
        $dir = $this->app['config']->get('rsa_public_key_dir');
        $file_path = $dir .'/mch.'.$this->app['config']->get('app_id').'.public.pem';
        $crt_path = $dir.'/mch.'.$this->app['config']->get('app_id').'.public.crt';
        if(!file_exists($crt_path)) {
            if(!file_exists($file_path)) {
                $fileDir = dirname($file_path);
                if (!is_dir($fileDir)) {
                    mkdir($fileDir, 0777, true);
                }
                $result = $this->publicKey();
                if($result['return_code'] != 'SUCCESS' || $result['result_code']!='SUCCESS') {
                    throw new InvalidConfigException('获得证书出错'.$result['return_msg'], 999999);
                }
                file_put_contents($file_path, $result['pub_key']);
            }
            @shell_exec('openssl rsa -RSAPublicKey_in -in '.$file_path.' -pubout -out '.$crt_path);
        }


        if(file_exists($crt_path)) {
            return file_get_contents($crt_path);
        } else {
            return '';
        }
    }


    /**
     * find a client public key
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws InvalidConfigException
     */
    public function publicKey()
    {
        $params = [
            'mch_id'=>$this->app['config']->mch_id
        ];

        return $this->safeRequest('https://fraud.mch.weixin.qq.com/risk/getpublickey', $params);
    }
}
