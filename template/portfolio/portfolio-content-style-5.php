<?php
/**
 * Portfolio Item Content Style 5
 *
 * @since MX 1.0
 */
 global $portfolio_show_columns, $thumbnail_size;
    if(has_post_thumbnail(get_the_ID())) { ?>
    	<div class="post-img">
            <a href="<?php echo esc_url(get_permalink()); ?>">
            <?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')); ?>
            </a>
            <div class="post-mask-content">
            	<div class="centered">
                    <h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
                    <div class="portfolio-categories"><span itemprop="genre"><?php echo mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false) , ' / '); ?></span></div>
                    <a class="btn btn-theme" href="<?php echo esc_url(get_permalink()); ?>" ><?php _e('View Details', 'MX'); ?></a>
                 </div>
            </div>
        </div>
	<?php }else{ ?>
    	<h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
    <?php } ?>
</article>