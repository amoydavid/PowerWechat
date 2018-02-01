<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OfficialAccount;

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
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Auth\AccessToken::class, $app->access_token);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Server\Guard::class, $app->server);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\User\UserClient::class, $app->user);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\User\TagClient::class, $app->user_tag);
        $this->assertInstanceOf(\Overtrue\Socialite\Providers\WeChatProvider::class, $app->oauth);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Menu\Client::class, $app->menu);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\TemplateMessage\Client::class, $app->template_message);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Material\Client::class, $app->material);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\CustomerService\Client::class, $app->customer_service);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Semantic\Client::class, $app->semantic);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\DataCube\Client::class, $app->data_cube);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\AutoReply\Client::class, $app->auto_reply);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Broadcasting\Client::class, $app->broadcasting);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Card\Client::class, $app->card);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Device\Client::class, $app->device);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\ShakeAround\Client::class, $app->shake_around);
        $this->assertInstanceOf(\PowerWeChat\OfficialAccount\Base\Client::class, $app->base);
    }
}
