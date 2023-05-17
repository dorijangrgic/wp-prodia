<?php

// require dirname(__DIR__) . '../config.php';

function callback()
{
    // Get the authorization code from the query parameters
    $auth_code = $_GET['code'];

    // Make a POST request to the IDP's token endpoint
    $response = wp_remote_post(
        'https://localhost:44350/auth/token',
        array(
            'timeout' => 60,
            'redirection' => 5,
            'method' => 'POST',
            'httpversion' => '1.0',
            'sslverify' => false,
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Expect' => ''
            ),
            'body' => array(
                'grant_type' => 'authorization_code',
                'code' => $auth_code,
                'code_verifier' => 'hif23ruf90dsnviweifowsc',
            )
        )
    );

    // Parse the response and obtain the access token
    $response_body = wp_remote_retrieve_body($response);
    $response_data = json_decode($response_body, true);
    $access_token = $response_data['access_token'];

    list($headerBase64Url, $payloadBase64Url, $signatureBase64Url) = explode('.', $access_token);

    $payload = read_payload_from_access_token($payloadBase64Url);

    $userRoles = $payload['ov_lms_rol3d'];
    $adminRoles = array(
        'LMSGebruiker-admin:116228'
    );

    $role = get_user_role($adminRoles, $userRoles);

    // Create new user if not exists
    $wp_user = get_user_by('email', $payload['email']);

    if (!$wp_user) {
        $user_id = wp_insert_user(
            array(
                'user_login' => $payload['given_name'],
                'user_pass' => 'novipassword',
                'user_email' => $payload['email'],
                'role' => $role
            )
        );
    } else {
        $user_id = $wp_user->ID;
        remove_all_user_roles($wp_user);
        $wp_user->add_role($role);
    }

    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    $_SESSION['access_token'] = $access_token;

    // Redirect to user page
    wp_redirect(home_url());
}

function read_payload_from_access_token($payloadBase64Url)
{
    // Base64Url decode        
    $urlUnsafeData = strtr($payloadBase64Url, '-_', '+/');
    $paddedData = str_pad($urlUnsafeData, strlen($urlUnsafeData) % 4, '=', STR_PAD_RIGHT);
    $payloadJson = base64_decode($paddedData);

    // Convert JSON to PHP array
    return json_decode($payloadJson, true);
}

function get_user_role($adminRoles, $roles)
{
    if (!empty(array_intersect($adminRoles, $roles))) {
        return 'administrator';
    } else {
        return 'subscriber';
    }
}

function remove_all_user_roles($wp_user)
{
    $wp_user->remove_role('administrator');
    $wp_user->remove_role('editor');
    $wp_user->remove_role('author');
    $wp_user->remove_role('contributor');
    $wp_user->remove_role('subscriber');
}

?>