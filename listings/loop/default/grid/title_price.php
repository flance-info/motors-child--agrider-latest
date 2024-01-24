<?php
if ( apply_filters( 'stm_is_dealer_two', false ) ) {
    $selling_online_global = apply_filters( 'stm_me_get_nuxy_mod', false, 'enable_woo_online' );
    $sell_online           = ( $selling_online_global ) ? ! empty( get_post_meta( get_the_ID(), 'car_mark_woo_online', true ) ) : false;
}
?>
<div class="car-meta-top heading-font clearfix">
    <div class="car-title" data-max-char="<?php echo esc_attr( apply_filters( 'stm_me_get_nuxy_mod', 44, 'grid_title_max_length' ) ); ?>">
        <?php
        if ( ! apply_filters( 'stm_is_listing_three', false ) ) {
            echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID() ) );
        } else {
            echo wp_kses_post( trim( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), true ) ) );
        }
        ?>
    </div>
</div>
