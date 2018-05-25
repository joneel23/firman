<?php
/**
 * Blog Ajax Main Content
 *
 * @since MX 1.0
 */
global $blog_ajax_columns;
$thumbnail_size = "post-thumbnail";

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-ajax-element blog-timeline-style-1 '.$blog_ajax_columns); ?> itemscope itemtype="http://schema.org/Article">
    <div class="post-timeline-element-container">
    	<span class="timeline"></span>
        <div class="post-meta">
            <span class="post-type"><i class="fa <?php 
                        switch(get_post_format()){
                            case 'video': echo 'fa-film'; break;
                            case 'audio': echo 'fa-music'; break;
                            case 'image': echo 'fa-picture-o'; break;
                            case 'gallery': echo 'fa-th-large'; break;
                            case 'quote': echo 'fa-quote-left'; break;
                            default : echo 'fa-file';
                        }
                    ?>"></i></span>
            <span class="post-date-meta">
            <span class="post-date"><i class="fa fa-clock-o"></i><span class="entry-date updated" itemprop="datePublished"><?php echo esc_attr(get_the_date()); ?></span></span>
            </span>
        </div>
        <div class="post-timeline-element-content">
        <?php if(get_post_format() == "quote"){ ?>
            <div class="post-element-content">
                <div class="post-quote"><span class="post-quote-icon"><i class="fa fa-quote-right"></i></span><?php echo get_the_content(); ?></div>
            </div>
        <?php }else if(get_post_format() == "audio"){ ?>
            <?php
               $audio_type 		= mx_get_post_meta_key('audio-type');
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
            <?php if(has_post_thumbnail(get_the_ID())) { ?>
                <div class="post-element-content">
                    <div class="post-img">
                    	<a href="<?php echo esc_url(get_permalink()); ?>">
                        <?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size , array('alt' => get_the_title(),'title' => ''));  ?></a>
                        <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
                        <div class="post-tip">
                            <div class="bg"></div>
                            <a href="<?php echo esc_url(get_permalink()); ?>"><span class="pop-link-icon"><i class="fa fa-chain"></i></span></a>
                            <a class="fancyBox" href="<?php echo esc_url($full_image[0]); ?>"><span class="pop-preview-icon"><i class="fa fa-search-plus"></i></span></a>
                        </div>
                    </div>
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
                                $attachment_image = wp_get_attachment_image_src($item_id, $thumbnail_size); 
                                $full_image = wp_get_attachment_image_src($item_id, 'full'); 
                        ?>
                            <li>
                                <a href="<?php echo esc_url($full_image[0]); ?>" class="fancybox-thumb" rel="fancybox-thumb[post-time-c1-<?php echo get_the_ID(); ?>]"><img src="<?php echo esc_url($attachment_image[0]); ?>" alt=""></a>
                            </li>
                        <?php }?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        
        <h5 class="entry-title" itemprop="name"><a href="<?php echo esc_url( get_permalink() ); ?>" itemprop="url"><?php the_title(); ?></a></h5>
        <?php if(get_post_format() != "quote") { ?>
        <div class="entry-summary" itemprop="articleSection">
            <?php echo get_the_excerpt(); ?>
        </div>
        <?php } ?>
        <footer>
        	<span class="author vcard"><i class="fa fa-user"></i><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name"><?php echo get_the_author(); ?></span></span></a></span>
            <span class="cat-links"><i class="fa fa-folder-open"></i><span itemprop="genre"><?php echo get_the_category_list( __( ', ', 'MX' ) ); ?></span></span>
             <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
            <span class="comments-link"><a href="<?php echo get_permalink(get_the_ID()).'#comments'; ?>"><i class="fa fa-comments-o"></i><span itemprop="interactionCount"><?php comments_number( __( '0', 'MX' ), __( '1', 'MX' ), __( '%', 'MX' ) ); ?></span></a></span>
            <?php } ?>
            <span class="post-link"><a href="<?php echo get_permalink(get_the_ID()); ?>"><i class="fa fa-chain"></i></a></span>
        </footer>
        </div>
    </div>
</article>