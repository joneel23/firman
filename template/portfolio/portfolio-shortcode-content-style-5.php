<?php
/**
 * Portfolio Shortcode Content Style 5
 *
 * @since MX 1.0
 */
global $portfolio_shortcode_content, $portfolio_shortcode_thumbnail_size;
$output = '';

if(has_post_thumbnail(get_the_ID())) {
$output .= '<div class="post-img">
				<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail(get_the_ID(), $portfolio_shortcode_thumbnail_size , array('alt' => get_the_title(),'title' => '')).'</a>
				<div class="post-mask-content">
					<div class="centered">
						<h5 class="entry-title" itemprop="name"><a href="'.esc_url(get_permalink()).'" itemprop="url">'.get_the_title().'</a></h5>
						<div class="portfolio-categories"><span itemprop="genre">'.mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false) , ' / ').'</span></div>
						<a class="btn btn-theme" href="'.esc_url(get_permalink()).'" >'.__('View Details', 'MX').'</a>
					</div>
				</div>
			</div>';
}else{
	$output .= '<h5 class="entry-title" itemprop="name"><a href="'.esc_url(get_permalink()).'" itemprop="url">'.get_the_title().'</a></h5>';
}

$portfolio_shortcode_content = $output;
?>
