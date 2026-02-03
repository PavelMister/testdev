<?php

namespace Core;

class Env
{
    /**
     * @throws \Exception
     */
    public static function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new \Exception('Not found .env file');
        }

        $envLines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($envLines as $line) {
            $line = trim($line);

            // Skip empty lines and comments.
            if (empty($line) || str_contains($line, '#') === 0) {
                continue;
            }

            if (str_contains($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
            }

            $value = trim($value, '"\'');

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}