<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


//column number for product page
$GLOBALS['woocommerce_loop'] = array(3);

get_header('shop');

$shop_page_id = wc_get_page_id( 'shop' );

$layout = mx_get_page_layout($shop_page_id); 

?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
	?>
<div id="page-content-wrap">   
	<div id="main" class="container">
		<div class="row">
        <?php if($layout == 2) { ?>
            <div id="mobile-filter" class="btn-container">
                <button class="button card-button off-filter">Display filter</button>
            </div>
            <aside class="col-md-3 col-sm-4 off-filter"><?php
				/**
				 * woocommerce_sidebar hook
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				do_action('woocommerce_sidebar');
			?></aside>
        <?php } ?>
		
        <section class="<?php echo $layout == 1 ? 'col-md-12 col-sm-12' : 'col-md-9 col-sm-8'; ?>">
     
        
		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>
                 
				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>
                    	
					<?php wc_get_template_part( 'content', 'product' ); ?>

    
				<?php endwhile; // end of the loop. ?>
                    
			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				//do_action( 'woocommerce_after_shop_loop' );
				 mx_content_pagination('nav-bottom' , 'pagination-centered');
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	
		</section>
        <?php if($layout == 3) { ?> 
            <aside class="col-md-3 col-sm-4"><?php
			/**
			 * woocommerce_sidebar hook
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action('woocommerce_sidebar');
		?></aside>
        <?php } ?>
	
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>
<?php get_footer('shop'); ?>

<script>

     jQuery(document).ready(function($){
        var products = $(".products");
        var arr_render = [];

        products.find(' > li').each(function(index){
            var class_str = $(this).attr('class').split(' ');
            var post_id = class_str[0].split('-')[1];

            if(post_id != "category"){
                arr_render.push({
                    locale: 'en_US',
                    merchant_group_id: '77567',
                    page_id: post_id,
                    merchant_id: '412359',
                    api_key: 'adea19b5-b8b5-4faf-b3c7-6282f0d0c87d',
                    review_wrapper_url: 'https://www.firmanpowerequipment.com/write-a-review/?pr_page_id='+post_id,
                    components: {
                        CategorySnippet: 'category-snippet-'+post_id
                    }
                });

            }

            if(index == (products.find(' > li').length - 1))
            {
                POWERREVIEWS.display.render(arr_render);
            }

        });

       
    });
</script>