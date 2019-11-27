<?php
namespace PowerWeChat\MiniProgram\SubscribeMessage;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package PowerWeChat\MiniProgram\SubscribeMessage
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['subscribe_message'] = function ($app) {
            return new Client($app);
        };
    }
}
