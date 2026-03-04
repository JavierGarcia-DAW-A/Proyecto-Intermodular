<?php
function kapo_barber_scripts() {
    // Styles
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css');
    wp_enqueue_style('slicknav', get_template_directory_uri() . '/assets/css/slicknav.css');
    wp_enqueue_style('flaticon', get_template_directory_uri() . '/assets/css/flaticon.css');
    wp_enqueue_style('gijgo', get_template_directory_uri() . '/assets/css/gijgo.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/css/animate.min.css');
    wp_enqueue_style('animated-headline', get_template_directory_uri() . '/assets/css/animated-headline.css');
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/fontawesome-all.min.css');
    wp_enqueue_style('themify-icons', get_template_directory_uri() . '/assets/css/themify-icons.css');
    wp_enqueue_style('slick', get_template_directory_uri() . '/assets/css/slick.css');
    wp_enqueue_style('nice-select', get_template_directory_uri() . '/assets/css/nice-select.css');
    wp_enqueue_style('price-rangs', get_template_directory_uri() . '/assets/css/price_rangs.css');
    
    // Main Style (from assets)
    wp_enqueue_style('kapo-barber-style', get_template_directory_uri() . '/assets/css/style.css');
    
    // Responsive
    wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css');
    
    // Root Style (optional, for theme info or overrides)
    wp_enqueue_style('kapo-barber-root-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'kapo_barber_scripts');

function kapo_barber_setup() {
    // Register Navigation Menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'kapo-barber' ),
    ) );

    // Add Title Tag Support
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'kapo_barber_setup' );

function kapo_custom_post_type_portrait() {
    $labels = array(
        'name'                  => _x( 'Portraits', 'Post Type General Name', 'kapo-barber' ),
        'singular_name'         => _x( 'Portrait', 'Post Type Singular Name', 'kapo-barber' ),
        'menu_name'             => __( 'Portraits', 'kapo-barber' ),
        'name_admin_bar'        => __( 'Portrait', 'kapo-barber' ),
        'add_new'               => __( 'Add New', 'kapo-barber' ),
        'add_new_item'          => __( 'Add New Portrait', 'kapo-barber' ),
    );
    $args = array(
        'label'                 => __( 'Portrait', 'kapo-barber' ),
        'description'           => __( 'Custom Post Type for Portraits', 'kapo-barber' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-image',
        'has_archive'           => true,
    );
    register_post_type( 'portrait', $args );
}
add_action( 'init', 'kapo_custom_post_type_portrait', 0 );
