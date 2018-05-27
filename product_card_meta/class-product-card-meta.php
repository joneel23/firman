<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Created by BlueFoxMedia.
 * User: BlueFoxDev
 * Date: 5/5/2018
 * Time: 10:22 AM
 */
class Firman_Product_Card_Meta {
	/*
	 * Set attributes
	 * */
    private $set_card_prefix;

    private function get_card_prefix(){
        return $this->set_card_prefix = 'card_';
    }

    private function check_post_type(){
	    $post_id = $this->get_post_id();
	    $post_type = get_post_type($post_id);

	    return $post_type;
    }

    private function get_post_id(){
	    $post_id = isset( $_GET['post'] ) ? $_GET['post'] : '';

	    return $post_id;
    }

	public function __construct( ) {
		add_filter( 'rwmb_meta_boxes', array( $this, 'firman_product_card_meta_generators' ), 10 );

		add_action( 'rwmb_after_save_field', array( $this, 'firman_after_save_fields' ), 10, 5 );

		add_filter( 'post_class', array( $this, 'firman_product_list_class' ), 20 );
	}

	public function init_rwmb_meta_boxes(){
		$post_id = isset( $_GET['post'] ) ? $_GET['post'] : '';

		$post_type = get_post_type($post_id);

		if($post_type === 'product') {
		    add_filter( 'rwmb_meta_boxes', array( $this, 'firman_product_card_meta' ) );
		}
    }

