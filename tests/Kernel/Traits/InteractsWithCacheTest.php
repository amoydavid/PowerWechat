<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Kernel\Traits;

use PowerWeChat\Kernel\Traits\InteractsWithCache;
use PowerWeChat\Tests\TestCase;
use Psr\SimpleCache\CacheInterface;

class InteractsWithCacheTest extends TestCase
{
    public function testBasicFeatures()
    {
        $cls = \Mockery::mock(InteractsWithCache::class);
        $this->assertInstanceOf(CacheInterface::class, $cls->getCache());

        $cache = \Mockery::mock(CacheInterface::class);
        $cls->setCache($cache);
        $this->assertSame($cache, $cls->getCache());
    }
}
