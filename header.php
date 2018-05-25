<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @since MX 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> class="no-touch">
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <?php 
	global $page, $paged, $post;
	
	// get the current page number
	$paged = 1;
	if (get_query_var('paged')) {
		$paged = get_query_var('paged');
	} else if (get_query_var('page')) {
		$paged = get_query_var('page');
	}
	
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo esc_url( (mx_get_options_key('favicon') != "") ? mx_get_options_key('favicon') : get_template_directory_uri()."/img/favicon.png" );?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>">
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/ie10-viewport-bug-workaround.js"></script>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
      <script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
    <![endif]-->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){ 
	  jQuery("a").on('click', function(event) {
	    if (this.hash !== "") {
	      event.preventDefault();     
	      var hash = this.hash;
	      jQuery('html, body').animate({
	        scrollTop: jQuery(hash).offset().top
	      }, 800, function(){
	        window.location.hash = hash;
	      });
	    } 
	  });
	});
</script>

<!--<script src='//ui.powerreviews.com/stable/4.0/ui.js'></script>-->

	<?php wp_head(); ?>

</head>
<?php 
	$global_layout 	= 'boxed-layout'; 
	if(intval(mx_get_options_key('global-layout')) == 1){
		$global_layout = 'wide-layout';
	}
?>
<body <?php body_class($global_layout); ?>>
	<div class="wrapper">
    	<div id="header-wrap">
        	<?php if(mx_get_options_key('header-banner-enable') == "on") { ?>
            <!-- header banner -->
            <section id="header-banner" data-id="<?php echo mx_get_options_key('header-banner-id'); ?>">
                <div class="container">
                	<div class="header-banner-content">
                	<?php echo do_shortcode(mx_get_options_key('header-banner-content')); ?>
                    <a href="#" class="close-btn"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </section>
        <?php } ?>
        	<?php 
			// topbar content
			if(mx_get_options_key('header-topbar-enable') == "on"){ ?>
        	<section id="header-topbar">
            	<div class="container">
                	<div class="row">
                        <div class="col-md-6 col-sm-6">
                        	<div id="header-topbar-left-content">
                            <?php mx_get_topbar_content(0); ?>
                            </div>
                        </div>
                         <div class="col-md-6 col-sm-6">
                         	<div id="header-topbar-right-content">
                            <?php mx_get_topbar_content(1); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php } ?>
            <?php 
			$header_style	= intval(mx_get_options_key('header-style')) + 1;
			get_template_part( 'template/header/header', 'style-'.$header_style);
			?>
        </div>
        
		<?php 
		
        // current post, page id
        $post_id = ($post) ? $post->ID : '-1';
        if(is_home() && !is_front_page()){
			$post_id = get_option('page_for_posts');
		}else if(class_exists( 'woocommerce') && is_shop()){
			$post_id = wc_get_page_id( 'shop' );
		}

        // show header layerslider
        if(!(is_category() || is_tag() || is_404() || is_search() || is_date()) && intval(get_post_meta($post_id , 'slide-type', true)) != 0) :
        ?>
			<?php if(intval(get_post_meta($post_id , 'slide-type', true)) == 1 && intval(get_post_meta($post_id , 'layer-slide-id', true)) != 0) : ?>
            <div id="page-slider-wrap" class="page-slider-layerslider">
                <?php echo do_shortcode('[layerslider id="'.(intval(get_post_meta($post_id , 'layer-slide-id', true))).'"]'); ?>
            </div>
            
            <?php elseif(intval(get_post_meta($post_id , 'slide-type', true)) == 2 && intval(get_post_meta($post_id , 'rev-slide-id', true)) != 0) : ?>
            <div id="page-slider-wrap" class="page-slider-rev_slider">
                <?php echo do_shortcode('[rev_slider '.(intval(get_post_meta($post_id , 'rev-slide-id', true))).']'); ?>
            </div>
            
            <?php endif; ?>
        <?php endif;  ?>
        
        <?php 
		global $current_tax;
		$current_tax = get_query_var('taxonomy');
		if( class_exists( 'woocommerce') && ( ( is_tax() && taxonomy_exists('product_cat') && $current_tax == "product_cat" ) || ( is_tax() && taxonomy_exists('product_tag') && $current_tax == "product_tag" ) || is_singular('product') || is_shop() ) ) {
			// woocommerce will use woocommerce title
		}else{
		?>
        <div id="page-header-wrap" >
        	<?php if(is_page_template('page-login.php') || is_404()){ ?>
           
			<?php }else if ( ( ( (is_home() && !is_front_page()) || is_page() || is_single()) && get_post_meta($post_id , 'title-show', true) != "off")  ) { 
			?>
        	<header id="site-content-header">
            	<div class="container">
                	<div class="page-title">
						<?php 
                            $title 	= 	get_post_meta($post_id, 'title-content', true);
                            $desc	=	get_post_meta($post_id, 'title-desc', true);
                            $enable_breadcrumb	=	get_post_meta($post_id, 'title-breadcrumb', true);
                            if($title == ''){ $title = '<h1 class="title">'.get_the_title($post_id).'</h1>'; }
                        ?>
                        <?php echo $title; ?>
                        <?php if($desc != "") { ?>
                        <div class="page-desc"><?php echo $desc; ?></div>
                        <?php } ?>
                    </div>
                    <?php if(!(is_page() && is_front_page()) && $enable_breadcrumb != "off") { ?>
                    <div class="breadcrumbs">
                        <?php echo mx_page_links(); ?>
                    </div>
                    <?php } ?>
                </div>
            </header>
            <?php }else if ( (is_tax() && ((taxonomy_exists('portfolio-cats') && $current_tax == "portfolio-cats") || (taxonomy_exists('portfolio-tags') && $current_tax == "portfolio-tags"))) || is_category() || is_tag() || is_search() || is_date() || is_author()) { ?>
            <header id="site-content-header">
            	<div class="container">
                	<div class="page-title">
                		<h1 class="title"><?php echo mx_page_title();?></h1>
                    </div>
                    <div class="breadcrumbs">
                        <?php 
							echo mx_page_links();
							if(is_search()){
								echo '<span class="breadcrumb-right">/</span>';
								printf( __( 'Search Results for "%s"', 'MX' ), get_search_query() );
							}
						?>
                    </div>
                </div>
				
            </header>
            <?php } ?>
        </div>
		
        <div id="page-content-wrap">
        
<?php } ?>