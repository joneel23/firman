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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

$card_enabled = rwmb_meta( 'card_activate' );
$card_type    = rwmb_meta( 'card_product_type' );
$card_warranty   = rwmb_meta( 'card_warranty' );

$card_enabled = ( ! empty( $card_enabled ) ) ? $card_enabled : false;

$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );

$terms = has_term( 'parts-accessories', 'product_cat', get_the_ID() );

if ( class_exists( 'YITH_WCWL_UI' ) ) {
	echo mx_get_wishlist( __( 'Add to Wishlist', 'MX' ), __( 'Had added, view Wishlist', 'MX' ), __( 'Already added, view Wishlist', 'MX' ) );
}

if ( class_exists( 'Firman_Product_Card_Meta' ) ) {
	$certification = Firman_Product_Card_Meta::get_certification_img( $product->get_id() );
}

if ( $post->post_excerpt ) {
	?>
    <div itemprop="description" class="short-description">
		<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
    </div>
	<?php
}

if ( $card_enabled ) :
?>
<div class="row">
    <div class="col-lg-5 prod-meta">
		<?php
        if( ! $terms ) {
	        echo wc_get_product_category_list( $product->get_id(), ', ', '<p class="single-product-meta"><span class="posted_in">' . _n( '<strong>Series:</strong>', '<strong>Series:</strong>', $size, 'woocommerce' ) . ' ', '</span></p>' );
		}
        ?>

		<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && $product->get_sku() ) : ?>
            <p class="single-product-meta"><span itemprop="productID" class="sku_wrapper"><?php _e( '<strong>SKU:</strong>', 'woocommerce' ); ?> <span
                            class="sku"><?php echo $product->get_sku(); ?></span></span></p>

		<?php endif; ?>

    </div>
    <div class="col-lg-7 prod-meta">

		<?php
        if ( ! $terms ) {
	        echo '<div class="cert-wrapper"><span><strong>Certificatitons:</strong></span> ' . $certification . '</div>';

	        echo '<p class="single-product-meta"><strong>Product Type:</strong> ' . $card_type . '</p>';
        } else {
	        echo '<p class="single-product-meta"><strong>Warranty:</strong> ' . $card_warranty . '</p>';
        }
        ?>

    </div>
    <div class="col-lg-12">
		<?php if ( mx_get_options_key( 'woocommerce-share-enable' ) == "on" ) : ?>
            <div class="woocommerce-share">
				<?php if ( intval( mx_get_options_key( 'woocommerce-share-type' ) ) == 0 ) {
					echo '<strong>Share Your Experience:</strong> ' . do_shortcode( '[share link="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_title() ) . '"]' );
				} else { ?>
					<?php echo mx_get_options_key( 'woocommerce-share-content' ); ?>
				<?php } ?>
            </div>
		<?php endif; ?>
    </div>
</div>

<?php else : ?>

<div class="product_meta">
	
	<?php do_action( 'woocommerce_product_meta_start' ); ?>
	
	<?php if ( get_option( 'woocommerce_enable_review_rating' ) != 'no' ) { ?>
		<?php if ( $rating_html = wc_get_rating_html($product->get_id()) ) : ?>
            <span class="product_rate_meta"><?php _e('Rating:','MX'); ?><span class="product_rate_star">
	    <?php
	    
		$rating_count = $product->get_rating_count();
		$review_count = $product->get_review_count();
		$average      = $product->get_average_rating();
		if ( $rating_count > 0 ) : ?>
		
			<div class="star-rating">
				<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
					<?php
					/* translators: 1: average rating 2: max rating (i.e. 5) */
					printf(
						__( '%1$s out of %2$s', 'woocommerce' ),
						'<strong class="rating">' . esc_html( $average ) . '</strong>',
						'<span>5</span>'
					);
					?>
					<?php
					/* translators: %s: rating count */
					printf(
						_n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'woocommerce' ),
						'<span class="rating">' . esc_html( $rating_count ) . '</span>'
					);
					?>
				</span>
			</div>
		
		<?php endif; ?>
	    </span></span>
        <?php endif; ?>
    <?php } ?>
    
	<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && $product->get_sku() ) : ?>
		<span itemprop="productID" class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo $product->get_sku(); ?></span>.</span>
	<?php endif; ?>
	
	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
		echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $size, 'woocommerce' ) . ' ', '</span>' );
	?>

	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
		echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $size, 'woocommerce' ) . ' ', '</span>' );
	?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>

<?php
if(mx_get_options_key('woocommerce-share-enable') == "on"){ ?>
	<div class="woocommerce-share">
	<?php if(intval(mx_get_options_key('woocommerce-share-type')) == 0) {
		echo do_shortcode('[share link="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'"]');
	 } else { ?>
	<?php echo  mx_get_options_key('woocommerce-share-content'); ?>
	<?php } ?>
	</div>
<?php } ?>

<?php endif;
