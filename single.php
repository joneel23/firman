<?php
/**
 * The Template for displaying all single posts
 *
 * @since MX 4.0
 */
get_header();
// get page layout
$layout = mx_get_page_layout(); 
$layout_class = mx_get_page_layout_class();
$sidebar_name = mx_get_post_meta_key('sidebar-type');
// get blog default sidebar
if($sidebar_name == "Global Sidebar"){
	$blog_page_id = get_option('page_for_posts');
	if(intval($blog_page_id) != 0){
		$sidebar_name = mx_get_post_meta_key('sidebar-type', $blog_page_id);
	}
}
?>
<div id="main" class="container">
	<div class="row">
        <section class="<?php echo $layout == 1 ? 'col-md-12 col-sm-12' : 'mx-col col-lg-9 col-md-8 col-sm-8 mx-'.$layout_class; ?>">
		<?php
            if (have_posts() ) {
                // Start the Loop.
                while ( have_posts() ) { the_post();?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-entry'); ?> itemscope itemtype="http://schema.org/Article">
                    <aside class="single-post-date-type">
                        <div class="post-type"><i class="fa <?php 
							switch(get_post_format()){
								case 'video': echo 'fa-film'; break;
								case 'audio': echo 'fa-music'; break;
								case 'image': echo 'fa-picture-o'; break;
								case 'gallery': echo 'fa-th-large'; break;
								case 'quote': echo 'fa-quote-left'; break;
								default : echo 'fa-file';
                            }
						?>"></i></div>
                    </aside>
                    <section class="post-content">
                    	<?php if(get_post_format() == "quote"){ ?>
                        	<div class="post-element-content">
                                <div class="post-quote"><span class="post-quote-icon"><i class="fa fa-quote-right"></i></span><?php echo get_the_content(); ?></div>
                            </div>
                    	<?php }else if(get_post_format() == "audio"){ ?>
                        	<?php
							   $audio_type 		= mx_get_post_meta_key( 'audio-type');
							   $audio_content 	= mx_get_post_meta_key('audio-content');
							   if($audio_content && $audio_content != ''){
							?>
							<div class="post-element-content">
								<div class="post-audio">
								<?php
								   if(intval($audio_type) == 0){
									 echo do_shortcode('[soundcloud url="'.$audio_content.'"]');
								   }else{
									   echo $audio_content;
								   }
								?>
								</div>
							</div>
        					<?php } ?>
                    	<?php }else if(get_post_format() == "video"){ ?>
                        	<?php
								$video_type 	= mx_get_post_meta_key('video-type');
								$video_content 	= mx_get_post_meta_key('video-content');
								if($video_content && $video_content != ''){
							?>
								<div class="post-element-content">
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
								</div>
							<?php
								}
							?>
                    	<?php }else if(get_post_format() == "image"){ ?>
                        	<?php if(has_post_thumbnail(get_the_ID())) { 
							$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
							?>
								<div class="post-element-content">
                                	<a class="fancyBox" href="<?php echo esc_url($full_image[0]); ?>">
									<div class="post-img">
										<?php 
										echo get_the_post_thumbnail(get_the_ID(), "post-thumbnail" , array('alt' => get_the_title(),'title' => ''));
										?>
                                        <div class="post-tip">
                                            <div class="bg"></div>
                                            <span class="pop-preview-icon center"><i class="fa fa-search-plus"></i></span>
                                        </div>
									</div>
                                    </a>
								</div>
							<?php } ?>
                        <?php }else if(get_post_format() == "gallery"){ ?>
							<?php
                                $gallery_images = mx_get_post_meta_key('gallery-images');
                                $img_list = mx_get_post_gallery_ids($gallery_images);
                                if(count($img_list) > 0){
                            ?>
                                <div class="post-element-content">
                                    <div class="flexslider mx-fl post-gallery">
                                        <ul class="slides">
                                        <?php 
                                            foreach($img_list as $item_id){
                                                $attachment_image = wp_get_attachment_image_src($item_id, 'post-thumbnail'); 
                                                $full_image = wp_get_attachment_image_src($item_id, 'full'); 
                                        ?>
                                            <li>
                                                <a href="<?php echo esc_url($full_image[0]); ?>" class="fancybox-thumb" rel="fancybox-thumb[post-single-<?php echo get_the_ID(); ?>]"><img src="<?php echo esc_url($attachment_image[0]); ?>" alt=""></a>
                                            </li>
                                        <?php }?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    	<header class="entry-header">
                        	<?php the_title( '<h3 class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" itemprop="url">', '</a></h3>' ); ?>
                            <div class="entry-meta">
                            	<span class="entry-date"><?php echo __('Posted on ', 'MX'); ?><a href="<?php echo esc_url( get_permalink() ); ?>"><time class="entry-date updated" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></a></span>
                                <span class="author vcard"><?php echo __(' by ', 'MX'); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name"><?php echo get_the_author(); ?></span></span></a></span>
                                <?php _e(' wrote in ','MX');?><span class="cat-links" itemprop="genre"><?php echo get_the_category_list( __( ', ', 'MX' ) ); ?>.</span>
                                
                                <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
								<span class="comments-link" itemprop="interactionCount"><?php _e('It has ' , 'MX');?> <?php comments_popup_link( __( '0 Comment', 'MX' ), __( '1 Comment', 'MX' ), __( '% Comments', 'MX' ) ); ?>.</span>
								<?php } ?>
    							<?php edit_post_link( '<i class="fa fa-pencil"></i>'.__( 'Edit', 'MX' ), ' <span class="edit-link">', '</span>' ); ?>
                         	</div>
                        </header>
                        <?php if(get_post_format() != "quote") { ?>
                        <div class="entry-content" itemprop="articleBody">
                            <?php the_content(); ?>
                            <?php wp_link_pages(); ?>
                        </div>
                        <?php } ?>
                        <?php
						$tags = get_the_tags(); 
						if($tags && count($tags) > 0) {
						?>
                        <div class="entry-tags"><?php _e('Tags: ', 'MX' ); ?> <span itemprop="keywords"><?php the_tags('',', ','');?></span></div>
						<?php } ?>
                        
                        <?php if(mx_get_options_key('blog-viewlike-enable') == 'on'){ ?>
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
                        
                        <?php 
							if(mx_get_options_key('blog-share-enable') == "on"){ ?> 
                            	<div class="post-share">
								<?php if(intval(mx_get_options_key('blog-share-type')) == 0) {
									echo do_shortcode('[share link="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'"]');
								 } else { ?>
                                <?php echo  mx_get_options_key('blog-share-content'); ?>
                                <?php } ?>
                                </div>
                            <?php } ?>
                        <?php if(mx_get_options_key('blog-author-enable') == "on"){ ?>
                        <div class="post-author">
							<?php $author_info = get_userdata($post->post_author);?>
                            <div class="post-avatar"><?php echo get_avatar($author_info->ID, 80 ); ?></div>
                            <div class="post-author-content">
                                <h5 class="author-name"><?php the_author_posts_link();?></h5>
                                <div class="author-desc"><?php echo $author_info->user_description; ?></div>
                            </div>
                        </div>
						<?php } ?>
                        <?php if(mx_get_options_key('blog-related-enable') == "on"){ ?>
                        <div class="mx-title">
                            <h4 class="post-title"><?php _e('You may also like', 'MX'); ?></h4>
                            <div class="line"></div>
                            <div class="clear"></div>
                        </div>
                        <?php
						$categories = get_the_category();
						$cat_ids = '';
						if($categories){
							foreach($categories as $category) {
								if($cat_ids != ''){ $cat_ids .= ',';}
								$cat_ids .= $category->term_id;
							}
							$post_style = mx_get_post_meta_key('related-style');
							if(intval($post_style) == 0){
								$style = mx_get_options_key('blog-related-style');
								if($style == ""){
									$style = 3;
								}else{
									$style = intval($style) + 1;
								}
							}else{
								$style = intval($post_style);
							}
							echo do_shortcode('[blog_list number="3" style="'.esc_attr($style).'" columns="3" type="related" orderby="rand" cat__in="'.esc_attr($cat_ids).'" post__not_in="'.esc_attr(get_the_ID()).'" effect="fadeInUp" nocrop="off"]');
						}
						
						?>
                        <?php } ?> 
                        <?php comments_template(); ?>
                    </section>
                </article>		
               <?php }
            }else{
                get_template_part( 'content', 'none' );
            }
        ?>
        <?php mx_single_content_nav_follow('single-post-bottom'); ?>
		</section>
        <?php if($layout != 1) { ?> 
        <aside class="mx-col col-lg-3 col-md-4 col-sm-4 mx-<?php echo $layout_class;?>"><?php generated_dynamic_sidebar($sidebar_name); ?></aside>
        <?php } ?>
    </div>
</div>
<?php get_footer(); ?>