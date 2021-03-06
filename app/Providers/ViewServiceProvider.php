<?php

namespace App\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\Views\PhpRenderer;

class ViewServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['view'] = function () {
            $view = new PhpRenderer(config('view.path'));

            if ($layout = config('view.layout')) {
                $view->setLayout($layout);
            }

            return $view;
        };
    }
}
