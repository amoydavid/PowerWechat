<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat;

/**
 * Class Factory.
 *
 * @method static \PowerWeChat\Payment\Application            payment(array $config)
 * @method static \PowerWeChat\MiniProgram\Application        miniProgram(array $config)
 * @method static \PowerWeChat\OpenPlatform\Application       openPlatform(array $config)
 * @method static \PowerWeChat\OfficialAccount\Application    officialAccount(array $config)
 * @method static \PowerWeChat\BasicService\Application       basicService(array $config)
 * @method static \PowerWeChat\Work\Application               work(array $config)
 * @method static \PowerWeChat\OpenWork\Application           openWork(array $config)
 * @method static \PowerWeChat\MicroMerchant\Application      microMerchant(array $config)
 */
class Factory
{
    /**
     * @param string $name
     * @param array  $config
     *
     * @return \PowerWeChat\Kernel\ServiceContainer
     */
    public static function make($name, array $config)
    {
        $namespace = Kernel\Support\Str::studly($name);
        $application = "\\PowerWeChat\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}
