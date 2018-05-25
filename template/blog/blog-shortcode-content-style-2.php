<?php
/**
 * Blog Shortcode Content Style 2
 *
 * @since MX 1.0
 */
global $blog_shortcode_content, $blog_shortcode_thumbnail_size;

$output = '';

if(has_post_thumbnail(get_the_ID())) { 

$type_icon = "";
switch(get_post_format()){
	case 'video': $type_icon = 'fa-film'; break;
	case 'audio': $type_icon = 'fa-music'; break;
	case 'image': $type_icon = 'fa-picture-o'; break;
	case 'gallery': $type_icon = 'fa-th-large'; break;
	case 'quote': $type_icon = 'fa-quote-left'; break;
	default : $type_icon = 'fa-file';
}
                        
$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 

$output .= '<div class="post-element-content">
				<a href="'.esc_url(get_permalink()).'">
				<div class="post-img">
					'.get_the_post_thumbnail(get_the_ID(), $blog_shortcode_thumbnail_size , array('alt' => get_the_title(),'title' => '')).'
					<div class="post-tip">
						<div class="bg"></div>
						<span class="pop-link-icon center"><i class="fa '.$type_icon.'"></i></span>
					</div>
				</div>
				</a>
			</div>';
}
$output .= '<section class="post-content">
				<header class="entry-header">
					<h5 class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" itemprop="url">'.get_the_title().'</a></h5>
					<div class="entry-meta">
						<span class="entry-date"><a href="'.esc_url( get_permalink() ).'"><time class="entry-date updated" itemprop="datePublished" datetime="'.esc_attr( get_the_date( 'c' ) ).'"><i class="fa fa-clock-o"></i>'.esc_html( get_the_date() ).'</time></a></span>';

if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

$num_comments = get_comments_number(get_the_ID());
$output .= '<span class="comments-link"><a href="'.get_permalink(get_the_ID()).'#comments"><i class="fa fa-comments-o"></i><span itemprop="interactionCount">'.$num_comments.'</span></a></span>';

}
					
$output .= 	'		</div>
				</header>
			</section>';

$blog_shortcode_content = $output;
?>
