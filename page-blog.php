<?php
/**
 * Template Name: Blog Template
 *
 * @since MX 4.0
 */

global $blog_style, $blog_default_post_with_thumbs;

get_header();

// get page layout
$layout = mx_get_page_layout();
$layout_class = mx_get_page_layout_class();
// get page items show number
$blog_ajax_per_page_num = mx_get_post_meta_key('page-show-numbers');
// get page items show categories
$blog_ajax_page_cats = mx_get_post_meta_key( 'ajax-cats');
// get page show style
$blog_style = mx_get_post_meta_key('post-show-style');

$blog_default_post_with_thumbs = mx_get_options_key('blog-enable-default-post-thumbs');

$sidebar_name = mx_get_post_meta_key('sidebar-type');

if($sidebar_name == ""){
	$sidebar_name = "0";
}

?>
<div id="main" class="container">
	<div class="row">
        <section class="<?php echo $layout == 1 ? 'col-md-12 col-sm-12' : 'mx-col col-lg-9 col-md-8 col-sm-8 mx-'.$layout_class; ?>">
		<?php
			
			if($paged == 0){ $paged = 1;}
                        
			$args = array(	'post_type' => 'post',
							'post_status' => 'publish',
							'paged' => $paged,
							'posts_per_page'=> $blog_ajax_per_page_num
						 );
			if($blog_ajax_page_cats != "") {
				$cats = explode("," , $blog_ajax_page_cats);
				
				if(count($cats) > 0 && $cats[0] != "") {
					$args['category__in'] = $cats;
				}
			}
			// The Query
			query_posts($args);
						
            if (have_posts() ) {
                // Start the Loop.
                while ( have_posts() ) { 
                    the_post();
                    /*
                     * Include the post format-specific template for the content. If you want to
                     * use this in a child theme, then include a file called called content-___.php
                     * (where ___ is the post format) and that will be used instead.
                     */
                    get_template_part( 'content', get_post_format() );
                }
                mx_content_pagination('nav-bottom' , 'pagination-centered');
            }else{
                get_template_part( 'content', 'none' );
            }
			wp_reset_postdata();
        ?>
		</section>
        <?php if($layout != 1) { ?> 
        <aside class="mx-col col-lg-3 col-md-4 col-sm-4 mx-<?php echo $layout_class;?>"><?php generated_dynamic_sidebar($sidebar_name); ?></aside>
        <?php } ?>
    </div>
</div>
<?php get_footer(); ?>