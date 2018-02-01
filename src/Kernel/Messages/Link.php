<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Kernel\Messages;

/**
 * Class Link.
 */
class Link extends Message
{
    /**
     * Messages type.
     *
     * @var string
     */
    protected $type = 'link';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
        'title',
        'description',
        'url',
    ];
}
