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

    $plugins_url  = plugins_url();
    $message      = '<img src="'.get_bloginfo('template_url').'/images/email_logo.png" alt="Badge green"><br>';
    $message     .= 'Thank you for signing up for the Role Models Matter toolkit.  This toolkit provides fun, online training and resources for role models to develop the skills to engage youth in STEM (science, technology, engineering, and math).  Please be sure to sign in each time you visit the site so that you can save and share responses to questions within each tool.'."<br><br>\r\n\n";
    $message     .= sprintf('Username: %s', $user->user_login)."<br>\r\n";
    $message     .= sprintf('Link to Role Models Matter Toolkit: %s', wp_login_url())."<br>\r\n";
    
    $headers      = "Content-Type: text/html; charset=UTF-8";

    wp_mail($user->user_email, sprintf(__('[%s] Your username and password'), $blogname), $message, $headers);

}
endif;