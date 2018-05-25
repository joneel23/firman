<?php
/**
 * Portfolio Single Page Style 2
 *
 * @since MX 1.0
 */
global $portfolio_default_page_id;

// get page layout
$layout = mx_get_page_layout();
$layout_class = mx_get_page_layout_class();
$sidebar_name = mx_get_post_meta_key('sidebar-type');
// get blog default sidebar
if($sidebar_name == "Global Sidebar"){
	if(isset($portfolio_default_page_id)){
		$sidebar_name = mx_get_post_meta_key('sidebar-type', $portfolio_default_page_id);
	}
}
?>
<section class="<?php echo $layout == 1 ? 'col-md-12 col-sm-12' : 'mx-col col-lg-9 col-md-8 col-sm-8 single-portfolio-style-2 mx-'.$layout_class; ?>">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('post-entry'); ?> itemscope itemtype="http://schema.org/CreativeWork">
    	<div class="row">
        	<div class="col-md-6 col-sm-6">
            	<div class="post-element-content">
                	<?php if(has_post_thumbnail(get_the_ID())) { 
								// get image need crop
								$page_image_no_crop = get_post_meta(get_the_ID(), 'page-image-no-crop', true);
								$thumbnail_size =  $page_image_no_crop == "on" ? 'mx-nocrop-thumbs' : 'mx-l-thumbs';
					?>
                    <?php  $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
                    <a href="<?php echo esc_url($full_image[0]); ?>" class="fancyBox">
                    <div class="post-img">
                        <?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => '')); ?>
                        <div class="post-tip">
                            <div class="bg"></div>
                            <span class="pop-preview-icon center"><i class="fa fa-search-plus"></i></span>
                        </div>
                    </div>
                    </a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
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
            </div>
        </div>
        <div class="entry-content" itemprop="text">
        	 <div class="mx-title">
                <h4 class="post-title"><?php _e('Portfolio Details', 'MX'); ?></h4>
                <div class="line"><span class="left-line"></span><span class="right-line"></span></div>
                <div class="clear"></div>
            </div>
            <?php edit_post_link('<i class="fa fa-edit"></i>'.__('Edit', 'MX'), '<div class="post-edit">', '</div>'); ?>
			<?php the_content(); ?>
            <?php wp_link_pages(); ?>
        </div>
        <?php mx_single_content_nav_follow('single-post-bottom'); ?>
		<?php if(mx_get_options_key('portfolio-related-enable') == "on"){ ?>
        <div class="mx-title">
            <h4 class="post-title"><?php _e('You may also like', 'MX'); ?></h4>
            <div class="line"><span class="left-line"></span><span class="right-line"></span></div>
            <div class="clear"></div>
        </div>
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
				echo do_shortcode('[portfolio_list number="3" style="'.esc_attr($style).'" columns="3" type="related" orderby="rand" cat_slug_in="'.esc_attr($cat_slugs).'" post__not_in="'.esc_attr(get_the_ID()).'" effect="fadeInUp" nocrop="off"]');
			}
			
			?>
        <?php } ?>
        <?php comments_template(); ?>
    </article>
    <?php endwhile; else: ?>
        <p><?php _e('Sorry, this page does not exist.' , 'MX' ); ?></p>
    <?php endif; ?>
</section>
<?php if($layout != 1) { ?> 
<aside class="mx-col col-lg-3 col-md-4 col-sm-4 mx-<?php echo $layout_class;?>"><?php generated_dynamic_sidebar($sidebar_name); ?></aside>
<?php } ?>