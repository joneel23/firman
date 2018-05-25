<?php
/**
 * Blog Shortcode Content Style 1
 *
 * @since MX 1.0
 */
global $blog_shortcode_content, $blog_shortcode_thumbnail_size;

$output = '';


if(get_post_format() == "quote"){
$output .= '<div class="post-element-content">
				<div class="post-quote"><span class="post-quote-icon"><i class="fa fa-quote-right"></i></span>'.get_the_content().'</div>
			</div>';
}else if(get_post_format() == "audio"){
	$audio_type = get_post_meta(get_the_ID(), 'audio-type', true);
	$audio_content = get_post_meta(get_the_ID(), 'audio-content', true);
    if($audio_content && $audio_content != ''){
$output .= '<div class="post-element-content">
				<div class="post-audio">';
           if(intval($audio_type) == 0){
           		$output .= do_shortcode('[soundcloud url="'.$audio_content.'"]');
           }else{
				$output .= $audio_content;
           }
$output .= '	</div>
			</div>';
	} 
}else if(get_post_format() == "video"){
	$video_type = get_post_meta(get_the_ID(), 'video-type', true);
	$video_content = get_post_meta(get_the_ID(), 'video-content', true);
	if($video_content && $video_content != ''){
$output .= '<div class="post-element-content">
				<div class="post-video">';
                if(intval($video_type) == 0){
					$output .= do_shortcode('[youtube id="'.$video_content.'" width="100%" height="300"]');
                }else if(intval($video_type) == 1){
                    $output .= do_shortcode('[vimeo id="'.$video_content.'" width="100%" height="300"]');
                }else{
                	$output .= $video_content;
                }
$output .= '	</div>
			</div>';
      }
}else if(get_post_format() == "image"){
	if(has_post_thumbnail(get_the_ID())) {
		$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
$output .= '<div class="post-element-content">
				<div class="post-img"><a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail(get_the_ID(), $blog_shortcode_thumbnail_size , array('alt' => get_the_title(),'title' => '')).'</a>
					<div class="post-tip">
						<div class="bg"></div>
						<a href="'.esc_url(get_permalink()).'"><span class="pop-link-icon"><i class="fa fa-chain"></i></span></a>
                    	<a class="fancyBox" href="'.esc_url($full_image[0]).'"><span class="pop-preview-icon"><i class="fa fa-search-plus"></i></span></a>
					</div>
				</div>
			</div>';
	}
}else if(get_post_format() == "gallery"){
	$gallery_images = get_post_meta(get_the_ID(), 'gallery-images', true);
	$img_list = mx_get_post_gallery_ids($gallery_images);
	if(count($img_list) > 0){
$output .= '<div class="post-element-content">
				<div class="flexslider mx-fl post-gallery">
					<ul class="slides">';
                    foreach($img_list as $item_id){
                        $attachment_image = wp_get_attachment_image_src($item_id, $blog_shortcode_thumbnail_size); 
                        $full_image = wp_get_attachment_image_src($item_id, 'full'); 
                    	$output .= '<li><a href="'.esc_url($full_image[0]).'" class="fancybox-thumb" rel="fancybox-thumb[post-code-c1-'.get_the_ID().']"><img src="'.esc_url($attachment_image[0]).'" alt=""></a></li>';
                	}
$output .= '		</ul>
				</div>
			</div>';
	}
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
				</header>';
if(get_post_format() != "quote") {

$output .= 	'	<div class="entry-summary" itemprop="articleSection">
					'.get_the_excerpt().'
				</div>';
}
$output .= 	'	<a class="more-link btn btn-border" href="'.esc_url( get_permalink() ).'">'.__('Read More','MX').'</a>
			</section>';

$blog_shortcode_content = $output;
?>
