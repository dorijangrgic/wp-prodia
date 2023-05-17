jQuery(document).ready(function($) {
    $('#login-button').click(function() {
        window.location.href = 'http://localhost:10005/oauth_authorize';
    });
});

jQuery(document).ready(function($) {
    $('#logout-button').click(function() {
        window.location.href = 'http://localhost:10005/logout';
    });
});