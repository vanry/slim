<?php

namespace App\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\Views\PhpRenderer;

class ViewServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['view'] = function ($container) {
            $config = $container['config'];

            $view = new PhpRenderer($config['view.path']);

            if ($config['view.layout']) {
                $view->setLayout($config['view.layout']);
            }

            return $view;
        };
    }
}
