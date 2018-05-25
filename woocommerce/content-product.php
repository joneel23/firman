<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php post_class(); ?>>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

    		
	<a href="<?php the_permalink(); ?>" class="product-thumbs-img">
	<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		 
		if (is_object($product)){

			 if ( has_post_thumbnail() ) {
				 echo '<span class="front">'.get_the_post_thumbnail(get_the_ID(), "shop_catalog" , array('alt' => get_the_title())).'</span>';
				 $attachment_ids = $product->get_gallery_image_ids();
				 if($attachment_ids && count($attachment_ids) > 0){
					$attachments = wp_get_attachment_image_src( $attachment_ids[0] , 'shop_single');
					
					  if(isset($attachments[0])){
						  echo '<span class="back"><img src="'.esc_url($attachments[0]).'" alt="" ></span>';
					 }
				 }
			 }

			if($product->is_featured()){
				echo apply_filters('woocommerce_sale_flash', '<span class="featured">'.__('Featured','MX').'</span>', $post, $product);
			}else if($product->is_on_sale()){
				 echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale!', 'woocommerce' ).'</span>', $post, $product);
			}else if(!$product->is_in_stock()){
				 echo '<span class="outofstock">'.__('Out of Stock','MX').'</span>';
			}else  if(!$product->get_price()){
				 echo '<span class="free">'.__('Free','MX').'</span>';
			}				 
		}
	?>
        </a>
        <div class="product-meta">
        
		<a href="<?php the_permalink(); ?>" class="product-title"><h3><?php the_title(); ?></h3></a>
		<div class="custom_prod_reviews" id="<?php echo "category-snippet-".$product->get_id(); ?>"></div>
		  
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			
			if( class_exists( 'YITH_WCWL_UI' ) ){
				echo mx_get_wishlist();
			}else{
				echo '<a href="'.get_permalink().'" class="button product-details"><i class="fa fa fa-list"></i></a>';
			}
			
		?>
	    	
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		
		</div>
</li>