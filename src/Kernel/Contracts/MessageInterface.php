<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Kernel\Contracts;

/**
 * Interface MessageInterface.
 *
 * @author overtrue <i@overtrue.me>
 */
interface MessageInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return mixed
     */
    public function transformForJsonRequest(): array;

    /**
     * @return string
     */
    public function transformToXml(): string;
}
