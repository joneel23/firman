<?php
/**
 * Blog Widget Recent Style 5
 *
 * @since MX 2.0
 */
global $posts_recent_post_content;
$output = '';

$thumbnail_size = 'thumbnail';

$icon = 'fa-file';
switch(get_post_format()){
	case 'video': $icon = 'fa-film'; break;
	case 'audio': $icon = 'fa-music'; break;
	case 'image': $icon = 'fa-picture-o'; break;
	case 'gallery': $icon = 'fa-th-large'; break;
	case 'quote': $icon = 'fa-quote-left'; break;
}

$output .= '<div class="sidebar-blog-recent thumbs-style">';

if(has_post_thumbnail(get_the_ID())) { 
$output .= '<aside class="post-thumbs"><a href="'.esc_url(get_permalink()).'"><div class="post-img">
				'.get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')).'
				<div class="post-tip">
            		<div class="bg"></div>
					<span class="pop-link-icon center"><i class="fa '.$icon.'"></i></span>
				</div>
			</div></a></aside>';
}
$output .= '<div class="post-content">
					<h5 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h5>
					<div class="entry-meta">
						<span class="sidebar-viewlike"><i class=" fa fa-eye"></i>'.penguin_get_post_meta_count(get_the_ID()).__(' Views','MX').'</span>
						<span class="sidebar-viewlike"><i class=" fa fa-heart"></i>'.penguin_get_post_meta_count(get_the_ID(),1,false).__(' Likes','MX').'</span>';

$output .= '		</div>
				</div>
			</div>';
			
$posts_recent_post_content = $output;
?>
