<?php get_template_part('template-parts/header'); ?>

<?php if ( have_posts() ) : ?>
    <div class="post-list">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </header>
                
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                </div>

                <footer class="entry-footer">
                    <span class="posted-on"><?php the_time( get_option( 'date_format' ) ); ?></span>
                    <span class="byline"><?php the_author(); ?></span>
                </footer>
            </article>
        <?php endwhile; ?>
    </div>
    
    <?php the_posts_navigation(); ?>
<?php else : ?>
    <p><?php esc_html_e( 'No posts found.', 'textdomain' ); ?></p>
<?php endif; ?>

<?php get_template_part('template-parts/footer'); ?>
