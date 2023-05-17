<article id="post-<?php the_ID(); ?>">

    <header class="entry-header">
        <?php
        if (is_single()):
            the_title('<h1 class="entry-title">', '</h1>');
        else:
            the_title('<h2 class="entry-title"><a class="entry-link" href="' . esc_url(get_permalink()) . '">', '</a></h2>');
        endif;
        ?>
    </header>

    <?php
    if (has_post_thumbnail()):
        the_post_thumbnail('large');
    endif;
    ?>

    <?php if (is_home() || is_archive()): ?>
        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div>
    <?php elseif (is_single()): ?>
        <div class="entry-content">
            <?php

            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'ninestars'),
                    'after' => '</div>',
                )
            )
                ?>
        </div>
    <?php endif; ?>

</article>