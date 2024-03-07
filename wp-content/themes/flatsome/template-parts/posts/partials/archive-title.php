<header class="archive-page-header">
    <div class="row row-collapse row-full-width align-middle align-center">
        <div class="large-12 text-center col">
            <div class="page-title is-large">
                <div class="page-title-bg fill">

                    <div class="title-bg fill bg-fill"
                        <?php if (get_theme_mod('blog_archive_bg')) echo 'style="background-image:url(' . do_shortcode(get_theme_mod('blog_archive_bg')) . ')"'; ?>
                         data-parallax-container=".page-title" data-parallax="-2" data-parallax-background>

                    </div>
                    <div class="title-overlay fill" style="background-color: rgba(0,0,0,.6)"></div>
                </div>
                <div class="page-title-inner container  flex-row  dark">
                    <div class="flex-col flex-center text-center">
                        <div class="entry-header text-center relative">
                            <h2 class="entry-title is-larger">
                                <strong><?php

                                    if (is_category()) :
                                        printf(__('%s', 'flatsome'), '<span>' . single_cat_title('', false) . '</span>');

                                    elseif (is_tag()) :
                                        printf(__('%s', 'flatsome'), '<span>' . single_tag_title('', false) . '</span>');

                                    elseif (is_search()) :
                                        printf(__('Search Results for: %s', 'flatsome'), '<span>' . get_search_query() . '</span>');

                                    elseif (is_author()) :
                                        /* Queue the first post, that way we know
                                         * what author we're dealing with (if that is the case).
                                        */
                                        the_post();
                                        printf(__('%s', 'flatsome'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>');
                                        /* Since we called the_post() above, we need to
                                         * rewind the loop back to the beginning that way
                                         * we can run the loop properly, in full.
                                         */
                                        rewind_posts();

                                    elseif (is_day()) :
                                        printf(__('%s', 'flatsome'), '<span>' . get_the_date() . '</span>');

                                    elseif (is_month()) :
                                        printf(__('%s', 'flatsome'), '<span>' . get_the_date('F Y') . '</span>');

                                    elseif (is_year()) :
                                        printf(__('%s', 'flatsome'), '<span>' . get_the_date('Y') . '</span>');

                                    elseif (is_tax('post_format', 'post-format-aside')) :
                                        _e('Asides', 'flatsome');

                                    elseif (is_tax('post_format', 'post-format-image')) :
                                        _e('Images', 'flatsome');

                                    elseif (is_tax('post_format', 'post-format-video')) :
                                        _e('Videos', 'flatsome');

                                    elseif (is_tax('post_format', 'post-format-quote')) :
                                        _e('Quotes', 'flatsome');

                                    elseif (is_tax('post_format', 'post-format-link')) :
                                        _e('Links', 'flatsome');

                                    else :
                                        _e('', 'flatsome');

                                    endif;
                                    ?></strong>
                            </h2>
                            <div class="lead">
                                <?php
                                if (is_category()) :
                                    // show an optional category description
                                    $category_description = category_description();
                                    if (!empty($category_description)) :
                                        echo apply_filters('category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>');
                                    endif;

                                elseif (is_tag()) :
                                    // show an optional tag description
                                    $tag_description = tag_description();
                                    if (!empty($tag_description)) :
                                        echo apply_filters('tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>');
                                    endif;

                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</header>
