<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme
 *
 * @since MX 4.0
 */

global $blog_style, $blog_default_post_with_thumbs;

get_header();

// get layout, sidebar
if(((is_home() && !is_front_page()) || is_category()|| is_tag() || is_date()) && (intval(get_option('page_for_posts')) > 0) ) {
	//when you use custom page for blog will use the page layout
	$layout = mx_get_page_layout(get_option('page_for_posts'));
	$layout_class = mx_get_page_layout_class(get_option('page_for_posts'));
	$sidebar_name = mx_get_post_meta_key('sidebar-type', get_option('page_for_posts'));
	$blog_style = mx_get_options_key('blog-post-show-style');
	$blog_default_post_with_thumbs = mx_get_options_key('blog-enable-default-post-thumbs');
	if($sidebar_name == ""){
		$sidebar_name = "0";
	}
}else{
	// index default will use global layout 
	$layout = mx_get_page_layout('global'); 
	$layout_class = mx_get_page_layout_class('global');
	$blog_style = mx_get_options_key('blog-post-show-style');
	$blog_default_post_with_thumbs = mx_get_options_key('blog-enable-default-post-thumbs');
	$sidebar_name = '0';
}

?>
<div id="main" class="container">
	<div class="row">
        <section class="<?php echo $layout == 1 ? 'col-md-12 col-sm-12' : 'mx-col col-lg-9 col-md-8 col-sm-8 mx-'.$layout_class; ?>">
		<?php
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
        ?>
		</section>
        <?php if($layout != 1) { ?> 
        <aside class="mx-col col-lg-3 col-md-4 col-sm-4 mx-<?php echo $layout_class;?>"><?php generated_dynamic_sidebar($sidebar_name); ?></aside>
        <?php } ?>
    </div>
</div>
<?php get_footer(); ?>