<div id="sidebar-primary" class="sidebar">
    <?php if(is_active_sidebar('primary' )): ?>
        <?php dynamic_sidebar( 'primary' );?>
    <?php else:?>
        <aside id="search" class= "widget widget_search">
            <?php get_search_form( );?>
        </aside>
        <aside id="archives" class= "widget">
            <h3 class="widget-title"?><?php _e('Aechives','dstheme');?></h3>
            <ul><?php wp_get_archives( array('type'->'monthly'));?></ul>
        
        </aside>
        <aside id="meta" class= "widget">
            <h3 class="widget-title"?><?php _e('Meta','dstheme');?></h3>
        
            <ul>
                <?php wp_rgister();?>
                <li><?php up_loginout()?></li>
                <?php wp_meta( )?>
            </ul>
        </aside>
        <?php endif;?>
</div>
