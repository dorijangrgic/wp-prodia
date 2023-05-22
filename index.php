<?php

get_header();

if (is_user_logged_in()): ?>

    <button id="logout-button">Logout!</button>

<?php

if (have_posts()):
    while (have_posts()):
        the_post();

        get_template_part('template-parts/post/content');
    endwhile;
endif;

else: ?>
    <h1>Log in to see content!</h1>
    <button id="login-button">Login!</button>
    <h2><?php echo $_ENV['CLIENT_ID']?></h2>
<?php endif;

get_footer();
