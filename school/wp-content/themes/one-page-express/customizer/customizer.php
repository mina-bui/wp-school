<?php

add_filter('the_content', function ($content) {
    global $post;
    /** @var WP_Post $post */
    if (is_customize_preview() && ! class_exists('OnePageExpress\Companion')) {
        if ($post->post_type === "page") {
            // get add-section template part
            ob_start();
            get_template_part("customizer/add-sections-preview");
            $add_section = ob_get_clean();
            // add add-section template part to the page content
            $content .= $add_section;
        }
    }

    return $content;
}, PHP_INT_MAX);