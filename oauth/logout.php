<?php

function logout()
{
    wp_logout();
    wp_redirect(home_url());
}

?>