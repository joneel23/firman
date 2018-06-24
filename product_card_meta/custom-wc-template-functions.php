<?php
/**
 * Created by BlueFoxMedia.
 * User: BlueFoxDev
 * Date: 5/30/2018
 * Time: 6:47 AM
 */

/**
 * Add default product tabs to product pages.
 *
 * @param array $tabs Array of tabs.
 * @return array
 */
function woocommerce_default_product_tabs( $tabs = array() ) {
	global $product, $post;

	// Description tab - shows product content.
	if ( $post->post_content ) {
		$tabs['description'] = array(
			'title'    => __( 'Description', 'woocommerce' ),
			'priority' => 10,
			'callback' => 'woocommerce_product_description_tab',
		);
	}

	// Additional information tab - shows attributes.
	if ( $product && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
		$tabs['additional_information'] = array(
			'title'    => __( 'Additional information', 'woocommerce' ),
			'priority' => 20,
			'callback' => 'woocommerce_product_additional_information_tab',
		);
	}

	// Reviews tab - shows comments.
	//remove reviews count %d on title
	if ( comments_open() ) {
		$tabs['reviews'] = array(
			/* translators: %s: reviews count */
			'title'    => sprintf( __( 'Reviews', 'woocommerce' ), $product->get_review_count() ),
			'priority' => 30,
			'callback' => 'comments_template',
		);
	}

	return $tabs;
}