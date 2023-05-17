<?php get_header(); ?>

<?php if (is_user_logged_in()): ?>

    <button id="logout-button">Logout!</button>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php
            while (have_posts()):
                the_post();
                get_template_part('template-parts/page/content', 'page');
            endwhile;
            ?>
        </main>
    </div>

<?php else: ?>
    <h1>Log in to see content!</h1>
    <button id="login-button">Login!</button>
<?php endif; ?>

<?php get_footer(); ?>