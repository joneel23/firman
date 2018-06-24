<?php

/**
 * Created by BlueFoxMedia.
 * User: BlueFoxDev
 * Date: 5/19/2018
 * Time: 11:16 AM
 */
class Firman_Product_Card_Helper {

	/**
	 * Get product generator model by card meta or post title
	 *
	 * @param int $product_id productID
	 *
	 * @param boolean $accessories
	 *
	 * @return string
	 */
	public static function get_product_generator_model( $product_id, $accessories = false ) {

		$card_model_meta = get_post_meta( $product_id, 'card_model', true );

		if ( empty( $card_model_meta ) ) {
			$product_title       = get_the_title( $product_id );
			$product_title_split = explode( ' ', $product_title );
			$model               = ( ! empty( $product_title_split ) ) ? ( $accessories == false ? $product_title_split[0] : array_pop( $product_title_split ) ) : '';

		} else {
			$model = $card_model_meta;
		}

		return $model;

	}

	public static function get_attachment_pdf_file( $file_name ){
		$args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'post_mime_type' => 'application/pdf',
			'posts_per_page' => -1,
			'meta_query'  => array(
				array(
					'meta_key'     => '_wp_attached_file',
					'value' => $file_name,
					'compare' => 'LIKE'
				)
			)
		);
		$query_result = get_posts($args);

		return $query_result;

	}
}
