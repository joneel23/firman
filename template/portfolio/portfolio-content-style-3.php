<?php
/**
 * Portfolio Item Content Style 3
 *
 * @since MX 1.0
 */
 	global $thumbnail_size;
	
	if(has_post_thumbnail(get_the_ID())) { ?>
    	<div class="post-img">
            <a href="<?php echo esc_url(get_permalink()); ?>">
            <?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')); ?>
            </a>
            <div class="post-mask-content">
            	<div class="centered">
                	<div class="portfolio-categories"><span itemprop="genre"><?php echo mx_get_custom_portfolio_category_links( mx_get_custom_post_categories(get_the_ID(),'portfolio-cats',false) , ' / '); ?></span></div>
                    <h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
                    <span class="entry-date updated" itemprop="datePublished"><?php echo get_the_date(); ?></span>
                 </div>
            </div>
        </div>
	<?php }else{ ?>
    	<h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
    <?php } ?>
</article>