<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Quickly fetch the value of a framework configuration.
 *
 * @param string $key Configuration key.
 *
 * @return mixed Returns the configuration value.
 */
function config($key)
{
    $CI = &get_instance();

    return $CI->config->item($key);
}
