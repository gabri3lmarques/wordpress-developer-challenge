<?php
/*
Template Name: Full Width
*/
get_header();
?>
<main class="fullwidth">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>
<?php get_footer(); ?>
