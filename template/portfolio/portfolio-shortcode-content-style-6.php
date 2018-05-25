<?php
/**
 * Portfolio Shortcode Content Style 6
 *
 * @since MX 1.0
 */
global $portfolio_shortcode_content, $portfolio_shortcode_thumbnail_size;
$output = '';

$output .= '<div class="portfolio-element-container">';
if(has_post_thumbnail(get_the_ID())) {
$output .= '<a href="'.esc_url(get_permalink()).'"><div class="post-img">
				'.get_the_post_thumbnail(get_the_ID(), $portfolio_shortcode_thumbnail_size , array('alt' => get_the_title(),'title' => '')).'
				<div class="post-mask-content">
					<div class="centered">
						<h5 class="entry-title" itemprop="name">'.get_the_title().'</h5>';
						$client = mx_get_post_meta_key('portfolio-client', $post->ID); 
						if($client != ""){
							$output .= '<span class="portfolio-client"><strong>'.__('Client: ','MX').'</strong>'.$client.'</span>';
						}
						$skills = get_post_meta('portfolio-skills', $post->ID); 
						if($skills != ""){
							$output .= '<span class="portfolio-skills"><strong>'.__('Skills: ','MX').'</strong>'.$skills.'</span>';
						}
$output .= '		</div>
            	</div>
        	</div></a>';
}else{
	$output .= '<h5 class="entry-title" itemprop="name"><a href="'.esc_url(get_permalink()).'" itemprop="url">'.get_the_title().'</a></h5>';
}
$output .= '</div>';

$portfolio_shortcode_content = $output;
?>
