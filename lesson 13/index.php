<?php get_header(); ?>

<div class="container py-5">
  <?php if ( have_posts() ) : ?>
    <div class="row g-4">
      <?php while ( have_posts() ) : the_post(); ?>
        <div class="col-12 col-md-6 col-lg-4">
          <article <?php post_class('h-100'); ?> id="post-<?php the_ID(); ?>">
            <div class="card shadow-sm h-100 border-0">
              <?php if ( has_post_thumbnail() ) : ?>
                <img src="<?php the_post_thumbnail_url('medium_large'); ?>" class="card-img-top rounded-top" alt="<?php the_title_attribute(); ?>">
              <?php endif; ?>
              <div class="card-body d-flex flex-column">
                <h3 class="card-title h5 mb-2">
                  <a href="<?php the_permalink(); ?>" class="stretched-link text-decoration-none text-dark"><?php the_title(); ?></a>
                </h3>
                <small class="text-muted mb-2">
                  <?php echo get_the_date('M j, Y'); ?> &middot; <?php the_category(', '); ?>
                </small>
                <div class="card-text mb-3"><?php the_excerpt(); ?></div>
                <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary mt-auto">Read More</a>
              </div>
            </div>
          </article>
        </div>
      <?php endwhile; ?>
    </div>

    <div class="my-4 d-flex justify-content-center">
      <?php mytheme_pagination(); ?>
    </div>
  <?php else : ?>
    <div class="alert alert-warning mt-4" role="alert">
      <?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?>
    </div>
  <?php endif; ?>

  <aside class="mt-5">
    <?php get_sidebar( 'primary' );?>
  </aside>

  <div class="row mt-5">
    <div class="col-md-3">
      <div class="box-rounded p-3 bg-light rounded">This box has rounded corners.</div>
    </div>
    <div class="col-md-3">
      <div class="box-border-image p-3 border border-primary">This box has an image.</div>
    </div>
    <div class="col-md-3">
      <div class="box-shadow p-3 shadow">This has a shadow.</div>
    </div>
    <div class="col-md-3">
      <div class="inner-shadow p-3" style="box-shadow: inset 0 2px 8px rgba(0,0,0,0.15);">This box has inner shadow.</div>
    </div>
  </div>

  <?php
  // Show latest movies on the homepage
  $movies_query = new WP_Query(array(
    'post_type' => 'movies',
    'posts_per_page' => 3
  ));
  if ($movies_query->have_posts()) : ?>
    <h2>Latest Movies</h2>
    <ul>
      <?php while ($movies_query->have_posts()) : $movies_query->the_post(); ?>
        <li>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
      <?php endwhile; ?>
    </ul>
    <a href="<?php echo site_url('/Movies/'); ?>" class="btn btn-primary">View All Movies</a>
  <?php endif; wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
