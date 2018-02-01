<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Kernel\Messages;

use PowerWeChat\Kernel\Contracts\MediaInterface;
use PowerWeChat\Kernel\Messages\Media;
use PowerWeChat\Tests\TestCase;

class MediaTest extends TestCase
{
    public function testGetMediaId()
    {
        $media = new Media('mock-media-id', 'image', ['title' => 'mock-title']);
        $this->assertInstanceOf(MediaInterface::class, $media);
        $this->assertSame('image', $media->getType());
        $this->assertSame('mock-media-id', $media->getMediaId());
        $this->assertSame('mock-title', $media->title);
    }

    public function testToXmlArray()
    {
        $message = new Media('mock-id', 'file');

        $this->assertSame([
            'File' => [
                'MediaId' => 'mock-id',
            ],
        ], $message->toXmlArray());
    }
}
