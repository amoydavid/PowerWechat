<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Kernel\Decorators;

use PowerWeChat\Kernel\Decorators\FinallyResult;
use PowerWeChat\Tests\TestCase;

class FinallyResultTest extends TestCase
{
    public function testGetContent()
    {
        $result = new FinallyResult('foo');

        $this->assertSame('foo', $result->content);
    }
}
