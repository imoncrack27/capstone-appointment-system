<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Render the HTML output of a timezone dropdown element.
 *
 * @param string $attributes HTML element attributes of the dropdown.
 *
 * @return string
 */
function render_timezone_dropdown($attributes = '')
{
    $CI = get_instance();

    $CI->load->library('timezones');

    $timezones = $CI->timezones->to_grouped_array();

    return $CI->load->view('partials/timezone_dropdown', [
        'timezones' => $timezones,
        'attributes' => $attributes
    ], TRUE);
}
