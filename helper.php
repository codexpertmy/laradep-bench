<?php

/**
 * helper file for laradep global scope use
 */

if (!function_exists('base_path')) {
    function base_path($path = null)
    {
        $appPath = __DIR__;
        return is_null($path) ? $appPath : $appPath . '/' . $path;
    }
}
