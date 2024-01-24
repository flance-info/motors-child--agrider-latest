<?php
    define('STM_MOTORS_CHILD_VERSION', time());

    add_action( 'wp_enqueue_scripts', 'stm_enqueue_parent_styles', 99 );

    function stm_enqueue_parent_styles() {
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('stm-theme-style'), STM_MOTORS_CHILD_VERSION );
        wp_enqueue_style( 'print-style', get_stylesheet_directory_uri() . '/assets/css/print.css', array(), STM_MOTORS_CHILD_VERSION );
    }

//	add_action( 'after_setup_theme', 'custom_listing_image_size', 99 );
//	function custom_listing_image_size() {
//	// Example: If the image size name is 'listings-thumb'
//	remove_image_size( 'stm-img-350-205' );
//	add_image_size( 'stm-img-350-205', 400, 266, true ); // 3:2 aspect ratio with cropping
//	}
//
//
//	add_action( 'after_setup_theme', 'custom_listing_image_size2', 99 );
//	function custom_listing_image_size2() {
//	// Example: If the image size name is 'listings-thumb'
//	remove_image_size( 'stm-img-255-135' );
//	add_image_size( 'stm-img-255-135', 400, 266, true ); // 3:2 aspect ratio with cropping
//	}
//
//	add_action( 'after_setup_theme', 'custom_listing_image_size3', 99 );
//	function custom_listing_image_size3() {
//	// Example: If the image size name is 'listings-thumb'
//	remove_image_size( 'stm-img-796-466' );
//	add_image_size( 'stm-img-796-466', 798, 531, true ); // 3:2 aspect ratio with cropping
//	}

function motors_child_setup() {
    $path = get_stylesheet_directory().'/languages';
    load_child_theme_textdomain( 'motors-child', $path );
}
add_action( 'after_setup_theme', 'motors_child_setup' );

require_once get_stylesheet_directory().'/inc/butterbean_metaboxes_child.php';


add_filter('stm_ew_locate_template', function ($located, $templates){

    if(file_exists(get_stylesheet_directory() . '/motors-elementor-widgets/' . $templates.'.php')) {
        $located = get_stylesheet_directory() . '/motors-elementor-widgets/' . $templates.'.php';
    }

    return $located;
}, 15, 2);

function custom_scripts() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            setTimeout(function() {
                $('.stm-multiple-currency-wrap select').select2().on("select2:opening", function(e) {
                    e.stopPropagation();
                });
            }, 100);
        });
    </script>
    <?php
}

add_action('wp_footer', 'custom_scripts', 30);


function multi_change_translate_text( $translated ) {
    $text = array(
        'Max' => '',
    );
    $translated = str_ireplace( array_keys( $text ), $text, $translated );
    return $translated;
}
add_filter( 'gettext', 'multi_change_translate_text', 20 );

function add_space_before_euro_symbol( $content ) {
    $content = preg_replace('/(\d)(€)/', '$1 $2', $content);
    return $content;
}

add_filter( 'the_content', 'add_space_before_euro_symbol', 20 );