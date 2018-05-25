<?php
/**
 * Portfolio Shortcode Content Style 3
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
						<div class="portfolio-categories"><span itemprop="genre">'.mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false) , ' / ').'</span></div>
						<h4 class="entry-title" itemprop="name"><a href="'.esc_url(get_permalink()).'" itemprop="url">'.get_the_title().'</a></h4>
						<span class="entry-date updated" itemprop="datePublished">'.get_the_date().'</span>
					</div>
				</div>
			</div>';
}else{
	$output .= '<h5 class="entry-title" itemprop="name"><a href="'.esc_url(get_permalink()).'" itemprop="url">'.get_the_title().'</a></h5>';
}

$portfolio_shortcode_content = $output;
?>
