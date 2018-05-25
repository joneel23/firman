<?php
/**
 * Portfolio Widget Recent Style 1
 *
 * @since MX 1.0
 */
global $portfolio_recent_post_content;
$output = '';

// get portfolio item type
$portfolio_type = mx_get_post_meta_key( 'post-foramt',$post->ID );
$icon = 'fa-picture-o';
switch(intval($portfolio_type)){
	case 2: $icon = 'fa-film'; break;
	case 1: $icon = 'fa-th-large'; break;
}
$output .= '<div class="sidebar-portfolio-recent icon-style">
				<div class="post-type"><i class="fa '.esc_attr($icon).'"></i></div>
				<div class="post-content">
					<h5 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h5>
					<div class="portfolio-categories">'.mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false) , ' / ').'</div>
				</div>
			</div>';



$portfolio_recent_post_content = $output;
?>
