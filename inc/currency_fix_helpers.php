<?php

if ( ! function_exists( 'stm_listing_price_view_child' ) ) {
	/**
	 * Price delimeter
	 */
	function stm_listing_price_view_child( $response, $price = '' ) {
		if ( ! empty( $price ) ) {
			$price_label          = stm_get_price_currency_child();
			$price_label_position = apply_filters( 'stm_me_get_nuxy_mod', 'left', 'price_currency_position' );
			$price_delimeter      = apply_filters( 'stm_me_get_nuxy_mod', ' ', 'price_delimeter' );

			//echo $price_label;

			if ( strpos( $price, '<' ) !== false || strpos( $price, '>' ) !== false ) {
				$price_convert = number_format( apply_filters( 'get_conver_price', filter_var( $price, FILTER_SANITIZE_NUMBER_INT ) ), 0, '', $price_delimeter );
			} elseif ( strpos( $price, '-' ) !== false ) {
				$price_array   = explode( '-', $price );
				$price_l       = ( ! empty( $price_array[0] ) ) ? number_format( apply_filters( 'get_conver_price', $price_array[0] ), 0, '', $price_delimeter ) : '';
				$price_r       = ( ! empty( $price_array[1] ) ) ? number_format( apply_filters( 'get_conver_price', $price_array[1] ), 0, '', $price_delimeter ) : '';
				$price_convert = ( ! empty( $price_l ) && ! empty( $price_r ) ) ? $price_l . '-' . $price_r : ( ( ! empty( $price_l ) ) ? $price_l : $price_r );
			} else {
				$price_convert = number_format( apply_filters( 'get_conver_price', $price ), 0, '', $price_delimeter );
			}

			if ( 'left' === $price_label_position ) {

				$response = $price_label . $price_convert;

				if ( strpos( $price, '<' ) !== false ) {
					$response = '&lt; ' . $price_label . $price_convert;
				} elseif ( strpos( $price, '>' ) !== false ) {
					$response = '&gt; ' . $price_label . $price_convert;
				}
			} else {
				$response = $price_convert . $price_label;

				if ( strpos( $price, '<' ) !== false ) {
					$response = '&lt; ' . $price_convert . $price_label;
				} elseif ( strpos( $price, '>' ) !== false ) {
					$response = '&gt; ' . $price_convert . $price_label;
				}
			}

			return $response;
		}
	}

	add_filter( 'stm_filter_price_view', 'stm_listing_price_view_child', 12, 2 );
}

if ( ! function_exists( 'stm_get_price_currency_child' ) ) {
	/**
	 * Get price currency
	 */
	function stm_get_price_currency_child() {
		$currency = apply_filters( 'stm_me_get_nuxy_mod', '$', 'price_currency' );
		if ( isset( $_COOKIE['stm_current_currency'] ) ) {
			$cookie   = explode( '-', $_COOKIE['stm_current_currency'] );
			$currency =  urldecode($cookie[0]);
		}

		return $currency;
	}
}

if ( ! function_exists( 'stm_getCurrencySelectorHtml' ) ) {
	function stm_getCurrencySelectorHtml() {
		$show_currency_select = apply_filters( 'stm_me_get_nuxy_mod', false, 'top_bar_currency_enable' );
		$currency_list        = apply_filters( 'stm_me_get_nuxy_mod', '', 'currency_list' );

		if ( ! empty( $currency_list ) && is_array( $currency_list ) ) {
			$current_currency = '';
			if ( isset( $_COOKIE['stm_current_currency'] ) ) {
				$mc               = explode( '-',  $_COOKIE['stm_current_currency'] );
				$current_currency = $mc[0];

			}

			$currency[0] = apply_filters( 'stm_me_get_nuxy_mod', 'USD', 'price_currency_name' );
			$symbol[0]   = apply_filters( 'stm_me_get_nuxy_mod', '$', 'price_currency' );
			$to[0]       = '1';

			if ( ! empty( $currency_list ) ) {
				foreach ( $currency_list as $k => $val ) {
					if ( ! empty( $val['currency'] ) && ! empty( $val['symbol'] ) && ! empty( $val['to'] ) ) {
						$currency[] = trim( $val['currency'] );
						$symbol[]   = trim( $val['symbol'] );
						$to[]       = trim( $val['to'] );
					}
				}
			}

			// translators: %s: Selected currency.

			$selected_currency_text = __( 'Currency (%s)', 'motors' );
			$select_html            = '<div class="pull-left currency-switcher">';
			$select_html           .= "<div class='stm-multiple-currency-wrap'><select data-translate='" . esc_attr( $selected_currency_text ) . "' data-class='stm-multi-currency' name='stm-multi-currency'>";
			$count_currency         = count( $currency );
			for ( $q = 0; $q < $count_currency; $q ++ ) {
				$selected      = ( $symbol[ $q ] == urldecode($current_currency) ) ? 'selected' : '';
				$val           = html_entity_decode( $symbol[ $q ] ) . '-' . $to[ $q ];
				$currencyTitle = $currency[ $q ];

				if ( ! isset( $_COOKIE['stm_current_currency'] ) && 0 === $q || ! empty( $selected ) ) {
					$currencyTitle = sprintf( $selected_currency_text, $currency[ $q ] );
				}

				$select_html .= "<option value='{$val}' " . $selected . ">{$currencyTitle}</option>";
			}
			$select_html .= '</select></div>';
			$select_html .= '</div>';

			if ( count( $currency ) > 1 && $show_currency_select ) {
				echo wp_kses(
					$select_html,
					array(
						'select' => array(
							'data-translate' => array(),
							'data-class'     => array(),
							'name'           => array(),
						),
						'option' => array(
							'value'    => array(),
							'selected' => array(),
						),
						'div'    => array(
							'class' => array(),
						),
					)
				);
			}
		}
	}
}

if ( ! function_exists( 'getConverPrice' ) ) {
	function getConverPrice( $price ) {
		if ( isset( $_COOKIE['stm_current_currency'] ) ) {
			$default_currency = get_option( 'price_currency', '$' );
			$cookie           = explode( '-', sanitize_text_field( $_COOKIE['stm_current_currency'] ) );
			$cookie           = ( ! empty( $cookie[1] ) ) ? $cookie[1] : $default_currency;
			if ( is_numeric( $price ) && is_numeric( $cookie ) ) {
				$price = ( $price * $cookie );
			}
		}

		return $price;
	}
	add_filter( 'get_conver_price', 'getConverPrice' );
}