<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        if (have_posts()):

            while (have_posts()):
                the_post();
                get_template_part('template-parts/page/content', 'search');
            endwhile;

            echo paginate_links([
                'prev-text' => esc_html__('Prev', 'herobiz'),
                'next-text' => esc_html__('Next', 'herobiz'),
            ]);

        else:
            get_template_part('template-parts/page/content', 'none');
        endif;
        ?>
    </main>
</div>

<?php get_footer(); ?>