<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$posts_per_page = 4;
$columns = 4;
$woocommerce_loop['columns'] 	= $columns;

$related_accessories = rwmb_meta( 'related_accessories' );

if( count($related_accessories) == 5 ){
    $columns = 5;
    var_dump($columns);
}



if ( $related_accessories ) : ?>

    <div class="related products">

        <div class="mx-title">
            <h4 class="post-title"><?php _e( 'Related Accessories', 'MX' ); ?></h4>
            <div class="line"></div>
            <div class="clear"></div>
        </div>

		<?php woocommerce_product_loop_start(); ?>

		<?php foreach ( $related_accessories as $pid ) : ?>

			<?php
			$post_object = get_post( $pid );
			setup_postdata( $GLOBALS['post'] =& $post_object );
			wc_get_template_part( 'content', 'product' ); ?>

		<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

    </div>

<?php elseif ( $related_products ) : ?>

	<div class="related products">
		
        <div class="mx-title">
            <h4 class="post-title"><?php _e( 'Related Products', 'MX' ); ?></h4>
            <div class="line"></div>
            <div class="clear"></div>
        </div>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
				 	$post_object = get_post( $related_product->get_id() );
					setup_postdata( $GLOBALS['post'] =& $post_object );
					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
