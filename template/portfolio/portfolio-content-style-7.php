<?php
/**
 * Portfolio Item Content Style 7
 *
 * @since MX 1.0
 */
 
 $thumbnail_size = 'mx-square-thumbs';
 
?>
	<div class="portfolio-element-container">
<?php if(has_post_thumbnail(get_the_ID())) { ?>
    	<div class="post-img">
            <a href="<?php echo esc_url(get_permalink()); ?>">
            <?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')); ?>
            </a>
            <div class="post-mask-content">
            	<div class="centered">
                    <h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
                    <div class="portfolio-categories"><span itemprop="genre"><?php echo mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false) , ' / '); ?></span></div>
                    <?php 
					$client = mx_get_post_meta_key('portfolio-client', $post->ID); 
					if($client != ""){
					?>
					<span class="portfolio-client"><strong><?php _e('Client: ','MX'); ?></strong><?php echo $client; ?></span>
					<?php } ?>
					<?php 
					$skills = mx_get_post_meta_key('portfolio-skills', $post->ID); 
					if($skills != ""){
					?>
					<span class="portfolio-skills"><strong><?php _e('Skills: ','MX'); ?></strong><?php echo $skills; ?></span>
					<?php } ?>
                 </div>
            </div>
        </div>
	<?php }else{ ?>
    	<h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
    <?php } ?>
    </div>
</article>