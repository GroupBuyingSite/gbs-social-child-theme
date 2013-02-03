<?php

/**
 * This function file is loaded after the parent theme's function file. It's a great way to override functions, e.g. add_image_size sizes.
 *
 *
 */

add_action( 'gb_deal_view', 'gb_set_signup_cookie' );
add_action( 'gb_deals_view', 'gb_set_signup_cookie' );
function gb_set_signup_cookie() {
    // for those special redirects with a query var
    if ( !headers_sent() && isset( $_GET['signup-success'] ) && $_GET['signup-success'] ) {
    	$cookie_time = (time() + 24 * 60 * 60 * 30);
        setcookie( 'gb_subscription_process_complete', '1', $cookie_time, '/' );
        return TRUE;
    }
    return FALSE;
}

function gb_has_location_preference() {
    if ( isset( $_COOKIE[ 'gb_subscription_process_complete' ] ) && $_COOKIE[ 'gb_subscription_process_complete' ] ) {
        return TRUE;
    }
    return FALSE;
}

add_filter( 'gb_lb_show_lightbox', 'lb_show_lightbox' );
function lb_show_lightbox( $bool ) {
	gb_set_signup_cookie();
    if ( isset( $_GET['signup-success'] ) ) {
        return FALSE;
    }
    return $bool;
}

add_filter( 'gb_lightbox_subscription_form', 'lightbox_subscription_form', 10, 4 );
function lightbox_subscription_form( $view, $show_locations, $select_location_text, $button_text ) {
    ob_start();
    ?>
        <div id="gb_light_box" class="shadow top bottom cloak">
            <div id="gb_lb_header" class="top"><header><?php gb_e('Signup and Save!') ?></header></div>
                <div id="gb_lb_content_wrap">
                    <form action="" id="gb_lightbox_subscription_form" method="post" class="clearfix">
                        <div id="gb_lb_content">
                            <span class="option email_input_wrap clearfix">
                                <label for="email_address" class="email_address"><?php gb_e('Join today to start getting awesome daily deals!'); ?></label>
                                <input type="text" name="email_address" id="email_address" value="<?php gb_e('Enter your email'); ?>" onblur="if (this.value == '') *{this.value = '<?php gb_e('Enter your email'); ?>';}" onfocus="if (this.value == '<?php gb_e('Enter your email'); ?>') {this.value = '';}" tabindex="11">
                            </span>
                            <span class="option location_options_wrap clearfix">
                                <span id="login_link_lightbox"><?php printf(gb__('Already Registered? <a href="%s" title="Login">Login.</a>'), wp_login_url()) ?></span>
                            </span>
                        </div>
                        <div id="gb_lb_footer" class="bottom">
                            <?php wp_nonce_field( 'gb_subscription' );?>
                            <input type="submit" class="flat gb_lb_floatright" name="gb_subscription" id="gb_subscription" value="<?php gb_e($button_text); ?>" tabindex="13">
                        </div>
                    </form>
            </div>
        </div>
    <?php
    $view = ob_get_clean();
    return $view;
}