<?php

namespace App\Providers;

use Noodlehaus\Config;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['config'] = function () {
            return new Config(app_path('config.php'));
        };
    }
}
