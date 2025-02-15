<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',  get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
    wp_enqueue_style( 'mvoc-style',  get_stylesheet_directory_uri() . '/mvoc.css');
}

add_action('wp_head', 'mvoc_child_wp_head');
function mvoc_child_wp_head(){
    //Close PHP tags 
    ?>
    <script src="https://kit.fontawesome.com/47b25671dd.js" crossorigin="anonymous"></script>
    <?php //Open PHP tags
}

function mvoc_pre_get_posts( $query ) {
    // Modify the main query on the blog posts index page to only include those tagged as news
    if ( is_home() && $query->is_main_query() ) {
        $query->set( 'category_name', 'news' );
    }
}
add_action( 'pre_get_posts', 'mvoc_pre_get_posts' );