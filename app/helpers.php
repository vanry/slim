<?php

if (! function_exists('config')) {
    /**
     * Get configuration value.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function config(string $key, $default = null)
    {
        static $config;

        if (is_null($config)) {
            $config = new Noodlehaus\Config(app_path('config.php'));
        }

        return $config->get($key, $default);
    }
}

if (! function_exists('base_path')) {
    /**
     * Get the path to the base of the install.
     *
     * @param  string  $path
     * @return string
     */
    function base_path(string $path = '')
    {
        return dirname(__DIR__).normalize_path($path);
    }
}

if (! function_exists('app_path')) {
    /**
     * Get the path to the application folder.
     *
     * @param  string  $path
     * @return string
     */
    function app_path(string $path = '')
    {
        return base_path('app').normalize_path($path);
    }
}

if (! function_exists('resource_path')) {
    /**
     * Get the path to the resources folder.
     *
     * @param  string  $path
     * @return string
     */
    function resource_path(string $path = '')
    {
        return base_path('resources').normalize_path($path);
    }
}

if (! function_exists('storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param  string  $path
     * @return string
     */
    function storage_path(string $path = '')
    {
        return base_path('storage').normalize_path($path);
    }
}

if (! function_exists('normalize_path')) {
    /**
     * Normalize path.
     *
     * @param  string  $path
     * @return string
     */
    function normalize_path(string $path)
    {
        return $path ? DIRECTORY_SEPARATOR.$path : $path;
    }
}
