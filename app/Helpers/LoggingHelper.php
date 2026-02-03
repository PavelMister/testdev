<?php

namespace Helpers;

class LoggingHelper
{
    /**
     * Save exception to logs
     * @param string $error
     * @return void
     */
    public static function saveError(string $error): void
    {
        $preparedError = self::prepareErrorMessage($error);
        file_put_contents('app_exceptions.log', $preparedError, FILE_APPEND | LOCK_EX);
    }

    /**
     * Get error message in need format
     * @param $error
     * @return string
     */
    private static function prepareErrorMessage($error): string
    {
        return (new \DateTime())->format('[d-m-y H:i:s]') . ' - ' . $error . PHP_EOL;
    }
}