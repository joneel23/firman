 <?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); 

// get page layout
$layout = mx_get_page_layout(); 

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
            <aside class="col-md-3 col-sm-4"><?php
				/**
				 * woocommerce_sidebar hook
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				do_action('woocommerce_sidebar');
			?></aside>
        <?php } ?>
		
        <section class="<?php echo $layout == 1 ? 'col-md-12 col-sm-12' : 'col-md-9 col-sm-8'; ?>">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>
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
	
	
<script type="text/javascript">
	jQuery(document).ready(function($){
          //display
        	POWERREVIEWS.display.render({
        	api_key: 'adea19b5-b8b5-4faf-b3c7-6282f0d0c87d',
        	locale: 'en_US',
        	merchant_group_id: '77856',
        	merchant_id: '412359',
        	page_id: '<?php echo $product->get_id(); ?>',
        	review_wrapper_url: 'https://www.firmanpowerequipment.com/write-a-review/?pr_page_id=<?php echo $product->get_id(); ?>',
        	REVIEW_DISPLAY_SNAPSHOT_TYPE:'SIMPLE',
        	product:{
                name: '<?php echo $product->get_name(); ?>', 
                url: '<?php echo get_permalink( $product->get_id() ); ?>',
                description: '<?php echo $product->get_name(); ?>',
                image_url: '<?php echo get_the_post_thumbnail_url( $product->get_id(), 'full' ); ?>',
                category_name: '<?php echo get_term_by( 'id', $product->get_category_ids()[0], 'product_cat', 'ARRAY_A' )['name']; ?>',
				upc: '<?php echo $product->get_sku(); ?>',
				brand_name: 'Firman Power Equipment',
				price: '',
                in_stock: '<?php  if($product->get_stock_status() == 'instock'){ echo 'true'; }else{ 'false'; } ?>',
                },
        	components: {
                ReviewSnippet: 'pr-reviewsnippet',
        		ReviewDisplay: 'pr-reviewdisplay'
        	}
    	});


          $( ".product_title.entry-title" ).after(function() {
            return "<div class='cust_inline' id='<?php echo "category-snippet-".$product->get_id(); ?>'></div><div id='pr-reviewsnippet'></div>";
          });
    	
	});
</script>

<?php get_footer('shop'); ?>



