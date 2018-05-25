<?php
/**
 * Portfolio Item Content Style 4
 *
 * @since MX 1.0
 */
 global $portfolio_show_columns, $thumbnail_size;
 
 // get portfolio item type
	$portfolio_type = mx_get_post_meta_key('post-foramt', $post->ID);
	$icon = 'fa-picture-o';
	switch(intval($portfolio_type)){
		case 2: $icon = 'fa-film'; break;
		case 1: $icon = 'fa-th-large'; break;
	}
 ?>
 	<?php if(has_post_thumbnail(get_the_ID())) { ?>
    <a href="<?php echo esc_url(get_permalink()); ?>">
	<div class="post-img">
    	
		<?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')); ?>
        
        <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
        <div class="post-tip">
            <div class="bg"></div>
            <span class="pop-link-icon center"><i class="fa <?php echo $icon; ?>"></i></span>
        </div>
	</div>
    </a>
    <?php } ?>
    <div class="post-content">
        <?php if(intval($portfolio_show_columns) == 2) { ?>
        <h5 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h5>
        <?php }else{ ?>
        <h4 class="entry-title" itemprop="name"><a href="<?php echo esc_url(get_permalink()); ?>" itemprop="url"><?php the_title(); ?></a></h4>
        <?php } ?>
    </div>
</article>