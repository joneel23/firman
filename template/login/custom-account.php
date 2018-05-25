<?php
/**
 * Login Template > account
 *
 * @since MX 1.0
 */
 
global $user_ID, $user_identity, $userdata; wp_get_current_user();
 
?>
<div class="login-account-posts col-md-9 col-sm-9">
	<h3><?php echo __('Welcome, ','MX').$user_identity; ?></h3>
    <div class="login-description">
    	<?php echo $userdata->description; ?>
    </div>
    <div class="mx-title">
        <h4 class="post-title"><?php _e('Yours Posts', 'MX'); ?></h4>
        <div class="line"><span class="left-line"></span><span class="right-line"></span></div>
        <div class="clear"></div>
    </div>
    <div class="login-posts">
    <?php
	//The Query
	query_posts('author='.$userdata->ID);
	
	//The Loop
	if ( have_posts() ) {	
		while ( have_posts() ) {
			the_post();
			echo '<h5 class="entry-title"> <a href="' . esc_url( get_permalink() ) . '" title="'.esc_attr(get_the_title()).'">'.get_the_title().'</a></h5>'; 
		}
	}else{
		_e("You has not contributed anything!",'MX');
	}
	
	//Reset Query
	wp_reset_query();
	?>
    </div>
</div>
<div class="login-account-information col-md-3 col-sm-3">
    <div class="usericon">
    <?php echo get_avatar($userdata->ID, 80); ?>
    </div>
    <div class="userinfo">
        <p>
            <a class="btn btn-theme" href="<?php echo esc_url(wp_logout_url(mx_add_param_for_link(get_permalink(),'action=login'))); ?>"><?php _e('Log out','MX'); ?></a> 
            <?php if (current_user_can('manage_options')) { 
                echo '<a class="btn btn-theme" href="' . admin_url() . '">' . __('Admin','MX') . '</a>'; } else { 
                echo '<a class="btn btn-theme" href="' . admin_url() . 'profile.php">' . __('Profile','MX') . '</a>'; } ?>
    
        </p>
    </div>
</div>