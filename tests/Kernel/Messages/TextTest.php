<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Test\Kernel\Messages;

use PowerWeChat\Kernel\Messages\Text;
use PowerWeChat\Tests\TestCase;

class TextTest extends TestCase
{
    public function testBasicFeatures()
    {
        $text = new Text('mock-content');

        $this->assertSame('mock-content', $text->content);
    }
}
