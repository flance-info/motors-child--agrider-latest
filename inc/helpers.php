<?php
add_filter('stm_get_car_listings', function ($labels) {

    $sortBySlug = function ($a, $b) {
        $slugOrder = ['evjarat', 'mileage', 'drive', 'transmission']; // Add other slugs as needed
        $aSlugIndex = array_search($a['slug'], $slugOrder);
        $bSlugIndex = array_search($b['slug'], $slugOrder);

        return $aSlugIndex - $bSlugIndex;
    };

    // Use usort with the custom comparison function
    usort($labels, $sortBySlug);

    // Return the sorted array
    return $labels;
});


function enqueue_help_custom_scripts() {
  wp_enqueue_script( 'help-custom-script', get_stylesheet_directory_uri() . '/assets/js/helpers.js', array('jquey'), time(), true );
}
add_action('wp_enqueue_scripts', 'enqueue_help_custom_scripts');