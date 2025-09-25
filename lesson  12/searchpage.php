<?php 


get_header()?>

<main id="main" class="site-main" role="main">
    <section class="search-intro">
        <h2>
             <?php _e("Search Posts","year-textdomain");?>
        </h2>
        <p>
            <?php _e('Use the form below ton search the site.','your-textdomain'); ?>
        </p>
    </section>

    <?php get_search_form();?>

</main>
<?php get_footer();?>
