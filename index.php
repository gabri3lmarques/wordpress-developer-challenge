<?php get_template_part('template-parts/header'); ?>
<?php get_template_part('template-parts/hero'); ?>

<?php

function display_video_carousel($post_type, $term, $title, $items = 9) {
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $items,
        'tax_query' => array(
            array(
                'taxonomy' => 'video_type',
                'field'    => 'slug',
                'terms'    => $term,
            ),
        ),
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
        echo '<h2 class="home">' . esc_html($title) . '</h2>';
        echo '<div class="carousel ishome" data-items="7">';
        echo '<div class="carousel-inner">';

        while ($the_query->have_posts()) {
            $the_query->the_post();

            // pega os dados dos posts
            $duration = esc_html(get_post_meta(get_the_ID(), 'bx_play_video_duration', true));
            $video_id = esc_html(get_post_meta(get_the_ID(), 'bx_play_video_ID', true));
            $image_id = get_post_meta(get_the_ID(), 'bx_play_image', true);
            $image_url = esc_url(wp_get_attachment_url($image_id));

            echo '<div class="carousel-item">';
            echo '<div class="bx-desafio-video-card">';
            echo '<a href="' . esc_url(get_permalink()) . '" class="bx-desafio-video-card-img-link">';
            echo '<div class="bx-desafio-video-card-img" style="background-image:url(\'' . $image_url . '\')"></div>';
            echo '</a>';
            echo '<div class="bx-desafio-video-card-taxonomy">';
            echo '<button class="bx-desafio-button small time flex align-items-center justify-content-center">' . $duration . 'm</button>';
            echo '</div>';
            echo '<div class="bx-desafio-video-card-title">';
            echo '<h3>' . esc_html(get_the_title()) . '</h3>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';

        wp_reset_postdata();
    } else {
        echo '<p>' . esc_html__('No posts found', 'text-domain') . '</p>';
    }
}

display_video_carousel('video', 'movie', 'Movies');
display_video_carousel('video', 'doc', 'Documentaries');
display_video_carousel('video', 'serie', 'Series');

?>

<?php get_template_part('template-parts/footer'); ?>
