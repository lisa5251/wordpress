<?php
/**
 * The main template file
 *
 * @package Personal_Project
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="site-content" role="main">
    <?php if ( have_posts() ) : ?>

        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer">
                    <?php edit_post_link( __( 'Edit', 'personal-project' ), '<span class="edit-link">', '</span>' ); ?>
                </footer>
            </article>

        <?php endwhile; ?>

        <?php the_posts_pagination( array(
            'mid_size' => 2,
            'prev_text' => __( 'Previous', 'personal-project' ),
            'next_text' => __( 'Next', 'personal-project' ),
        ) ); ?>

    <?php else : ?>

        <section class="no-results not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'personal-project' ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e( 'It seems we can’t find what you’re looking for. Perhaps searching can help.', 'personal-project' ); ?></p>
                <?php get_search_form(); ?>
            </div>
        </section>

    <?php endif; ?>
</main>

<?php
get_sidebar();
get_footer();
