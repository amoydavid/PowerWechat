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

use PowerWeChat\Kernel\Messages\Transfer;
use PowerWeChat\Tests\TestCase;

class TransferTest extends TestCase
{
    public function testToXmlArray()
    {
        $message = new Transfer();
        $this->assertSame([], $message->toXmlArray());

        $message = new Transfer('overtrue@test');
        $this->assertSame([
            'TransInfo' => [
                'KfAccount' => 'overtrue@test',
            ],
        ], $message->toXmlArray());
    }
}
