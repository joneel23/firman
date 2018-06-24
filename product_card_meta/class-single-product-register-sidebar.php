<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Created by BlueFoxMedia.
 * User: BlueFoxDev
 * Date: 5/5/2018
 * Time: 10:22 AM
 */
class Firman_Product_Register_Sidebar {

	public function __construct() {

		add_action( 'widgets_init', array($this, 'single_register_sidebar') );
	}

	/**
	 * Add new widget sidebar
	 *
	 */
	public function single_register_sidebar() {
		register_sidebars( 4, array(
			'name' => esc_html__( 'Single Footer Column %d', 'firman' ),
			'id' => 'single-footer-sidebar',
			'description' => esc_html__( 'Widget content area for single page footer', 'firman' ),
			'class' => 'single-product-sidebar',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
		) );
	}

}

new Firman_Product_Register_Sidebar();