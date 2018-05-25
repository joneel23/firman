<?php
/**
 * Portfolio Widget Recent Style 4
 *
 * @since MX 2.0
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
					<div class="entry-meta">
						<span class="sidebar-viewlike"><i class=" fa fa-eye"></i>'.penguin_get_post_meta_count(get_the_ID()).__(' Views','MX').'</span>
						<span class="sidebar-viewlike"><i class=" fa fa-heart"></i>'.penguin_get_post_meta_count(get_the_ID(),1,false).__(' Likes','MX').'</span>';

$output .= '		</div>
				</div>
			</div>';



$portfolio_recent_post_content = $output;
?>
