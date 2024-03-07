<?php
/*
Template name: Page - Container - Parallax Title
*/
get_header(); ?>
    <div class="parallax-title">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php ob_start(); ?>
            <header class="entry-header text-center relative">
                <h2 class="entry-title is-larger">
                    <strong><?php the_title(); ?></strong>
                </h2>
                <?php if( has_excerpt() ) { ?>
                    <div class="lead">
                        <?php echo do_shortcode(get_the_excerpt()); ?>
                    </div>
                <?php } ?>
            </header>
            <?php
            $bg = '#06587E';
            if( has_post_thumbnail() ) $bg = get_post_thumbnail_id();
            $header_html = ob_get_contents();
            $header_html = '[ux_banner animate="fadeInUp" bg_overlay="#000" parallax="2" parallax_text="-1" height="300px" bg="'.$bg.'"]'.$header_html.'[/ux_banner]';
            ob_end_clean();
            echo do_shortcode($header_html); ?>
        <?php endwhile; // end of the loop. ?>
    </div>

    <div class="row page-wrapper">
        <div id="content" class="large-12 col" role="main">

            <?php while ( have_posts() ) : the_post(); ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; // end of the loop. ?>
        </div>
    </div>




<?php get_footer(); ?>