<?php
/**
 * Page Mini bar
 *
 * @since MX 1.0
 */

$minibar_open = mx_get_options_key('minibar-open') == "on" ? "open" : "";
?>
<div class="mx-mini-bar <?php echo esc_attr($minibar_open); ?>">
    <div class="mx-mini-bar-btns">
        <ul class="mline">
			<?php mx_get_mini_bar_content(); ?>
		</ul>
	</div>
    <div class="mini-bar-close"><i class="fa fa-times"></i></div>
</div>
<div class="mini-bar-open"><span><i class="fa fa-plus"></i></span></div>