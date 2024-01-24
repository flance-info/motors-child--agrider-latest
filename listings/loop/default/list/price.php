<?php
// Price.
$regular_price_label = get_post_meta( get_the_ID(), 'regular_price_label', true );
$special_price_label = get_post_meta( get_the_ID(), 'special_price_label', true );

$price      = get_post_meta( get_the_id(), 'price', true );
$sale_price = get_post_meta( get_the_id(), 'sale_price', true );
$leasing_price = get_post_meta( get_the_id(), 'leasing_price', true );

if ( empty( $price ) && ! empty( $sale_price ) ) {
    $price = $sale_price;
}
$car_price_form_label = get_post_meta( get_the_ID(), 'car_price_form_label', true );
?>
<?php if($price || $sale_price || $leasing_price): ?>
<div class="car-prices car-prices-list">
    <?php if($price): ?>
        <p class="stm-regular-price"><span><?php esc_html_e('Price', 'motors-child'); ?>:</span> <?php echo esc_html( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></p>э
    <?php endif; ?>
    <?php if($sale_price): ?>
        <p class="stm-sale-price"><span><?php esc_html_e('Sale price', 'motors-child'); ?>:</span> <?php echo esc_html( apply_filters( 'stm_filter_price_view', '', $sale_price ) ); ?></p>
    <?php endif; ?>

</div>
<?php endif; ?>
