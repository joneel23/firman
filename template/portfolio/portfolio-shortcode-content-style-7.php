<?php
/**
 * Portfolio Shortcode Content Style 7
 *
 * @since MX 1.0
 */
global $portfolio_shortcode_content, $portfolio_shortcode_thumbnail_size;

$thumbnail_size = 'mx-square-thumbs';

$output = '';

$output .= '<div class="portfolio-element-container">';
if(has_post_thumbnail(get_the_ID())) {
$output .= '<div class="post-img">
				<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')).'</a>
				<div class="post-mask-content">
					<div class="centered">
						<h5 class="entry-title" itemprop="name"><a href="'.esc_url(get_permalink()).'" itemprop="url">'.get_the_title().'</a></h5>
						<div class="portfolio-categories"><span itemprop="genre">'.mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false) , ' / ').'</span></div>';
						$client = mx_get_post_meta_key('portfolio-client', $post->ID); 
						if($client != ""){
							$output .= '<span class="portfolio-client"><strong>'.__('Client: ','MX').'</strong>'.$client.'</span>';
						}
						$skills = mx_get_post_meta_key('portfolio-skills', $post->ID); 
						if($skills != ""){
							$output .= '<span class="portfolio-skills"><strong>'.__('Skills: ','MX').'</strong>'.$skills.'</span>';
						}
$output .= '		</div>
				</div>
			</div>';
}else{ 
$output .= '<h4 class="entry-title" itemprop="name"><a href="'.esc_url(get_permalink()).'" itemprop="url">'.get_the_title().'</a></h4>';
}
$output .= '</div>';

$portfolio_shortcode_content = $output;
?>
