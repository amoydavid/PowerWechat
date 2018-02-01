<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\BasicService;

use PowerWeChat\OfficialAccount\Application;
use PowerWeChat\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        $app = new Application();

        $this->assertInstanceOf(\PowerWeChat\BasicService\Media\Client::class, $app->media);
        $this->assertInstanceOf(\PowerWeChat\BasicService\Url\Client::class, $app->url);
        $this->assertInstanceOf(\PowerWeChat\BasicService\QrCode\Client::class, $app->qrcode);
        $this->assertInstanceOf(\PowerWeChat\BasicService\Jssdk\Client::class, $app->jssdk);
    }
}
