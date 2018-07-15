<?php
/**
 * MX child theme functions and definitions
 *
 * @since MX 4.6
 */

//enqueue custom javascript

function firman_global_scripts(){
	wp_enqueue_script( 'firman-base64', get_stylesheet_directory_uri() . '/js/base64_encoder.js', array( 'jquery' ), '1.0', false );
	wp_enqueue_script( 'register-warranty', get_stylesheet_directory_uri() . '/js/register_warranty.js', array( 'jquery' ), '3.5', false );
	wp_enqueue_script( 'custom-script-global', get_stylesheet_directory_uri() . '/js/global_init.js', array( 'jquery' ), '5.7.4', false );
	wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/css/custom-style.min.css', array(), '5.5.3' );
}

add_action( 'wp_enqueue_scripts', 'firman_global_scripts', 99 );

function custom_search_result(  ) {


$args = array(
    'post_type'   => 'attachment',
    'post_status' => 'inherit', 
    'post_mime_type' => 'application/pdf',
    'posts_per_page' => '-1',
   
    'meta_query'  => array(
        array(
            'meta_key'     => '_wp_attached_file'
        )
    )
);
$query = new WP_Query($args);
$docu = $query->posts;
$manuals = 0;
$col = 0;

echo "<table id='tbl-display-manual'>";
 echo "<tr>";
foreach ($docu as $d) {
    
    if(strpos($d->post_title, 'Manual') !== false){
        echo "<td class='col-".$col."'><i class='fa fa-file-pdf-o' aria-hidden='true'></i><a target='_new' href='".wp_get_attachment_url($d->ID)."' >".$d->post_title."</a></br></td>";
        $col++;
    }
    
   if($col == 3) { 
        echo '</tr><tr>';
        $col = 0;
    }
    
}
echo "</tr>";
echo "</table>";


// echo "<pre>";
// print_r($docu);
// echo "</pre>";
   
}
add_shortcode( 'custom_search_result', 'custom_search_result' );

function get_search_result(){
    $manual_key = $_GET['manual-key'];
    
    if(isset($manual_key)){
        // echo $test;
        $counter = 0;
        $args = array(
        'post_type'   => 'attachment',
        'post_status' => 'inherit', 
        'post_mime_type' => 'application/pdf',
        'posts_per_page' => '-1',
       
        'meta_query'  => array(
            array(
                'meta_key'     => '_wp_attached_file',
                
                'value' => $manual_key,
                'compare' => 'LIKE'
            )
        )
    );
    $query = new WP_Query($args);
    $all_post = $query->posts;
    
    foreach ($all_post as $post) {
        
            if(strpos($post->post_title, 'Manual') !== false){
                echo "<div class='src-res'><i class='fa fa-file-pdf-o' aria-hidden='true'></i><a target='_new' href='".wp_get_attachment_url($post->ID)."' >".$post->post_title."</a></div></br>";
                $counter++;
            }
        
   
    }
    if($counter == 0){
        echo "no result";
    }
    }
        
    
// echo "<pre>";
// print_r($all_post);
// echo "</pre>";
    
    


}

add_shortcode('get_search_result','get_search_result');

if(function_exists('YITH_WCTM')){
    add_action( 'woocommerce_before_shop_loop_item', array( YITH_WCTM(), 'hide_add_to_cart_loop' ), 5 );
    
    add_filter( 'ywctm_get_vendor_option', 'hide_inquiry_tab', 10, 3 );

    function hide_inquiry_tab( $value, $post_id, $option ) {

        if ( $option == 'ywctm_inquiry_form_type' && ! YITH_WCTM()->check_add_to_cart_single( true, $post_id ) ) {

            $value = 'none';

        }

        return $value;

    }
}

function custom_pre_get_posts_query( $q ) {
    if( is_shop() ){
        $tax_query = (array) $q->get( 'tax_query' );
        $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array( 'parts-accessories' ), // Don't display products in the parts-accessories category on the shop page.
        'operator' => 'NOT IN'
        );
        $q->set( 'tax_query', $tax_query );
    }
}
// add_action( 'woocommerce_product_query', 'custom_pre_get_posts_query');

add_action('pre_get_posts','shop_filter_cat');

function shop_filter_cat($query) {
    if (!is_admin() && is_post_type_archive( 'product' ) && $query->is_main_query()) {
        if( empty($_GET) ){
                $query->set('tax_query', array(
                array('taxonomy' => 'product_cat',
                       'field' => 'slug',
                        'terms' => array( 'parts-accessories' ),
                        'operator' => 'NOT IN'
                    )
                )
            );
        }
    }
 }



/*
 * product card classes
 * */
add_action( 'woocommerce_init', 'firman_override_wc_template_hooks', 100 );

function firman_override_wc_template_hooks() {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	add_action( 'firman_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
}

require_once( dirname( __FILE__ ) . '/product_card_meta/custom-wc-template-functions.php' );

//check if Meta box plugin activated
if ( class_exists( 'RWMB_Loader' ) ) {
	require( dirname( __FILE__ ) . '/product_card_meta/class-product-card-meta.php' );
}

require_once( dirname( __FILE__ ) . '/product_card_meta/class-product-card-helper.php' );
require_once( dirname( __FILE__ ) . '/product_card_meta/class-single-product-register-sidebar.php' );
require_once( dirname( __FILE__ ) . '/product_card_meta/class-single-product-footer-template.php' );

//check if Contactform 7 exist;
if( class_exists( 'WPCF7') ){
	require_once( dirname( __FILE__ ) . '/product_card_meta/class-product-model-auto-option.php' );
}

require_once( dirname( __FILE__ ) . '/product_card_meta/class-custom-shortcodes.php' );
