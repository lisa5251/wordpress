<?php
<?php get_header(); ?>

<div class="container my-5">
  <h1 class="mb-4">Movies</h1>
  <?php if ( have_posts() ) : ?>
    <div class="row">
      <?php while ( have_posts() ) : the_post(); ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <?php if ( has_post_thumbnail() ) : ?>
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
              </a>
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <div class="mb-2">
                <?php
                  $genres = get_the_terms( get_the_ID(), 'movie_genre' );
                  if ( $genres && ! is_wp_error( $genres ) ) {
                    echo '<span class="badge bg-secondary">Genres: ';
                    $genre_names = wp_list_pluck( $genres, 'name' );
                    echo esc_html( implode( ', ', $genre_names ) );
                    echo '</span>';
                  }
                ?>
              </div>
              <p class="card-text"><?php the_excerpt(); ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <?php mytheme_pagination(); ?>
  <?php else : ?>
    <p>No movies found.</p>
  <?php endif; ?>
</div>

<?php get_footer(); ?>