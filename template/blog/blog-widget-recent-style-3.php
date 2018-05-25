<?php
/**
 * Portfolio Widget Recent Style 3
 *
 * @since MX 1.0
 */
global $posts_recent_post_content;
$output = '';
$thumbnail_size = 'mx-s-thumbs';

$icon = 'fa-file';
switch(get_post_format()){
	case 'video': $icon = 'fa-film'; break;
	case 'audio': $icon = 'fa-music'; break;
	case 'image': $icon = 'fa-picture-o'; break;
	case 'gallery': $icon = 'fa-th-large'; break;
	case 'quote': $icon = 'fa-quote-left'; break;
}
$output .= '<div class="sidebar-blog-recent big-thumbs-style">';

if(has_post_thumbnail(get_the_ID())) {
	$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
$output .= '<a href="'.esc_url(get_permalink()).'"><div class="post-img">
				'.get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')).'
				<div class="post-tip">
            		<div class="bg"></div>
					<span class="pop-link-icon center"><i class="fa '.$icon.'"></i></span>
				</div>
			</div></a>';
}
$output .= '<div class="post-content">
				<h5 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h5>
			</div>';
$output .= '</div>';

$posts_recent_post_content = $output;
?>
