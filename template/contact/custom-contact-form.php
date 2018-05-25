<?php
/**
 * Contact Template > contact form
 *
 * @since MX 1.0
 */

// Get a key from https://www.google.com/recaptcha/admin/create
$publickey 	= mx_get_post_meta_key('recaptcha-pub-api');
$privatekey = mx_get_post_meta_key('recaptcha-pri-api');

$recaptcha_valid = false;

if(mx_get_post_meta_key('form-recaptcha') == "on" && $publickey != "" && $privatekey != ""){
	$recaptcha_valid = true;
	require_once(dirname(__FILE__).'/../../inc/tools/recaptchalib.php');
	# the response from reCAPTCHA
	$resp = null;
	# the error code from reCAPTCHA, if any
	$recaptcha_error = null;
	# was there a reCAPTCHA response?
	if (isset($_POST["recaptcha_response_field"])) {
			$resp = recaptcha_check_answer ($privatekey,
											$_SERVER["REMOTE_ADDR"],
											$_POST["recaptcha_challenge_field"],
											$_POST["recaptcha_response_field"]);
			if ($resp->is_valid) {
					//success
			} else {
					# set the error code so that we can display it
					$recaptcha_error = $resp->error;
					$hasError = true;
			}
	}
}

if(isset($_POST['submitted'])) {
	$nameError 		= '';
    $emailError 	= '';
    $subjectError	= '';
    $messageError 	= '';
	$recipientError	= '';
	$emailSent		= false;
	if(trim($_POST['contactName']) === '') {
		$nameError = __('Please enter your name.','MX');
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = __('Please enter your email address.','MX');
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = __('You entered an invalid email address.','MX');
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
	
	if(trim($_POST['subject']) === '') {
		$subjectError = __('Please enter subject.','MX');
		$hasError = true;
	} else {
		$subject = trim($_POST['subject']);
	}

	if(trim($_POST['message']) === '') {
		$messageError = __('Please enter a message.','MX');
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$message = stripslashes(trim($_POST['message']));
		} else {
			$message = trim($_POST['message']);
		}
	}

	//If there is no error, send the email
	if(!isset($hasError)) {
		$emailTo = mx_get_post_meta_key('contact-recipient');
		$backSender = mx_get_post_meta_key('contact-backsender');
		if($emailTo != ""){
			$subject = $subject;
			$body = __('From: ','MX').$name.'<'.$email.'><br />'.$message;
			$headers = __('From: ','MX').$name.'<'.$email.'>';
			add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
			$emailSent = wp_mail( $emailTo, $subject, $body, $headers );
			
			//send email to sender
			if($emailSent && $backSender == "on") {
				$subject = get_bloginfo('name');
				$headers = __('From: ','MX').get_bloginfo('name').'<'.$emailTo.'>';
				$body	 = __('Thanks, your email was sent successfully.','MX');
				wp_mail( $email, $subject, $body, $headers );
			}
		}else{
			$hasError = false;
			$recipientError = __('Please add your recipient email through edit admin -> your contact page -> page options setting.','MX');
		}
	}
}
?>

<div class="row">
	<div class="col-md-12 col-sm-12">
    <h4><?php _e('Contact Form','MX'); ?></h4>
        <form id="contact-form" class="contact-form" action="<?php echo esc_url(get_permalink()); ?>" method="post">
            <?php 
                if(isset($emailSent) && $emailSent == true) { 
                    echo do_shortcode('[alert type="success"]'.'<strong>'.__('Congratulations!','MX').'</strong>'.__('Thanks, your email was sent successfully.','MX').'[/alert]');
                 } else if(isset($hasError)) {
                     $err_alert = '[alert type="warning"]'.'<strong>'.__('Oh snap! You got error!','MX').'</strong>'.'<p><ol>';
                     if($recipientError != '') $err_alert .= '<li><h6>'.$recipientError.'</h6></li>';
                     if($nameError != '') $err_alert .= '<li><h6>'.$nameError.'</h6></li>';
                     if($emailError != '') $err_alert .= '<li><h6>'.$emailError.'</h6></li>';
                     if($subjectError != '') $err_alert .= '<li><h6>'.$subjectError.'</h6></li>';
                     if($messageError != '') $err_alert .= '<li><h6>'.$messageError.'</h6></li>';
                     if($recaptcha_valid && $recaptcha_error != '') $err_alert .= '<li><h6>'.$recaptcha_error.'</h6></li>';
                     $err_alert .= '</ol></p>[/alert]';
                     echo do_shortcode($err_alert);
                }
            ?>
            <div>
                <label for="contactName"><?php _e('Name','MX'); ?><span class="description"><?php _e('(required)','MX'); ?></span></label>
                <input type="text" class="input-xlarge" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName']) && !$emailSent){ echo $_POST['contactName'];}?>" />
            </div>
            <div>
            	<label for="email"><?php _e('Email','MX'); ?><span class="description"><?php _e('(required)','MX'); ?></span></label>
                <input type="text" class="input-xlarge" name="email" id="email" value="<?php if(isset($_POST['email']) && !$emailSent){  echo $_POST['email'];}?>" />
            </div>
            <div>
                <label for="subject"><?php _e('Subject','MX'); ?><span class="description"><?php _e('(required)','MX'); ?></span></label>
                <input type="text" class="input-xlarge" name="subject" id="subject" value="<?php if(isset($_POST['subject']) && !$emailSent){  echo $_POST['subject'];}?>" />
            </div>
             <div>
             	<label for="commentsText"><?php _e('Message','MX'); ?><span class="description"><?php _e('(required)','MX'); ?></span></label>
                <textarea name="message" id="commentsText" rows="5" cols="60" class="input-xlarge required requiredField"><?php if(isset($_POST['message']) && !$emailSent) { if(function_exists('stripslashes')) { echo stripslashes($_POST['message']); } else { echo $_POST['message']; } } ?></textarea>
            </div>
            <?php 
                if($recaptcha_valid) {
                    $recaptcha_lang = mx_get_post_meta_key('recaptcha-lang');
                    $recaptcha_theme = mx_get_post_meta_key('recaptcha-theme');
            ?>
                <script type="text/javascript">
                var RecaptchaOptions = {
                   lang : '<?php echo $recaptcha_lang; ?>',
                   theme : '<?php echo $recaptcha_theme; ?>'
                };
                </script>
            <?php 
                echo recaptcha_get_html($publickey, $recaptcha_error); 
             } ?>
            <input type="submit" id="submit" class="btn btn-theme" value="<?php _e('Send Message','MX'); ?>" />
            <input type="hidden" name="submitted" id="submitted" value="true" />
        </form>
    </div>
</div>