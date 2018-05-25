<?php
/**
 * Header Mini Bar  Login Content
 *
 * @since MX 1.0
 */
 
if(class_exists( 'woocommerce' )){
	global $woocommerce;
	if ( is_user_logged_in() ) {
		global $userdata;
	?>
		<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>"><i class="fa fa-user topbar-title-icon"></i></a>
		<div class="minibar-content"><span><i class="fa fa-user"></i></span><p><?php _e('Welcome, ','MX'); echo $userdata->user_nicename; ?></p><a class="btn btn-theme" href="<?php echo esc_url( get_permalink( get_option('woocommerce_logout_page_id') ) ); ?>"><?php _e('Logout','MX'); ?></a>
		</div>
	<?php
	}else{
	?>
		<a class="wc-login-in" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>"><i class="fa fa-user topbar-title-icon"></i></a>
	   <div class="minibar-content"><span><i class="fa fa-sign-in"></i></span><p><?php _e('Hello, please login.','MX'); ?></p><a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="btn btn-theme"><?php _e('Login','MX'); ?></a>
		</div>
	<?php
	}
}else{
	if ( is_user_logged_in() ) {
		global $userdata;
	?>
		<a href="<?php echo esc_url( mx_get_options_key('global-login-page') ); ?>"><i class="fa fa-user topbar-title-icon"></i></a>
		<div class="minibar-content"><span><i class="fa fa-user"></i></span><p><?php _e('Welcome, ','MX'); echo $userdata->user_nicename; ?></p><a class="btn btn-theme" href="<?php echo esc_url(wp_logout_url(mx_add_param_for_link(get_permalink(),'action=login'))); ?>"><?php _e('Logout','MX'); ?></a>
		</div>
	<?php
	}else{
	?>
		<a class="wc-login-in" href="<?php echo esc_url( mx_add_param_for_link( mx_get_options_key('global-login-page'), 'action=login') ); ?>"><i class="fa fa-user topbar-title-icon"></i></a>
	   <div class="minibar-content"><span><i class="fa fa-sign-in"></i></span><p><?php _e('Hello, please login.','MX'); ?></p><a href="<?php echo esc_url( mx_add_param_for_link( mx_get_options_key('global-login-page'), 'action=login') ); ?>" class="btn btn-theme"><?php _e('Login','MX'); ?></a>
		</div>
	<?php
	}
}
?>