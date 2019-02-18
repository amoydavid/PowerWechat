<?php
/*
 * This file is part of the wyq09/PowerWechat.
 *
 * @author wyq09 <wyqckl09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PowerWeChat\OpenPlatform\Component;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['component'] = function ($app) {
            return new Client($app);
        };
    }
}