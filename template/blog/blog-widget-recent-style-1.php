<?php
/**
 * Blog Widget Recent Style 1
 *
 * @since MX 1.0
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
						<span class="entry-date"><a href="'.esc_url( get_permalink() ).'"><i class="fa fa-clock-o"></i>'.esc_html( get_the_date() ).'</a></span>';

if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
	$num_comments = get_comments_number(get_the_ID());
	$output .= '<span class="comments-link"><a href="'.esc_url(get_permalink()).'#comments"><i class="fa fa-comments-o"></i>';
	if(intval($num_comments) == 0){
		$output .= '0';
	}else if(intval($num_comments) == 1){
		$output .= '1';
	}else{
		$output .= esc_attr($num_comments);
	}
	$output .= '</a></span>';
}
$output .= '		</div>
				</div>
			</div>';
$posts_recent_post_content = $output;
?>
