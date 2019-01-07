<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\BasicService;

use PowerWeChat\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @property \PowerWeChat\BasicService\Jssdk\Client  $jssdk
 * @property \PowerWeChat\BasicService\Media\Client  $media
 * @property \PowerWeChat\BasicService\QrCode\Client $qrcode
 * @property \PowerWeChat\BasicService\Url\Client    $url
 * @property \PowerWeChat\BasicService\ContentSecurity\Client    $content_security
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Jssdk\ServiceProvider::class,
        QrCode\ServiceProvider::class,
        Media\ServiceProvider::class,
        Url\ServiceProvider::class,
        ContentSecurity\ServiceProvider::class,
    ];
}
