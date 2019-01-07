<?php
/**
 * PowerWechat
 * @author amoydavid
 * Date: 2019/1/7
 * Time: 2:38 PM
 */

namespace PowerWeChat\BasicService\ContentSecurity;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['content_security'] = function ($app) {
            return new Client($app);
        };
    }
}