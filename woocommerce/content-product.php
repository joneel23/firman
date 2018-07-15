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
$archive = true;
$archive_class = 'test-card';

$card_enabled      = rwmb_meta( 'card_activate' );
$card_model        = rwmb_meta( 'card_model' );
$card_title        = rwmb_meta( 'card_title' );
$card_summary      = rwmb_meta( 'card_summary' );
$card_product_type = rwmb_meta( 'card_product_type' );

$card_enabled = ( ! empty( $card_enabled ) ) ? $card_enabled : false;

$terms = has_term( 'parts-accessories', 'product_cat', get_the_ID() );

if ( $card_enabled ) :

?>
<li <?php post_class(); ?> >
    <div class="product-item-container">
	<?php
		echo '<p class="card-model"><a href="'.get_permalink().'">Model: ' . rwmb_meta('card_model') . '</a></p>';
	?>
    <div class="rating-container">
        <div class="rating-desc">Rating </div><div class="custom_prod_reviews" id="<?php echo "category-snippet-".$product->get_id(); ?>"></div>
        <a class="write-a-review" title="Write a Review" href="/write-a-review/?pr_page_id=<?php the_ID(); ?>&pr_merchant_id=412359&pr_api_key=adea19b5-b8b5-4faf-b3c7-6282f0d0c87d&pr_merchant_group_id=77856"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    </div>
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

				 $attachment_ids = $product->get_gallery_image_ids();

//				 if ( $attachment_ids && count( $attachment_ids ) > 0 ) {
//                     $image_link = 'http://staging.firmanpowerequipment.com/wp-content/uploads/2018/06/Firman-H03651_2.jpg';
//					 $get_attach = wp_get_attachment_image( $attachment_ids[0], 'large', false, array( 'class' => 'zoom', 'data-magnify-src' => $image_link ) );
//
//					 //var_dump($get_attach);
//					 if ( isset( $attachment_ids[0] ) ) {
//						 echo '<span class="back-1">' . $get_attach . '</span>';
//					 }
//				 }

			     echo '<span class="front">'.get_the_post_thumbnail( get_the_ID(), "shop_catalog" , array( 'alt' => get_the_title() ) ).'</span>';


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
        <div class="product-meta<?php echo ( $terms ) ? ' accessories' : ''; ?>">
        
		<a href="<?php the_permalink(); ?>" class="product-title"><h3><?php echo $card_title; ?></h3></a>

		<?php
        //card summary
		if ( is_archive() ) {
			echo $card_summary;
		} else {
			echo wc_get_product_category_list( $product->get_id(), ', ', '<p class="text-center"><span class="posted_in">' . _n( '<b>Series:</b>', '<b>Series:</b>', $size, 'woocommerce' ) . ' ', '</span></p>' );
            if( ! $terms ) {
	            echo '<p class="text-center"><b>Product Type:</b> ' . $card_product_type . '</p>';
            }
			echo $card_summary;
        }

		?>

		</div>
        <?php
        /**
         * woocommerce_after_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );
        ?>
        <div class="btn-container">
	        <?php

	        if ( $terms ) {


                if( class_exists( 'YITH_WCWL_UI' ) ){
                    echo mx_get_wishlist();
                }else{
                    echo '<a href="'.get_permalink().'" class="button product-details"><i class="fa fa fa-list"></i></a>';
                }

		        do_action( 'woocommerce_after_shop_loop_item' );

	        } else {
		        echo '<a class="button card-button" href="' . get_permalink() . '">More Information</a>';
            }

	        ?>
        </div>

    </div>
</li>

<?php else : ?>

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

					$attachment_ids = $product->get_gallery_image_ids();

					if ( $attachment_ids && count( $attachment_ids ) > 0 ) {

						$get_attach = wp_get_attachment_image( $attachment_ids[0], 'medium' );
						//var_dump($get_attach);
						if ( isset( $attachment_ids[0] ) ) {
							echo '<span class="back">' . $get_attach . '</span>';
						}
					}

				    echo '<span class="front">'.get_the_post_thumbnail(get_the_ID(), "shop_catalog" , array('alt' => get_the_title())).'</span>';


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

<?php endif; ?>