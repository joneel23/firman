<?php
/**
 * Portfolio Single Page Style 1
 *
 * @since MX 1.0
 */
?>
<div class="single-portfolio-style-1">
	<?php 
    if (have_posts() ) {
        // Start the Loop.
        while ( have_posts() ) { 
            the_post();
            $portfolio_type = get_post_meta(get_the_ID(), 'post-foramt', true);
			// get image need crop
			$page_image_no_crop = get_post_meta(get_the_ID(), 'page-image-no-crop', true);
			$thumbnail_size =  'mx-nocrop-thumbs';
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('post-entry'); ?> itemscope itemtype="http://schema.org/CreativeWork">
            <section class="post-content col-md-8 col-sm-7">
                <div class="post-element-content">
                <?php 
                if(intval($portfolio_type) == 0){
					if(has_post_thumbnail(get_the_ID())) {
                    $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                ?>
                	<a href="<?php echo esc_url($full_image[0]); ?>" class="fancyBox">
                    <div class="post-img">
                        <?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')); ?>
                        <div class="post-tip">
                            <div class="bg"></div>
                            <span class="pop-preview-icon center"><i class="fa fa-search-plus"></i></span>
                        </div>
                    </div>
                    </a>
                <?php }
				}else if(intval($portfolio_type) == 1){ 
					$gallery_images = get_post_meta(get_the_ID(), 'gallery-images', true);
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
                                <a href="<?php echo  esc_url($full_image[0]); ?>" class="fancybox-thumb" rel="fancybox-thumb[portfolio-single-s1-<?php echo  esc_attr(get_the_ID()); ?>]"><img src="<?php echo  esc_url($attachment_image[0]); ?>" alt=""></a>
                            </li>
                        <?php }?>
                        </ul>
                    </div>
                <?php }else if(intval($portfolio_type) == 2){ 
					$video_type 	= get_post_meta(get_the_ID(), 'video-type', true);
            		$video_content 	= get_post_meta(get_the_ID(), 'video-content', true);
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
                </div>
                <div class="entry-content" itemprop="text">
                	<?php edit_post_link('<i class="fa fa-edit"></i>'.__('Edit', 'MX'), '<div class="post-edit">', '</div>'); ?>
                    <?php the_content(); ?>
                    <?php wp_link_pages(); ?>
                </div>
            </section>
            <aside class="col-md-4 col-sm-5">
                <div class="post-details">
                    <h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
                    <ul class="single-portfolio-metas inline">
                        <li>
                            <div class="type"><i class="fa fa-clock-o"></i><span class="entry-date updated" itemprop="datePublished"><?php _e('Date','MX'); ?></span></div>
                            <div class="value"><?php echo get_the_date('d-M-Y'); ?></div>
                        </li>
                        <li>
                            <div class="type"><i class="fa fa-briefcase"></i><?php _e('Categories','MX'); ?></div>
                            <div class="value"><span itemprop="genre"><?php echo mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false)  , ' / '); ?></span></div>
                        </li>
                        <?php 
						if(mx_get_custom_post_categories(get_the_ID(),'portfolio-tags',false) != "" && count(mx_get_custom_post_categories(get_the_ID(),'portfolio-tags',false)) > 0){ ?>
                        <li>
                            <div class="type"><i class="fa fa-tags"></i><?php _e('Tags','MX'); ?></div>
                            <div class="value"><span itemprop="keywords"><?php echo mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-tags',false)  , ' , ', 'portfolio-tags', __('No Tags','MX')); ?></span></div>
                        </li>
                        <?php } ?>
                        <?php 
						$client = get_post_meta($post->ID, 'portfolio-client', true); 
						if($client != ""){
						?>
                         <li>
                            <div class="type"><i class="fa fa-user"></i><?php _e('Client','MX'); ?></div>
                            <div class="value"><?php echo $client; ?></div>
                        </li>
                        <?php } ?>
                        <?php 
						$skills = get_post_meta($post->ID, 'portfolio-skills', true); 
						if($skills != ""){
						?>
                         <li>
                            <div class="type"><i class="fa fa-plus-square"></i><?php _e('Skills','MX'); ?></div>
                            <div class="value"><?php echo $skills; ?></div>
                        </li>
                        <?php } ?>
                        <?php mx_get_portfolio_custom_fields(get_post_meta($post->ID, 'portfolio-custom-fields', true)); ?>
                    </ul>
                    
                    <?php if(mx_get_options_key('portfolio-viewlike-enable') == 'on'){ ?>
                    <div class="viewandlike-count">
                        <div class="likecountbox">
                            <?php $rate_link = penguin_get_post_like_link(get_the_ID());
                                if($rate_link != ""){
                                    echo '<a data-post_id="'.get_the_ID().'" href="#"><span><i class=" fa fa-heart"></i></span></a>';
                                }else{
                                    echo '<span><i class=" fa fa-heart"></i></span>';
                                }
                                echo '<span class="count">'.penguin_get_post_meta_count(get_the_ID(),1,false).'</span>';
                                echo __(' Likes','MX');
                            ?> 
                        </div>
                        <div class="viewcountbox"><span><i class=" fa fa-eye"></i></span><?php 
                            echo penguin_get_post_meta_count(get_the_ID());
                            echo __(' Views','MX');
                            // add view count
                            penguin_set_post_view(get_the_ID());
                         ?></div>
                    </div>
                    <?php } ?>
                        
                    <?php if(mx_get_options_key('portfolio-share-enable') == "on"){ ?> 
						<div class="post-share">
						<?php if(intval(mx_get_options_key('portfolio-share-type')) == 0) { 
							echo do_shortcode('[share link="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'"]');
                        } else { ?>
                        <?php echo mx_get_options_key('portfolio-share-content'); ?>
                        <?php } ?>
                        </div>
                    <?php } ?>
                    
                    <?php 
                        $download = get_post_meta($post->ID, 'portfolio-download', true);
                        if($download != ""){ 
                    ?>
                    <div class="post-download">
                        <a class="btn btn-theme btn-shadow" href="<?php echo $download; ?>"><i class="fa fa-download"></i><?php _e('Download','MX'); ?></a>
                    </div>
                    <?php } ?>
                </div>
            </aside>
        </article>
    <?php }
    } 
    ?>
    <?php mx_single_content_nav_follow('single-post-bottom'); ?>
    <?php if(mx_get_options_key('portfolio-related-enable') == "on"){ ?>
    <div class="mx-title col-md-12 col-sm-12">
        <h4 class="post-title"><?php _e('You may also like', 'MX'); ?></h4>
        <div class="line"><span class="left-line"></span><span class="right-line"></span></div>
        <div class="clear"></div>
    </div>
    <div class="col-md-12 col-sm-12">
    <?php
	$cat_slugs = mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',true,",",'slug');
	if($cat_slugs != ""){
		$style = mx_get_options_key('portfolio-related-style');
		$post_style = mx_get_post_meta_key('related-style');
		if(intval($post_style) != 0){
			$style = intval($post_style);
		}else{
			$style = intval($style) + 1;
		}
		echo do_shortcode('[portfolio_list number="4" style="'.esc_attr($style).'" columns="4" type="related" orderby="rand" cat_slug_in="'.esc_attr($cat_slugs).'" post__not_in="'.esc_attr(get_the_ID()).'" effect="fadeInUp" nocrop="off"]');
	}
	
	?>
    </div>
    <?php } ?>
</div>