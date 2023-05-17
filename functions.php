<?php

require 'oauth/authorize.php';
require 'oauth/callback.php';
require 'oauth/logout.php';

function oauth()
{
    if (str_contains($_SERVER['REQUEST_URI'], 'oauth_authorize')) {
        authorize();
    } else if (str_contains($_SERVER['REQUEST_URI'], 'oauth_callback')) {
        callback();
    } else if (str_contains($_SERVER['REQUEST_URI'], 'logout')) {
        logout();
    }
}
add_action('template_redirect', 'oauth');

function enqueue_javascript()
{
    wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_javascript');

?>