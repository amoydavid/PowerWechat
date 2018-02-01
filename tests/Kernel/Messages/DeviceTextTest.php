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

use PowerWeChat\Kernel\Messages\DeviceText;
use PowerWeChat\Tests\TestCase;

class DeviceTextTest extends TestCase
{
    public function testToXmlArray()
    {
        $message = new DeviceText([
            'device_type' => 'mock-device_type',
            'device_id' => 'mock-device_id',
            'content' => 'mock-content',
            'session_id' => 'mock-session_id',
            'open_id' => 'mock-open_id',
        ]);

        $this->assertSame([
            'DeviceType' => 'mock-device_type',
            'DeviceID' => 'mock-device_id',
            'SessionID' => 'mock-session_id',
            'Content' => base64_encode('mock-content'),
        ], $message->toXmlArray());
    }
}
