<?php
/**
 * Portfolio Item Content Style 6
 *
 * @since MX 1.0
 */
 global $portfolio_show_columns, $thumbnail_size;
?>
	<div class="portfolio-element-container">
<?php if(has_post_thumbnail(get_the_ID())) { ?>
		<a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url">
    	<div class="post-img">
            <?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')); ?>
            <div class="post-mask-content">
            	<div class="centered">
                    <h4 class="entry-title" itemprop="name"><?php the_title(); ?></h4>
                    <?php 
					$client = get_post_meta($post->ID, 'portfolio-client', true); 
					if($client != ""){
					?>
					<span class="portfolio-client"><strong><?php _e('Client: ','MX'); ?></strong><?php echo $client; ?></span>
					<?php } ?>
					<?php 
					$skills = get_post_meta($post->ID, 'portfolio-skills', true); 
					if($skills != ""){
					?>
					<span class="portfolio-skills"><strong><?php _e('Skills: ','MX'); ?></strong><?php echo $skills; ?></span>
					<?php } ?>
                 </div>
            </div>
        </div>
        </a>
	<?php }else{ ?>
    	<h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
    <?php } ?>
    </div>
</article>