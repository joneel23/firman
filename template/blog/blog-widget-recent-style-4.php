<?php
/**
 * Blog Widget Recent Style 4
 *
 * @since MX 2.0
 */
global $posts_recent_post_content;
$output = '';

// get item type
$icon = 'fa-file';
switch(get_post_format()){
	case 'video': $icon = 'fa-film'; break;
	case 'audio': $icon = 'fa-music'; break;
	case 'image': $icon = 'fa-picture-o'; break;
	case 'gallery': $icon = 'fa-th-large'; break;
	case 'quote': $icon = 'fa-quote-left'; break;
	
}
$output .= '<div class="sidebar-blog-recent icon-style">
				<div class="post-type"><i class="fa '.esc_attr($icon).'"></i></div>
				<div class="post-content">
					<h5 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h5>
					<div class="entry-meta">
						<span class="sidebar-viewlike"><i class=" fa fa-eye"></i>'.penguin_get_post_meta_count(get_the_ID()).__(' Views','MX').'</span>
						<span class="sidebar-viewlike"><i class=" fa fa-heart"></i>'.penguin_get_post_meta_count(get_the_ID(),1,false).__(' Likes','MX').'</span>';

$output .= '		</div>
				</div>
			</div>';
$posts_recent_post_content = $output;
?>
