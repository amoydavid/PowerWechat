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

use PowerWeChat\Kernel\Decorators\TerminateResult;
use PowerWeChat\Tests\TestCase;

class TerminateResultTest extends TestCase
{
    public function testGetContent()
    {
        $result = new TerminateResult('foo');

        $this->assertSame('foo', $result->content);
    }
}
