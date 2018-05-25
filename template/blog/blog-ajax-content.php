<?php
/**
 * Blog Ajax Main Content
 *
 * @since MX 1.0
 */
global $paged, $blog_ajax_per_page_num,$blog_ajax_show_columns, $blog_ajax_page_cats, $blog_ajax_auto_load, $page_image_no_crop,$blog_ajax_style, $blog_ajax_columns, $thumbnail_size, $blog_ajax_page;

if($paged == 0){$paged = 1;}
// get show columns
$blog_ajax_show_columns = isset($blog_ajax_show_columns) ? intval($blog_ajax_show_columns) : 1;
// get show item number
$per_page_num = isset($blog_ajax_per_page_num) ? intval($blog_ajax_per_page_num) : 10;
// get item categories
$page_cats = isset($blog_ajax_page_cats) ? esc_attr($blog_ajax_page_cats) : "";
// get ajax style
$blog_ajax_style = isset($blog_ajax_style) ? intval($blog_ajax_style) : 1;

$blog_ajax_columns = mx_get_element_columns(intval($blog_ajax_show_columns));

$thumbnail_size = mx_get_thumbnail_size(intval($blog_ajax_show_columns), $page_image_no_crop);

$args = array(	'post_type' => 'post',
				'post_status' => 'publish',
				'paged' => $paged,
				'posts_per_page'=> $per_page_num
			 );
			 
if($page_cats != "") {
	$cats = explode("," , $page_cats);
	if(count($cats) > 0 && $cats[0] != "" ) {
		$args['category__in'] = $cats;
	}
}
// The Query
$blog_posts = new WP_Query($args);
if ( $blog_posts->have_posts() ) {
?>
<div class="ajax-main-area">
    <section class="ajax-isotope row blog-ajax-type">
    <?php 
        while ( $blog_posts->have_posts() ) {
            $blog_posts->the_post();
    ?>
        <?php get_template_part( 'template/blog/blog', 'ajax-content-item-style-'.$blog_ajax_style); ?>
    <?php } ?>
    </section>
    <?php 
		if($blog_posts->max_num_pages > $paged) {
	?>
    <div class="ajax-load-content" data-link="<?php echo (isset($blog_ajax_page) && $blog_ajax_page != "" ? esc_url($blog_ajax_page) : esc_url(get_pagenum_link($paged+1))) ;?>" data-page="<?php echo esc_attr($paged+1); ?>" data-max="<?php echo esc_attr($blog_posts->max_num_pages); ?>"></div>
    <div class="ajax-load-btn-container row">
    	<?php if($blog_ajax_auto_load != "on"){ ?>
    	<a class="post-ajax-load-btn btn btn-theme btn-large"><?php echo __('Click Load More ...','MX'); ?></a>
        <?php }else{ ?>
        <span class="post-ajax-scroll-load"><i class="fa fa-arrow-down"></i></span>
        <?php } ?>
        <span class="post-ajax-loading"><i class="fa fa-spinner fa-spin"></i><?php echo __('Load ...','MX'); ?></span>
   	</div>
    <?php } ?>
</div>
<?php }?>
<?php wp_reset_postdata(); ?>