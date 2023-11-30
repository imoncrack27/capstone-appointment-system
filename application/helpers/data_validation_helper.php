<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Check if a string date is valid for insertion or update to the database.
 *
 * @param string $datetime The given date.
 *
 * @return bool Returns the validation result.
 *
 * @link http://stackoverflow.com/a/8105844/1718162 [SOURCE]
 */
function validate_mysql_datetime($datetime)
{
    $dt = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);

    return $dt ? TRUE : FALSE;
}
