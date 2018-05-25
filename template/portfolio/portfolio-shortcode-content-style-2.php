<?php
/**
 * Portfolio Shortcode Content Style 2
 *
 * @since MX 1.0
 */
global $portfolio_shortcode_content, $portfolio_shortcode_thumbnail_size;
$output = '';

// get portfolio item type
$portfolio_type = mx_get_post_meta_key( 'post-foramt', $post->ID); 
	
$output .= '<div class="portfolio-element-container">';

if(intval($portfolio_type) == 0){
	$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
	$output .= '<div class="post-img">
					<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail(get_the_ID(), $portfolio_shortcode_thumbnail_size , array('alt' => get_the_title(),'title' => '')).'</a>
					<div class="post-tip">
						<div class="bg"></div>
							<a href="'.esc_url(get_permalink()).'"><span class="pop-link-icon"><i class="fa fa-chain"></i></span></a>
							<a class="fancyBox" href="'.esc_url($full_image[0]).'"><span class="pop-preview-icon"><i class="fa fa-search-plus"></i></span></a>
					</div>
				</div>';
}else if(intval($portfolio_type) == 1){

	// get post gallery list
	$gallery_images = get_post_meta(get_the_ID(), 'gallery-images', true);
	$img_list = mx_get_post_gallery_ids($gallery_images);
$output .= '<div class="flexslider mx-fl post-gallery">
				<ul class="slides">';
	foreach($img_list as $item_id){
		$attachment_image = wp_get_attachment_image_src($item_id, $portfolio_shortcode_thumbnail_size); 
		$full_image = wp_get_attachment_image_src($item_id, 'full'); 
		$output .= '<li><a href="'.esc_url($full_image[0]).'" class="fancybox-thumb" rel="fancybox-thumb[portfolio-code-c2-'.esc_attr(get_the_ID()).']"><img src="'.esc_url($attachment_image[0]).'" alt=""></a></li>';
	}
$output .= '	</ul>
			</div>';
}else if(intval($portfolio_type) == 2){
	// get video conent type
	$video_type 	= get_post_meta(get_the_ID(), 'video-type', true);
	// get custom video type content
	$video_content 	= get_post_meta(get_the_ID(), 'video-content', true);

$output .= '<div class="post-video">';
	if(intval($video_type) == 0){
		$output .= do_shortcode('[youtube id="'.$video_content.'" width="100%" height="300"]');
	}else if(intval($video_type) == 1){
		$output .= do_shortcode('[vimeo id="'.$video_content.'" width="100%" height="300"]');
	}else{
	   $output .= $video_content;
	}
$output .= '</div>';
}

$output .= '<div class="post-content">
				<h5 class="entry-title" itemprop="name"><a href="'.esc_url(get_permalink()).'" itemprop="url">'.get_the_title().'</a></h5>
				<div class="portfolio-categories"><span itemprop="genre">'.mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false) , ' / ').'</span></div>
			</div>
		</div>';

$portfolio_shortcode_content = $output;
?>
