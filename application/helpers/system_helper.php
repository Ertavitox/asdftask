<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * \brief Get codeigniter configuration value by key
 */
function getConfig($c_key) {
    $o_ci = &get_instance();
    return $o_ci->config->item($c_key);
}

/**
 * \brief pre-printer function
 */
function pre($o_any) {
    echo "<pre>";
    var_dump($o_any);
    echo "</pre>";
}

/**
 * \brief get User session
 */
function getUserData() {
    $o_ci = & get_instance();
    return ($o_ci->session->userdata("a_userdata")) ? $o_ci->session->userdata("a_userdata") : false;
}
