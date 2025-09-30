<?php


function ds_enqueue_assets() {
  
  wp_enqueue_style( 'bootstrap-cdn', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' );


  wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.2', 'all' );


  wp_enqueue_script( 'bootstrap-cdn', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true );


 
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'ds_enqueue_assets' );



function ds_setup() {
  add_theme_support( 'menus' );
  register_nav_menu( 'primary', 'Primary Navigation' );
  register_nav_menu( 'footer', 'Footer Navigation' );


  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'post-formats', array( 'aside', 'image', 'video' ) );
}
add_action( 'init', 'ds_setup' );

function mytheme_pagination() {
  global $wp_query;

  if ( $wp_query->max_num_pages < 2 ) {
    return;
  }

  $big = 999999999;

  $pagination = paginate_links( array(
    'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format'    => '?paged=%#%',
    'current'   => max( 1, get_query_var('paged') ),
    'total'     => $wp_query->max_num_pages,
    'prev_text' => __('«'),
    'next_text' => __('»'),
    'type'      => 'array'
  ) );

  if ( is_array( $pagination ) ) {
    echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
    foreach ( $pagination as $page ) {
      // Add active class for current page
      if ( strpos( $page, 'current' ) !== false ) {
        echo '<li class="page-item active">' . str_replace('page-numbers', 'page-link', $page) . '</li>';
      } else {
        echo '<li class="page-item">' . str_replace('page-numbers', 'page-link', $page) . '</li>';
      }
    }
    echo '</ul></nav>';
  }
}

function create_posttype(){
  register_post_type(
    'movies',
    array(
      'labels' => array(
        'name' => __('Movies'),
        'singular_name' => __('Movie')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'movies'),
      'show_in_rest' => true,
      'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
    )
  );
}


function register_taxonomy_movie_genres() {
    $labels = array(
        'name'              => _x('Movie Genres', 'taxonomy general name'),
        'singular_name'     => _x('Movie Genre', 'taxonomy singular name'),
        'search_items'      => __('Search Movie Genres'),
        'all_items'         => __('All Movie Genres'),
        'parent_item'       => __('Parent Movie Genre'),
        'parent_item_colon' => __('Parent Movie Genre:'),
        'edit_item'         => __('Edit Movie Genre'),
        'update_item'       => __('Update Movie Genre'),
        'add_new_item'      => __('Add New Movie Genre'),
        'new_item_name'     => __('New Movie Genre Name'),
        'menu_name'         => __('Movie Genres'),
    );

    $args = array(
        'hierarchical'      => true, // Like categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'movie-genre'),
        'show_in_rest'      => true, // For Gutenberg
    );

    register_taxonomy('movie_genre', array('movies'), $args);
}
add_action('init', 'register_taxonomy_movie_genres');
add_action('init', 'create_posttype');