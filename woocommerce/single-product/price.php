<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$term =  has_term( 'parts-accessories', 'product_cat', $product->get_id() );

if ( $term ) :

?>
    <div class="row">
    <div class="col-lg-3">
        <div itemprop="offers" class="product_price" itemscope itemtype="http://schema.org/Offer">

            <p class="price"><?php echo $product->get_price_html(); ?></p>

            <meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>" />
            <meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
            <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

        </div>
    </div>

<?php endif;?>
        



