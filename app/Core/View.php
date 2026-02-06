<?php

namespace Core;

class View
{
    /**
     * Render view page
     *
     * @param $path
     * @param array $data
     * @return string
     */
    public function renderView($path, array $data = []): string
    {
        $fullPath = Config::get('paths')['view'] . DIRECTORY_SEPARATOR . $path;

        if (empty($path) || !file_exists($fullPath)) {
            return "View file [{$path}] not found.";
        }

        extract($data);
        ob_start();
        include $fullPath;
        return ob_get_clean();
    }

    /**
     * Render text
     *
     * @param string $text
     * @return string
     */
    public function renderText(string $text): string
    {
        ob_start();
        echo $text;
        return ob_get_clean();
    }
}
