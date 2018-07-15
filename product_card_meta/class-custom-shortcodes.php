<?php

/**
 * Created by BlueFoxMedia.
 * User: BlueFoxDev
 * Date: 5/16/2018
 * Time: 8:42 PM
 */

class Firman_Custom_Shortcodes {

	public function __construct() {

		add_shortcode( 'firman_social_links', array( $this, 'create_shortcode_social_links' ) );
        add_shortcode( 'firman_pdf_download', array( $this, 'create_shortcode_download_pdf' ) );
		add_shortcode( 'firman_pdf_download_ftp', array( $this, 'create_shortcode_download_pdf_ftp' ) );

	}

	public function create_shortcode_social_links( $atts ) {

		$html = '<div class="mx-header-center row">';
		$html .= '<div class="col-md-12 col-sm-12"> ';
		$html .= '<ul class="mx-social social-circle inline"> ';
		$html .= mx_get_social_list();
		$html .= '</ul> ';
		$html .= '</div> ';
		$html .= '</div>';

		return $html;

	}

	public function create_shortcode_download_pdf( $atts ){

	    //set default value
		$pdf_atts = shortcode_atts (
			array(
				'file_name' => '',
                'title' => '',
                'language' => 'English, Spanish, Français',
			), $atts
		);
		$file_name = $pdf_atts['file_name'];

		if ( empty( $file_name ) ) {
			return '';
		}

		if( preg_match('/,/', $pdf_atts['language'] ) ){
			$language = preg_replace( '/,/', ' • ', trim( $pdf_atts['language'] ) );
		} else $language = $pdf_atts['language'];

		ob_start();

		$pdf = array();

		$query_attachment = Firman_Product_Card_Helper::get_attachment_pdf_file( $file_name );


		foreach ( $query_attachment as $attachment ) {

			$pdf_dir_name = explode( '/', $attachment->guid );
			$pdf_dir_name = array_pop( $pdf_dir_name );
			if ( $pdf_dir_name == trim( $file_name ) . '.pdf' ) {
				$pdf['title'] = $attachment->post_title;
				$pdf['id']    = $attachment->ID;
			}
		}

		if ( empty( $pdf ) ) {
			echo '<div class="download-pdf"><p> No attachment found: ' . $file_name . '</p></div>';
		} else {
			$pdf_size  = size_format( filesize( get_attached_file( $pdf['id'] ) ) );
			$pdf_link  = wp_get_attachment_url( (int) $pdf['id'] );
			$pdf_title = ( empty( $pdf_atts['title'] ) ) ? $pdf['title'] : $pdf_atts['title'];
			$images_dir    = get_stylesheet_directory_uri() . '/images/';

			echo '<div class="download-pdf"><a href="' . $pdf_link . ' " target="_blank" rel="noopener"><span class="pdf-img"><img class="alignnone size-full wp-image-1342" src="'.$images_dir.'pdf-img.jpg" alt="" width="124" height="152" /></span> <span class="pdf-title">' . $pdf_title . '</span><span class="pdf-desc">Available in ' . $language . ' •</span><span class="pdf-size"> ' . $pdf_size . '</span>
	</a></div>';
		}

		return ob_get_clean();
	}

	public function create_shortcode_download_pdf_ftp( $atts ){

		//set default value
		$pdf_atts = shortcode_atts (
			array(
				'file_name' => '',
				'title' => '',
				'language' => 'English, Spanish, Français',
			), $atts
		);
		$file_name = $pdf_atts['file_name'];

		if ( empty( $file_name ) ) {
			return '';
		}

		if( preg_match('/,/', $pdf_atts['language'] ) ){
			$language = preg_replace( '/,/', ' • ', trim( $pdf_atts['language'] ) );
		} else $language = $pdf_atts['language'];

		ob_start();

		$pdf = array();

		$pdf_title = $pdf_atts['file_name'];
		$ftp_url = '/wp-content/uploads/pdf/';
		$pdf['title'] =   $ftp_url . $pdf_title . '.pdf';

		if ( empty( $pdf ) ) {
			echo '<div class="download-pdf"><p> No attachment found: ' . $file_name . '</p></div>';
		} else {
			$pdf_link  = $pdf['title'];
			$pdf_size  = size_format( filesize( wp_get_upload_dir()['basedir']. '/pdf/' . $pdf_title . '.pdf') );

			$pdf_title = ( empty( $pdf_atts['title'] ) ) ? $pdf['title'] : $pdf_atts['title'];
			$images_dir    = get_stylesheet_directory_uri() . '/images/';

			echo '<div class="download-pdf"><a href="' . $pdf_link . ' " target="_blank" rel="noopener"><span class="pdf-img"><img class="alignnone size-full wp-image-1342" src="'.$images_dir.'pdf-img.jpg" alt="" width="124" height="152" /></span> <span class="pdf-title">' . $pdf_title . '</span><span class="pdf-desc">Available in ' . $language . ' •</span><span class="pdf-size"> ' . $pdf_size . '</span>
	</a></div>';
		}



		return ob_get_clean();
	}

}

new Firman_Custom_Shortcodes();


