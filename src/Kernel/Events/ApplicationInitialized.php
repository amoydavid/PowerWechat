<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Kernel\Events;

use PowerWeChat\Kernel\ServiceContainer;

/**
 * Class ApplicationInitialized.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class ApplicationInitialized
{
    /**
     * @var \PowerWeChat\Kernel\ServiceContainer
     */
    public $app;

    /**
     * @param \PowerWeChat\Kernel\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }
}