	/**
	 * Add new class for post_class filter in archive product loop
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	public function firman_product_list_class( $classes ) {
		global $product;

		if ( ! empty( $product ) && is_archive() ) {

			$product_id   = $product->get_id();
			$card_enabled = rwmb_meta( 'card_activate', $product_id );

			if ( $card_enabled ) {
				$card_class = array( 'card-catalog' );
				$classes    = array_merge( $classes, $card_class );
			}

		}

		return $classes;
	}

	public function firman_product_card_meta_generators(){
        $prefix = $this->get_card_prefix();

		$post_id = $this->get_post_id();

        $product = wc_get_product( $post_id );

        $product_attributes = ( $product ) ? $this->firman_card_get_attributes_value( $product ) : '';
        $post_title         = get_the_title( $post_id );
        $post_title_split   = explode( ' ', $post_title );

		$product_cat_accessories = has_term( 'parts-accessories', 'product_cat', $post_id );

		$model              = ( ! empty( $post_title_split ) ) ? $post_title_split[0] : '';
		$product_attributes = ( ! empty( $product_attributes ) ) ? $product_attributes : '';
		$custom_title       = ( ! empty( $post_title_split ) ) ? $post_title_split[1] . ' Watt Generator' : '';

        if( $product_cat_accessories ){
	        $model =  ( ! empty( $post_title_split ) ) ? array_pop($post_title_split) : '';
	        $custom_title = '';
	        $product_attributes = '';
        }

        if( $post_title_split[0] == 'AUTO-DRAFT'){
            $model = '';
        }

        //set meta box fields default
        $meta_boxes_fields_default = array(
            array(
                'id'   => $prefix . 'activate',
                'name' => esc_html__( 'Enable Card Details', 'firman' ),
                'type' => 'checkbox',
                'desc' => esc_html__( '', 'firman' ),
                'std'  => true
            ),
            array(
                'id'          => $prefix . 'model',
                'type'        => 'text',
                'name'        => esc_html__( 'Model', 'firman' ),
                'placeholder' => esc_html__( 'model number', 'firman' ),
                'std'         => $model,
            ),
            array(
                'id'          => $prefix . 'product_type',
                'type'        => 'text',
                'name'        => esc_html__( 'Product Type', 'firman' ),
                'placeholder' => esc_html__( 'product type', 'firman' ),
            ),
	        array(
		        'id'          => $prefix . 'title',
		        'type'        => 'text',
		        'name'        => esc_html__( 'Custom Title', 'firman' ),
		        'placeholder' => esc_html__( 'custom title', 'firman' ),
		        'std'         => trim( $custom_title ),
	        ),
	        array(
		        'id'   => $prefix . 'summary',
		        'name' => esc_html__( 'Summary', 'firman' ),
		        'type' => 'wysiwyg',
		        'desc' => esc_html__( 'Card short description', 'firman' ),
		        'std'  => $product_attributes,
	        ),

        );

        $meta_boxes[] = array(
            'id'         => 'product_card',
            'title'      => esc_html__( 'Product Card Details', 'firman' ),
            'post_types' => array( 'product' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => $meta_boxes_fields_default
        );

        return $meta_boxes;

    }

	public function firman_product_card_meta_accessories( $meta_boxes ) {
		$prefix = $this->get_card_prefix();

		$post_id = $this->get_post_id();

		$post_title         = get_the_title( $post_id );
		$post_title_split   = explode( ' ', $post_title );

		$model =  ( ! empty( $post_title_split ) ) ? array_pop($post_title_split) : '';

		if( $post_title_split[0] == 'AUTO-DRAFT'){
			$model = '';
		}

		//set meta box fields default
		$meta_boxes_fields_default = array(
			array(
				'id'   => $prefix . 'activate',
				'name' => esc_html__( 'Enable Card Details', 'firman' ),
				'type' => 'checkbox',
				'desc' => esc_html__( '', 'firman' ),
				'std'  => true
			),
			array(
				'id'          => $prefix . 'model',
				'type'        => 'text',
				'name'        => esc_html__( 'Model', 'firman' ),
				'placeholder' => esc_html__( 'model number', 'firman' ),
				'std'         => $model,

			),
			array(
				'id'          => $prefix . 'product_type',
				'type'        => 'text',
				'name'        => esc_html__( 'Product Type', 'firman' ),
				'placeholder' => esc_html__( 'product type', 'firman' ),
				'std'         => '',
			),
			array(
				'id'          => $prefix . 'title_accessory',
				'type'        => 'text',
				'name'        => esc_html__( 'Custom Title', 'firman' ),
				'placeholder' => esc_html__( 'custom title', 'firman' ),
				'std'         => trim( $post_title ),
			),
			array(
				'id'   => $prefix . 'summary',
				'name' => esc_html__( 'Summary', 'firman' ),
				'type' => 'wysiwyg',
				'desc' => esc_html__( 'Card short description', 'firman' ),
			),

		);

		$meta_boxes[] = array(
			'id'         => 'product_card',
			'title'      => esc_html__( 'Product Card Details', 'firman' ),
			'post_types' => array( 'product' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'autosave'   => true,
			'fields'     => $meta_boxes_fields_default
		);

		return $meta_boxes;
    }

	public function firman_after_save_fields( $null, $field, $new, $old, $post_id ) {
		$pre     = '';
		$storage = $field['storage'];
		$product = wc_get_product( $post_id );
		$product_cat_accessories = has_term( 'parts-accessories', 'product_cat', $post_id );

		if ( empty( $new ) && $field['id'] == 'card_summary' ) {
			if( ! $product_cat_accessories ){
				$product_attributes = $this->firman_card_get_attributes_value( $product );
				$storage->update( $post_id, $field['id'], $product_attributes );
            }
		}
		if ( empty( $new ) && $field['id'] == 'card_title' ) {
			if( ! $product_cat_accessories ){
                $post_title       = get_the_title( $post_id );
                $post_title_split = explode( ' ', $post_title );
                $post_title       = ( ! empty( $post_title_split ) ) ? $post_title_split[1] . ' Watt Generator' : '';
                $storage->update( $post_id, $field['id'], $post_title );
			}

		}

	}

	/**
	 * Get product attributes label and value
	 *
	 * @param object $product
	 *
	 * @return string
	 */
	private function firman_card_get_attributes_value( $product ) {

		$attributes = $product->get_attributes();
		$product_id = $product->get_id();

		ob_start();

		foreach ( $attributes as $attribute ):

			$attribute_label = wc_attribute_label( $attribute->get_name() );
			$attribute_class = ( $attribute_label == "Certification" ) ? "hide" : "";

			echo '<tr class="' . $attribute_class . '">';

			echo '<td>' . $attribute_label . ': </td>'; ?>
			<?php
			$values = array();

			if ( $attribute->is_taxonomy() ) {
				$attribute_taxonomy = $attribute->get_taxonomy_object();
				$attribute_values   = wc_get_product_terms( $product_id, $attribute->get_name(), array( 'fields' => 'all' ) );

				foreach ( $attribute_values as $attribute_value ) {
					$value_name = esc_html( $attribute_value->name );

					if ( $attribute_taxonomy->attribute_public ) {
						$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
					} else {

						$values[] = $value_name;
					}
				}
			} else {
				$values = $attribute->get_options();

				foreach ( $values as &$value ) {
					$value = make_clickable( esc_html( $value ) );
				}
			}

			echo '<td>' . apply_filters( 'woocommerce_meta_attribute', wptexturize( implode( ', ', $values ) ), $attribute, $values ) . '</td>'; ?>
            </tr>
		<?php endforeach;

		$cert_title  = '<p class="cert">Certifications</p>';
;
        $cert_images = self::get_certification_img( $product_id );

		return '<div class="attributes"><table>' . ob_get_clean() . '</table>' . $cert_title . $cert_images . '</div>';

	}

	/**
	 * Get certification attributes and return as html
	 *
	 * @param int $product_id
	 *
	 * @return string
	 */
	public static function get_certification_img( $product_id ) {

		$attribute_values = wc_get_product_terms( $product_id, 'pa_certification', array( 'fields' => 'all' ) );
		$certfications = '';
		$cert_images = '';

		if ( ! empty( $attribute_values ) ) {

			$images_dir    = get_stylesheet_directory_uri() . '/images/';

			foreach ( $attribute_values as $attribute_value ) {
				$value_name = esc_html( $attribute_value->name );

				$certfications .= '<li> <img src=" ' . $images_dir . $value_name . '.png" /></li>';

			}
			$cert_images = '<ul class="cert-image">' . $certfications . '</ul>';
		}

		return $cert_images;

	}
}

new Firman_Product_Card_Meta();