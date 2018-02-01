<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OpenPlatform\Authorizer\MiniProgram;

use PowerWeChat\MiniProgram\Application as MiniProgram;
use PowerWeChat\OpenPlatform\Authorizer\Aggregate\AggregateServiceProvider;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \PowerWeChat\OpenPlatform\Authorizer\Aggregate\Account\Client   $account
 * @property \PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Code\Client    $code
 * @property \PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Domain\Client  $domain
 * @property \PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Tester\Client  $tester
 */
class Application extends MiniProgram
{
    /**
     * Application constructor.
     *
     * @param array $config
     * @param array $prepends
     */
    public function __construct(array $config = [], array $prepends = [])
    {
        parent::__construct($config, $prepends);

        $providers = [
            AggregateServiceProvider::class,
            Code\ServiceProvider::class,
            Domain\ServiceProvider::class,
            Tester\ServiceProvider::class,
        ];

        foreach ($providers as $provider) {
            $this->register(new $provider());
        }
    }
}
