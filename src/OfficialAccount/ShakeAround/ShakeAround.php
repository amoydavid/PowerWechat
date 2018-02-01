<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OfficialAccount\ShakeAround;

use PowerWeChat\Kernel\Exceptions\InvalidArgumentException;

/**
 * Class Card.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @property \PowerWeChat\OfficialAccount\ShakeAround\DeviceClient   $device
 * @property \PowerWeChat\OfficialAccount\ShakeAround\GroupClient    $group
 * @property \PowerWeChat\OfficialAccount\ShakeAround\MaterialClient $material
 * @property \PowerWeChat\OfficialAccount\ShakeAround\RelationClient $relation
 * @property \PowerWeChat\OfficialAccount\ShakeAround\StatsClient    $stats
 */
class ShakeAround extends Client
{
    /**
     * @param string $property
     *
     * @return mixed
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function __get($property)
    {
        if (isset($this->app["shake_around.{$property}"])) {
            return $this->app["shake_around.{$property}"];
        }

        throw new InvalidArgumentException(sprintf('No shake_around service named "%s".', $property));
    }
}
