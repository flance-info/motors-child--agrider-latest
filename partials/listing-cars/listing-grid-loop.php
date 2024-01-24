<?php

$regular_price_label = get_post_meta(get_the_ID(), 'regular_price_label', true);
$special_price_label = get_post_meta(get_the_ID(), 'special_price_label', true);

$price      = get_post_meta(get_the_id(), 'price', true);
$sale_price = get_post_meta(get_the_id(), 'sale_price', true);

$car_price_form_label = get_post_meta(get_the_ID(), 'car_price_form_label', true);

$regular_price_description = get_post_meta(get_the_ID(), 'regular_price_description', true);

$data = array(
    'data_price' => 0,
);

if (!empty($price)) {
    $data['data_price'] = $price;
}

if (!empty($sale_price)) {
    $data['data_price'] = $sale_price;
}

if (empty($price) && !empty($sale_price)) {
    $price = $sale_price;
}

$taxonomies = apply_filters('stm_get_taxonomies', array());
foreach ($taxonomies as $val) {
    $taxData = stm_get_taxonomies_with_type($val);
    if (!empty($taxData['numeric']) && !empty($taxData['slider'])) {
        $value = get_post_meta(get_the_id(), $val, true);
        $data['data_' . str_replace('-', '__', $val)] = $value;
        $data['atts'][]                                   = str_replace('-', '__', $val);
    }
}

?>

<?php if (!apply_filters('stm_is_magazine', true)) : ?>

    <?php do_action('stm_listings_load_template', 'loop/default/grid/start', $data); ?>

    <?php do_action('stm_listings_load_template', 'loop/default/grid/image'); ?>

    <div class="listing-car-item-meta">

        <?php
        $price      = get_post_meta(get_the_id(), 'price', true);
        $sale_price = get_post_meta(get_the_id(), 'sale_price', true);
        $leasing_price = get_post_meta(get_the_id(), 'leasing_price', true);
        do_action(
            'stm_listings_load_template',
            'loop/default/grid/title_price',
            array(
                'price'                => $price,
                'sale_price'           => $sale_price,
                'car_price_form_label' => $car_price_form_label,
            )
        );

        if (has_action('stm_multilisting_load_template')) {
            do_action('stm_multilisting_load_template', 'templates/grid-listing-data');
        } else {
            do_action('stm_listings_load_template', 'loop/default/grid/data');
        }
        ?>
        <?php if ($price || $sale_price || $leasing_price) : ?>
            <div class="car-prices">
                <?php if ($price) : ?>
                    <p class="stm-regular-price"><span><?php esc_html_e('Price', 'motors-child'); ?>:</span>
                        <?php if (!empty($sale_price)) : ?>
                            <span class="stm-line-through"><?php echo esc_html(apply_filters('stm_filter_price_view', '', $price)); ?></span>
                        <?php else : ?>
                            <?php echo esc_html(apply_filters('stm_filter_price_view', '', $price)); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
                <?php if ($sale_price) : ?>
                    <p class="stm-sale-price"><span><?php esc_html_e('Sale price', 'motors-child'); ?>:</span> <?php echo esc_html(apply_filters('stm_filter_price_view', '', $sale_price)); ?></p>
                <?php endif; ?>
                <?php /* if ($leasing_price) : ?>
                    <p class="stm-leasing-price"><span><?php esc_html_e('Leasing price', 'motors-child'); ?>:</span> <?php echo esc_html(apply_filters('stm_filter_price_view', '', $leasing_price)); ?></p>
                <?php endif; */ ?>

                <?php if ($regular_price_description) : ?>
                    <p class="stm-description-price">
                        <span><?php esc_html_e('Leasing price', 'motors-child'); ?>:</span>
                        <!-- <?php echo $regular_price_description; ?> -->
                        <?php echo $sale_price ? apply_filters('stm_filter_price_view', '', ($sale_price * 0.30))  : apply_filters('stm_filter_price_view', '', ($price * 0.30)); ?>
                    </p>
                <?php endif;  ?>

            </div>
        <?php endif; ?>
    </div>
    </a>
    </div>
<?php else :

    get_template_part('partials/listing-cars/listing-grid-loop-magazine');

endif; ?>
