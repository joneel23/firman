<?php

/**
 * Created by BlueFoxMedia.
 * User: BlueFoxDev
 * Date: 5/24/2018
 * Time: 6:22 AM
 */
if( ! defined( 'ABSPATH') ) exit; //Prevent direct access

class Firman_Product_Model_Auto_Option {
	/*
	 * Set attributes
	 * */
	private $set_product_accesories;

	private $set_product_generator;

	private function get_product_accessories(){
		$this->set_product_accesories = $this->get_product_ids_by_cat( array(
			'parts-accessories'
		) );

		return $this->set_product_accesories;
	}
	private function get_product_generator(){
		$this->set_product_generator = $this->get_product_ids_by_cat( array(
			'performance-series',
			'hybrid-series',
			'whisper-series'
		) );

		return $this->set_product_generator;
	}

	public function __construct() {

		add_action( 'wpcf7_init', array( $this, 'init_model_data' ) );

		add_action( 'wpcf7_init', array( $this, 'firman_wpcf7_add_select_model' ) );

		add_action( 'transition_post_status', array( $this, 'change_product_status' ), 20, 3 );

	}

	public function init_model_data(){

		$get_model_data = get_option( 'firman_product_model' );

		if ( $get_model_data === false ) {
			$model_data     = $this->store_default_model_id_option();
			// The option doesn't exists, so we add the data
			update_option( 'firman_product_model', $model_data, true );

		}

//		delete_option('firman_product_model' );

	}

	private function reset_model_cache_data(){
		$model_cache_data = get_transient( 'firman_product_model_data' );
		if ( $model_cache_data === false ) {
			$model_data = get_option( 'firman_product_model', true );
			$this->set_model_cache_data( $model_data );
		}

	}

	private function set_model_cache_data($model_data){
		set_transient('firman_product_model_data', $model_data, 60*60*12 );
	}

	public function firman_wpcf7_add_select_model() {
		wpcf7_add_form_tag( array( 'select_model', 'select_model*' ), array(
			$this,
			'firman_get_product_model_id'
		), array( 'name-attr' => true, 'selectable-values' => true, ) );
	}

	public function firman_get_product_model_id($tag ){

		if ( empty( $tag->name ) ) {
			return '';
		}

		$validation_error = wpcf7_get_validation_error( $tag->name );

		$class = wpcf7_form_controls_class( $tag->type );

		if ( $validation_error ) {
			$class .= ' wpcf7-not-valid';
		}

		$atts = array();

		$atts['class'] = $tag->get_class_option( $class );
		$atts['id'] = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

		if ( $tag->is_required() ) {
			$atts['aria-required'] = 'true';
		}

		$atts['aria-invalid'] = $validation_error ? 'true' : 'false';

		$multiple = $tag->has_option( 'multiple' );
		$include_blank = $tag->has_option( 'include_blank' );
		$first_as_label = $tag->has_option( 'first_as_label' );

		if ( $tag->has_option( 'size' ) ) {
			$size = $tag->get_option( 'size', 'int', true );

			if ( $size ) {
				$atts['size'] = $size;
			} elseif ( $multiple ) {
				$atts['size'] = 4;
			} else {
				$atts['size'] = 1;
			}
		}

		$values = $tag->values;
		$labels = $tag->labels;

		if ( $data = (array) $tag->get_data_option() ) {
			$values = array_merge( $values, array_values( $data ) );
			$labels = array_merge( $labels, array_values( $data ) );
		}

		$defaults = array();

		$default_choice = $tag->get_default_option( null, 'multiple=1' );

		foreach ( $default_choice as $value ) {
			$key = array_search( $value, $values, true );

			if ( false !== $key ) {
				$defaults[] = (int) $key + 1;
			}
		}

		if ( $matches = $tag->get_first_match_option( '/^default:([0-9_]+)$/' ) ) {
			$defaults = array_merge( $defaults, explode( '_', $matches[1] ) );
		}

		$defaults = array_unique( $defaults );

		$shifted = false;

		if ( $include_blank || empty( $values ) ) {
			array_unshift( $labels, '---' );
			array_unshift( $values, '' );
			$shifted = true;
		} elseif ( $first_as_label ) {
			$values[0] = '';
		}

		$html = '<option value="Model">Model</option>';

		$hangover = wpcf7_get_hangover( $tag->name );

//		$get_model_cache_data = get_transient( 'firman_product_model_data' );
//		var_dump($get_model_cache_data);
//		if($get_model_cache_data !== false){
//			var_dump($get_model_cache_data);
//		}

		$get_model_data = get_option( 'firman_product_model' );

		//generate custom options by model and page id
		if ( $get_model_data !== false ) {
			$model_option_data = $this->create_html_model_id_by_option( $get_model_data );

			$html .= $model_option_data;
		}

		foreach ( $values as $key => $value ) {
			$selected = false;

			if ( $hangover ) {
				if ( $multiple ) {
					$selected = in_array( $value, (array) $hangover, true );
				} else {
					$selected = ( $hangover === $value );
				}
			} else {
				if ( ! $shifted && in_array( (int) $key + 1, (array) $defaults ) ) {
					$selected = true;
				} elseif ( $shifted && in_array( (int) $key, (array) $defaults ) ) {
					$selected = true;
				}
			}

			$item_atts = array(
				'value' => $value,
				'selected' => $selected ? 'selected' : '',
			);

			$item_atts = wpcf7_format_atts( $item_atts );

			$label = isset( $labels[$key] ) ? $labels[$key] : $value;

			$html .= sprintf( '<option %1$s>%2$s</option>',
				$item_atts, esc_html( $label ) );
		}

		if ( $multiple ) {
			$atts['multiple'] = 'multiple';
		}

		$atts['name'] = $tag->name . ( $multiple ? '[]' : '' );

		$atts = wpcf7_format_atts( $atts );

		$html = sprintf(
			'<span class="wpcf7-form-control-wrap %1$s"><select %2$s>%3$s</select>%4$s</span>',
			sanitize_html_class( $tag->name ), $atts, $html, $validation_error );

		return $html;
	}

