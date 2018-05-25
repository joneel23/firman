<?php
/**
 * Portfolio Item Content Style 2
 *
 * @since MX 1.0
 */
 	global $portfolio_show_columns, $thumbnail_size;
	
	// get portfolio item type
	$portfolio_type = get_post_meta($post->ID, 'post-foramt', true); 	
?>
<div class="portfolio-element-container">
<?php
	if(intval($portfolio_type) == 0){
?>
	<div class="post-img">
    	<a href="<?php echo esc_url(get_permalink()); ?>">
		<?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')); ?>
        </a>
        <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
        <div class="post-tip">
            <div class="bg"></div>
            <a href="<?php echo  esc_url(get_permalink()); ?>"><span class="pop-link-icon"><i class="fa fa-chain"></i></span></a>
            <a class="fancyBox" href="<?php echo  esc_url($full_image[0]); ?>"><span class="pop-preview-icon"><i class="fa fa-search-plus"></i></span></a>
        </div>
	</div>
<?php }else if(intval($portfolio_type) == 1){ ?>
	<?php 
	// get post gallery list
	$gallery_images = mx_get_post_meta_key('gallery-images');
	$img_list = mx_get_post_gallery_ids($gallery_images);
	?>
	<div class="flexslider mx-fl post-gallery">
		<ul class="slides">
		<?php 
			foreach($img_list as $item_id){
				$attachment_image = wp_get_attachment_image_src($item_id, $thumbnail_size); 
				$full_image = wp_get_attachment_image_src($item_id, 'full'); 
		?>
			<li>
				<a href="<?php echo  esc_url($full_image[0]); ?>" class="fancybox-thumb" rel="fancybox-thumb[portfolio-c2-<?php echo  esc_attr(get_the_ID()); ?>]"><img src="<?php echo  esc_url($attachment_image[0]); ?>" alt=""></a>
			</li>
		<?php }?>
		</ul>
	</div>
<?php }else if(intval($portfolio_type) == 2){ ?>
	<?php 
	// get video conent type
	$video_type 	= mx_get_post_meta_key('video-type');
	// get custom video type content
	$video_content 	= mx_get_post_meta_key('video-content');
	?>
	<div class="post-video">
	<?php
		if(intval($video_type) == 0){
			echo do_shortcode('[youtube id="'.$video_content.'" width="100%" height="300"]');
		}else if(intval($video_type) == 1){
			echo do_shortcode('[vimeo id="'.$video_content.'" width="100%" height="300"]');
		}else{
		   echo $video_content;
		}
	?>
	</div>
<?php } ?>
    <div class="post-content">
    	<?php if(intval($portfolio_show_columns) == 2) { ?>
        <h5 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h5>
        <?php }else{ ?>
        <h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
        <?php } ?>
        <div class="portfolio-categories"><span itemprop="genre"><?php echo mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false) , ' / '); ?></span></div>
    </div>
</div>
</article>