<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Payment\Security;

use PowerWeChat\Payment\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author overtrue <i@overtrue.me>
 */
class Client extends BaseClient
{
    /**
     * @return mixed
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getPublicKey()
    {
        $params = [
            'sign_type' => 'MD5',
        ];

        return $this->safeRequest('https://fraud.mch.weixin.qq.com/risk/getpublickey', $params);
    }
}
