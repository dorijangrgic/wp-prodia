<?php

// require dirname(__DIR__) . '../config.php';

function authorize()
{
    // Build the authorization URL
    $auth_url = 'https://localhost:44350/auth/authorize?';
    $auth_url .= 'client_id=' . urlencode(1);
    $auth_url .= '&response_type=code';
    $auth_url .= '&redirect_uri=' . urlencode('http://localhost:10005/oauth_callback');
    $auth_url .= '&scope=' . urlencode('user');
    $auth_url .= '&code_challenge=' . urlencode('afed83cc9a6b91981f3ac6b305af75b4caaf410eaa73118214c0398b41dcad1d');
    $auth_url .= '&code_challenge_method=' . urlencode('256');

    // Redirect the user to the IDP's authorization endpoint
    header('Location: ' . $auth_url);
    exit;
}

?>