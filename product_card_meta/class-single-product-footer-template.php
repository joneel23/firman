<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Created by BlueFoxMedia.
 * User: BlueFoxDev
 * Date: 5/13/2018
 * Time: 11:02 AM
 */
class Firman_Single_Product_Footer_Template {

	public function __construct() {
		add_action( 'woocommerce_after_single_product', array($this, 'display_get_in_touch_html'), 99 );

//		add_action( 'wc_after_single_product_fotter_col_1', array($this, 'get_single_footer_widget') );
	}

	public function get_single_footer_widget($sidebar_name, $id){
		if ( is_active_sidebar( $sidebar_name ) ) : ?>
		<ul id="<?php echo $id; ?>">
			<?php dynamic_sidebar( $sidebar_name ); ?>
		</ul>
		<?php endif;

	}

	public function display_get_in_touch_html(){

        ?>
		<div class="get-in-touch">
            <h2>Get in touch with us</h2>
            <div class="row">
                <div class="col-lg-4">
                    <?php $this->get_single_footer_widget( 'single-footer-sidebar', 'product-inquiry-form'); ?>
                </div>
                <div class="col-lg-4">
                    <?php $this->get_single_footer_widget( 'single-footer-sidebar-2', 'our-latest-news'); ?>
                </div>
                <div class="col-lg-4">
                    <?php $this->get_single_footer_widget( 'single-footer-sidebar-3', 'our-contact-details'); ?>
                </div>
            </div>
		</div>
        <?php
	}
}

new Firman_Single_Product_Footer_Template();