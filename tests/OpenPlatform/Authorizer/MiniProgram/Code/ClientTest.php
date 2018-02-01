<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OpenPlatform\Authorizer\MiniProgram\Code;

use PowerWeChat\Kernel\ServiceContainer;
use PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Code\Client;
use PowerWeChat\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testCommit()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));

        $client->expects()->httpPostJson('wxa/commit', [
            'template_id' => 123,
            'ext_json' => '{"foo":"bar"}',
            'user_version' => 'v1.0',
            'user_desc' => 'First commit.',
        ])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->commit(123, '{"foo":"bar"}', 'v1.0', 'First commit.'));
    }

    public function testGetQrCode()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->requestRaw('wxa/get_qrcode', 'GET')->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getQrCode());
    }

    public function testGetCategory()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpGet('wxa/get_category')->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getCategory());
    }

    public function testGetPage()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpGet('wxa/get_page')->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getPage());
    }

    public function testSubmitAudit()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpPostJson('wxa/submit_audit', ['item_list' => ['foo', 'bar']])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->submitAudit(['foo', 'bar']));
    }

    public function testGetAuditStatus()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpPostJson('wxa/get_auditstatus', ['auditid' => 123])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getAuditStatus(123));
    }

    public function testGetLatestAuditStatus()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpGet('wxa/get_latest_auditstatus')->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getLatestAuditStatus());
    }

    public function testRelease()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpPostJson('wxa/release')->andReturn('mock-result');
        $this->assertSame('mock-result', $client->release());
    }

    public function testChangeVisitStatus()
    {
        $client = $this->mockApiClient(Client::class, [], new ServiceContainer(['app_id' => 'app-id']));
        $client->expects()->httpPostJson('wxa/change_visitstatus', ['action' => 'foo'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->changeVisitStatus('foo'));
    }
}