	public function change_product_status($new_status, $old_status, $post){

		if ( $post->post_type === 'product') {
			if ( $new_status === 'trash' ) {
				$this->unset_pid_on_removed_product( $post->ID );
			}

			if ( $new_status === 'publish' ) {
				$this->reset_pid_on_published_product( $post->ID );

			}
			if ( $new_status === 'draft' ) {
				$this->add_new_model_on_insert_product( $post->ID );
			}
			if ( $new_status === 'auto-draft' ) {

				update_post_meta( $post->ID, 'card_model', '' );

			}

		}

	}

	public function add_new_model_on_insert_product( $post_id ) {

		$get_model_data  = get_option( 'firman_product_model', true );

		$check_model_data = in_array( $post_id, array_column( $get_model_data, 'pid' ) );

		if ( ! $check_model_data ) {
			if ( ! empty( $get_model_data ) && ! empty( get_the_title( $post_id ) ) ) {

				$product_cat_accessories = has_term( 'parts-accessories', 'product_cat', $post_id );
				$accessories             = true;
				if ( ! $product_cat_accessories ) {
					$accessories = false;
				}
				$card_model = Firman_Product_Card_Helper::get_product_generator_model( $post_id, $accessories );

				$new_model_data[] = array(
					'pid'   => $post_id,
					'model' => $card_model
				);

				$add_new_model = array_merge( $get_model_data, $new_model_data );

				update_option( 'firman_product_model', $add_new_model, true );

			}
		} else {
			$this->reset_pid_on_published_product( $post_id );
		}


	}

	public function unset_pid_on_removed_product( $post_id ) {

		$get_model_data = get_option( 'firman_product_model' );
		$new_model_data = array();
		if ( ! empty( $get_model_data ) ) {
			foreach ( $get_model_data as $data ) {
				if ( $data['pid'] == $post_id ) {
					$data['pid'] = '';
				}
				$new_model_data[] = $data;
			}

			update_option( 'firman_product_model', $new_model_data, true );
		}
	}

	public function reset_pid_on_published_product( $post_id ) {
		$get_model_data = get_option( 'firman_product_model' );

		$product_cat_accessories = has_term( 'parts-accessories', 'product_cat', $post_id );
		$accessories             = true;
		if ( ! $product_cat_accessories ) {
			$accessories = false;
		}

		$card_model = Firman_Product_Card_Helper::get_product_generator_model( $post_id, $accessories );

		$new_model_data = array();
		if ( ! empty( $get_model_data ) ) {
			foreach ( $get_model_data as $data ) {
				if ( $data['pid'] == $post_id || $data['model'] == $card_model ) {
					$data['pid']   = $post_id;
					$data['model'] = $card_model;
				}
				$new_model_data[] = $data;
			}

			update_option( 'firman_product_model', $new_model_data, true );
		}

	}

	/**
	 * Store model from products
	 *
	 * @return array $data
	 */
	private function store_default_model_id_option() {
		$generator_ids = $this->get_product_generator();
		$accessories_ids = $this->get_product_accessories();


		$data_generator   = array();
		$data_accessories = array();
		if ( ! empty( $generator_ids ) ) {
			foreach ( $generator_ids as $pid ) {
				$card_model = Firman_Product_Card_Helper::get_product_generator_model( $pid, false );

				$data_generator[] = array(
					'pid'   => $pid,
					'model' => $card_model,
				);
			}
		}
		if ( ! empty( $accessories_ids ) ) {
			foreach ( $accessories_ids as $pid ) {
				$card_model = Firman_Product_Card_Helper::get_product_generator_model( $pid, true );

				$data_accessories[] = array(
					'pid'   => $pid,
					'model' => $card_model,
				);
			}
		}
		$data = array_merge( $data_accessories, $data_generator );

		return $data;

	}


	/**
	 * Query products to get gets by category slugs
	 *
	 * @param array $cat_slug category_slug
	 *
	 * @return array ids
	 */
	private function get_product_ids_by_cat( array $cat_slug ) {
		if ( ! is_array( $cat_slug ) ) {
			return array();
		}
		$get_products = wc_get_products(
			array(
				'limit'    => - 1,
				'status'   => 'publish',
				'orderby'  => 'title',
				'order'    => 'ASC',
				'category' => $cat_slug,
				'return'   => 'ids',
			)
		);

		return $get_products;
	}

	private function create_html_model_id_by_option( array $model_data ) {

		if ( ! empty( $model_data ) ) {
			$options = '';
			foreach ( $model_data as $data ) {

				$item_atts = array(
					'value'    => $data['model'],
					'data-pid' => $data['pid'],
					'selected' => '',
				);

				$item_atts = wpcf7_format_atts( $item_atts );

				$label = isset( $data['model'] ) ? $data['model'] : '';

				$options .= sprintf( '<option %1$s>%2$s</option>',
					$item_atts, esc_html( $label ) );

			}

			return $options;

		} else {
			return '';
		}

	}
}

new Firman_Product_Model_Auto_Option();