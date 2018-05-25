<?php
/**
 * Header Style 4
 *
 * @since MX 3.0
 */
?>
<header id="site-header" class="site-header-style-4 <?php echo mx_get_options_key('header-fixed-menu-enable') == "on" ? "header-fixed-support" : "";?>">
    <div id="mx-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                	<div class="mx-header-logo">
                        <div class="logo">
                            <?php if( mx_get_options_key('logo-enable') == "on" ){ ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home">
                                <img class="logo-default" src="<?php echo esc_url( mx_get_options_key('logo-image') ); ?>" width="<?php echo mx_get_options_key('logo-image-width'); ?>" height="<?php echo mx_get_options_key('logo-image-height'); ?>" alt="">
                                <?php if(mx_get_options_key('logo-image') != ""){?>
                                <img class="logo-retina" src="<?php echo esc_url( mx_get_options_key('logo-retina-image')); ?>" width="<?php echo mx_get_options_key('logo-image-width'); ?>" height="<?php echo mx_get_options_key('logo-image-height'); ?>" alt="">
                                <?php } ?>
                            </a>
                            <?php }else { ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' );?></a>
                            </h1>
                            <?php }?>
                        </div>
                    </div>
                    <div class="mx-header-right-container">
                    <div class="mx-header-right">
                    	<div class="mx-custom-container">
							<?php if(mx_get_options_key('header-search-enable') == "on"){ ?>
                            <div class="mx-nav-form-content">
                                <form role="search" class="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                    <div>
                                    <?php if (class_exists( 'woocommerce' ) && mx_get_options_key('woocommerce-search-enable') != "off") { ?>
                                        <input class="sf-type" name="post_type" type="hidden" value="product" />
                                    <?php } ?>
                                    <input class="sf-s" name="s" type="text" placeholder="<?php _e('Search','MX'); ?>" />
                                    <button type="submit" class="sf-submit btn btn-theme"><i class="fa fa-search"></i></button>
                                   </div>
                                </form>
                            </div>
                            <?php } ?>
                            <ul class="inline mx-header-right-list">
                                <?php if(mx_get_options_key('global-login-enable') == "on"){ ?>
                                <li class="mx-wc-login">
                                    <?php get_template_part( 'template/header/header', 'login-content' ); ?>
                                </li>
                                <?php } ?>
                                <?php if(class_exists( 'woocommerce' ) && class_exists( 'YITH_WCWL_UI' ) && mx_get_options_key('woocommerce-wish-enable') == "on"){ ?>
                                <li class="mx-wish-list">
                                    <?php get_template_part( 'woocommerce/content', 'wish-list' ); ?>
                                </li>
                                <?php } ?>
                                <?php if(class_exists( 'woocommerce' ) && mx_get_options_key('woocommerce-cart-enable') == "on"){ ?>
                                <li class="mx-cart-list">
                                    <?php get_template_part( 'woocommerce/content', 'cart-list-btn-2' ); ?>
                                    <div class="cart-list-contents-container">
                                    <?php get_template_part( 'woocommerce/content', 'cart-list' ); ?>
                                    </div>
                                </li>
                                <?php } ?>
                                <li class="responsive-mobile-menu"><a href="#" class="header-responsive-menu-btn"><i class="fa fa-bars"></i></a></li>
                            </ul>
                            <?php if( mx_get_options_key('header-custom-enable') == "on"  && mx_get_options_key('header-custom-content') != ""){?>
                            <div class="mx-header-right-custom">
                                <?php echo mx_get_options_key('header-custom-content'); ?>
                            </div>
                            <?php } ?>
                            <?php if( mx_get_options_key('header-social-enable') == "on" ){?>
                                <ul class="mx-social social-circle inline">
                                    <?php echo mx_get_social_list(); ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="mx-header-right">
                    	<div class="mx-nav-container">
							<?php
                                $mx_main_menu = array(
                                    'theme_location'  	=> 'mx_menu',
                                    'container'			=> 'false',
                                    'menu_class'    	=> 'mx-nav-menu',
                                    'fallback_cb'	  	=> 'mx_show_setting_primary_menu'                
                                ); 
								if(mx_get_options_key('mega-menu-enable') != 'off'){
									$mx_main_menu['walker'] = new Penguin_Walker();
								}
                                wp_nav_menu($mx_main_menu);
                                
                            ?>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="mobile-menu">
    <div class="mobile-menu-container">
        <span class="mobile-menu-close-btn"><i class="fa fa-times-circle-o"></i></span>
        <?php if(mx_get_options_key('header-search-enable') == "on"){ ?>
        <div class="mx-mobile-search">
            <form role="search" class="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div>
                <?php if (class_exists( 'woocommerce' ) && mx_get_options_key('woocommerce-search-enable') != "off") { ?>
                    <input class="sf-type" name="post_type" type="hidden" value="product" />
                <?php } ?>
                <input class="sf-s" name="s" type="text" placeholder="<?php _e('Search ...','MX'); ?>" />
                <button type="submit" class="sf-submit btn btn-theme"><i class="fa fa-search"></i></button>
               </div>
            </form>
        </div>
        <?php } ?>
        <?php
                $mx_main_menu = array(
                    'theme_location'  	=> 'mx_menu',
                    'container'			=> 'false',
                    'menu_class'    	=> 'mx-nav-mobile-menu mline'
                ); 
                wp_nav_menu($mx_main_menu);
            ?>
     </div>
</div>