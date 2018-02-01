<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\OfficialAccount\ShakeAround;

use PowerWeChat\Kernel\Exceptions\InvalidArgumentException;
use PowerWeChat\OfficialAccount\ShakeAround\MaterialClient;
use PowerWeChat\Tests\TestCase;

class MaterialClientTest extends TestCase
{
    public function testUploadImage()
    {
        $client = $this->mockApiClient(MaterialClient::class);

        $path = STUBS_ROOT.'/files/image.png';

        $client->expects()->httpUpload('shakearound/material/add', ['media' => $path], [], ['type' => 'icon'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->uploadImage($path));

        $client->expects()->httpUpload('shakearound/material/add', ['media' => $path], [], ['type' => 'cover'])->andReturn('mock-result')->once();
        $this->assertSame('mock-result', $client->uploadImage($path, 'cover'));

        // invalid path
        $path = '/not/exists/path/to/image.jpg';
        $this->expectExceptionMessage(sprintf('File does not exist, or the file is unreadable: "%s"', $path));
        $this->expectException(InvalidArgumentException::class);
        $client->uploadImage($path);
    }
}
