<?php
/**
 * Plugin Name: Custom New User Notifications
 * Description: Customize the "New User Registration" and "Your username and password" notifications
 * Version: 1.0
 * Author: Guriev Eugen
 * Author URI: http://gurievcreative.com
 */

if ( !function_exists('wp_new_user_notification') ) :

/**
 * Remove password from email notify
 * @param  integer $user_id        
 * @param  string $plaintext_pass 
 */
function wp_new_user_notification($user_id, $plaintext_pass = '') 
{
    $user 	  = get_userdata( $user_id );
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
    $message .= sprintf(__('E-mail: %s'), $user->user_email) . "\r\n";

    @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);

    if(empty($plaintext_pass)) return;

    $message  = sprintf(__('Username: %s'), $user->user_login) . "\r\n";
    $message .= wp_login_url() . "\r\n";

    wp_mail($user->user_email, sprintf(__('[%s] Your username and password'), $blogname), $message);

}
endif;