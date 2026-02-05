<?php

namespace Core;

class Config
{
    private static array $items = [];

    public static function load(string $path): void
    {
        $files = glob($path . '/*.php');

        foreach ($files as $file) {
            $key = basename($file, '.php');
            self::$items[$key] = require $file;
        }
    }

    /**
     * Get config section
     * @param string $key
     * @param $default
     * @return array|mixed|null
     */
    public static function get(string $key, $default = null): mixed
    {
        $segments = explode('.', $key);
        $data = self::$items;

        foreach ($segments as $segment) {
            if (!isset($data[$segment])) {
                return $default;
            }

            $data = $data[$segment];
        }

        if (array_key_exists($key, $data)) {
            return $data[$key];
        }

        return $data;
    }
}