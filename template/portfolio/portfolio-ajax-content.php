<?php
/**
 * Portfolio Ajax Main Content
 *
 * @since MX 1.0
 */
global $paged, $portfolio_ajax_per_page_num,$portfolio_ajax_show_columns, $portfolio_ajax_page_cats, $portfolio_ajax_page_tags,$portfolio_ajax_auto_load, $portfolio_ajax_show_style, $thumbnail_size, $page_image_no_crop;

if($paged == 0){$paged = 1;}

// get ajax page item show columns
$portfolio_ajax_show_columns = isset($portfolio_ajax_show_columns) ? intval($portfolio_ajax_show_columns) : 1;
// get ajax page item show style
$portfolio_ajax_show_style	= isset($portfolio_ajax_show_style) ? intval($portfolio_ajax_show_style) : 1;
// get per page show number
$per_page_num = isset($portfolio_ajax_per_page_num) ? intval($portfolio_ajax_per_page_num) : 2;
// get per page items categories
$page_cats = isset($portfolio_ajax_page_cats) ? esc_attr($portfolio_ajax_page_cats) : "";
// get per page items tags
$page_tags = isset($portfolio_ajax_page_tags) ? esc_attr($portfolio_ajax_page_tags) : "";

$portfolio_ajax_columns = mx_get_element_columns(intval($portfolio_ajax_show_columns));

$thumbnail_size = mx_get_thumbnail_size(intval($portfolio_ajax_show_columns), $page_image_no_crop);

$tax_query		=	array();
// category
if($page_cats != "") {
	$slugs = explode("," , $page_cats);
	$tax_query[] = array('taxonomy' => 'portfolio-cats','field' => 'slug','terms' => $slugs);
}
// tags
if($page_tags != "") {
	$slugs = explode("," , $page_tags);
	$tax_query[] = array('taxonomy' => 'portfolio-tags','field' => 'slug','terms' => $slugs);
}

 // get portfolio
$args = array(	'post_type' => 'portfolio',
				'post_status' => 'publish',
				'paged' => $paged,
				'posts_per_page'=> intval($per_page_num)
			 );
			 
// show category,tags portfolio
if(count($tax_query) > 0) {
	$args['tax_query'] = $tax_query;
}

// The Query
$portfolios = new WP_Query($args);
if ( $portfolios->have_posts() ) {
?>
<div class="ajax-main-area">
    <section class="ajax-isotope row portfolio-ajax-type" <?php echo $page_image_no_crop == "on" ? 'data-layoutmode="masonry"' : ''; ?>>
    <?php 
        while ( $portfolios->have_posts() ) {
            $portfolios->the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('post-ajax-element portfolio-element '.$portfolio_ajax_columns.' portfolio-style-'.intval($portfolio_ajax_show_style));?> itemscope itemtype="http://schema.org/CreativeWork">
    <?php 
		get_template_part( 'template/portfolio/portfolio', 'content-style-'.$portfolio_ajax_show_style);
     } ?>
    </section>
    <?php 
		if($portfolios->max_num_pages > $paged) {
	?>
    <div class="ajax-load-content" data-link="<?php echo esc_url(get_pagenum_link($paged+1)) ;?>" data-page="<?php echo esc_attr($paged+1); ?>" data-max="<?php echo esc_attr($portfolios->max_num_pages); ?>"></div>
    <div class="ajax-load-btn-container row">
    	<?php if($portfolio_ajax_auto_load != "on"){ ?>
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