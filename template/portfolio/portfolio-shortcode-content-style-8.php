<?php
/**
 * Portfolio Shortcode Content Style 8
 *
 * @since MX 2.0
 */
global $portfolio_shortcode_content, $portfolio_shortcode_thumbnail_size;
$output = '';

// get portfolio item type
$portfolio_type = mx_get_post_meta_key( 'post-foramt', $post->ID);
$icon = 'fa-picture-o';
switch(intval($portfolio_type)){
	case 2: $icon = 'fa-film'; break;
	case 1: $icon = 'fa-th-large'; break;
}
	
if(has_post_thumbnail(get_the_ID())) {
	$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
$output .= '<a href="'.esc_url(get_permalink()).'"><div class="post-img">
				'.get_the_post_thumbnail(get_the_ID(), $portfolio_shortcode_thumbnail_size , array('alt' => get_the_title(),'title' => '')).'
				<div class="post-tip">
            		<div class="bg"></div>
					<span class="pop-link-icon center"><i class="fa '.$icon.'"></i></span>
				</div>
			</div></a>';
}

$output .= '<div class="post-content">
				<h5 class="entry-title" itemprop="name"><a href="'.esc_url(get_permalink()).'" itemprop="url">'.get_the_title().'</a></h5>
				<span class="sidebar-viewlike"><i class=" fa fa-eye"></i>'.penguin_get_post_meta_count(get_the_ID()).'</span><span class="sidebar-viewlike"><i class=" fa fa-heart"></i>'.penguin_get_post_meta_count(get_the_ID(),1,false).'</span>
			</div>';

$portfolio_shortcode_content = $output;
?>
