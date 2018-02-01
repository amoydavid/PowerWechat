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

use PowerWeChat\Kernel\Messages\Video;
use PowerWeChat\Tests\TestCase;

class VideoTest extends TestCase
{
    public function testToXmlArray()
    {
        $message = new Video('mock-media-id', [
                'title' => '告白气球',
                'description' => '告白气球 - 周杰伦',
            ]);

        $this->assertSame([
            'Video' => [
                'MediaId' => 'mock-media-id',
                'Title' => '告白气球',
                'Description' => '告白气球 - 周杰伦',
            ],
        ], $message->toXmlArray());
    }
}
