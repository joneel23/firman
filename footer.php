<?php
/**
 * The Footer for our theme.
 *
 * @since MX 1.0
 */
?>		</div><!-- end page content warpper -->
		<div class="footer-wrap">
        	<?php 
			// get footer widget list
			$widgets = mx_get_footer_widget_active_items(); 
			if(count($widgets) > 0) {
			?>
        	<div id="site-footer-widget" class="site-footer-widget">
                <div class="container">
                    <div class="row">
						<?php
                        foreach($widgets as $widget){
                        ?>
                        <div class="<?php echo esc_attr($widget[0]); ?>"><?php dynamic_sidebar(esc_attr($widget[1])); ?></div>
                        <?php							
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php $footer_bottom_style = intval(mx_get_options_key('footer-bottom-style')); ?>
            <div id="site-footer-bottom" class="<?php echo $footer_bottom_style == 1 ? "site-footer-style-center" : ""; ?>">
                <div class="container">
                	<div class="row">
						<?php if(mx_get_options_key('footer-menu-enable') == "on"){ ?>
                        <div class="col-md-12">
                            <?php 
                            $mx_main_menu = array(
                                'theme_location'  	=> 'mx_bottom_menu',
                                'container'			=> false,
                                'menu_class'    	=> 'mx-nav-bottom-menu inline',
                                'fallback_cb'	  	=> 'mx_show_setting_other_menu',
								'depth'				=>	'1'
                            ); 
                            wp_nav_menu($mx_main_menu);
                            ?>
                         </div>
                        <?php } ?>
                        <div id="site-footer-custom-area" class="col-md-12">
                        	<div class="row">
								<?php if(mx_get_options_key('footer-custom-content-left') != ""){ ?>
                                <div id="site-footer-custom-area-left" class="col-md-6 col-sm-6">
                                <?php echo do_shortcode(mx_get_options_key('footer-custom-content-left')); ?>
                                </div>
                                <?php } ?>
                                <?php if(mx_get_options_key('footer-custom-content-right') != ""){ ?>
                                <div id="site-footer-custom-area-right" class="col-md-6 col-sm-6">
                                <?php echo do_shortcode(mx_get_options_key('footer-custom-content-right')); ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div><!-- end footer warpper -->
	</div><!-- end wrapper -->
    
    <?php 
	if(mx_get_options_key('minibar-enable') == "on" ){
		get_template_part( 'template/tools/mini', 'bar' );
	}?>

	<!-- POWERREVIEWS JS -->
	<script type="text/javascript" src='//ui.powerreviews.com/stable/4.0/ui.js'></script>
	<!-- END POWERREVIEWS JS -->

	<?php wp_footer() ?>

</body>
</html>