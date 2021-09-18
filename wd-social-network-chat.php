<?php
/*
 * Plugin Name: WebData Social Network Chat
 * Version: 1.2.3
 * Plugin URI: https://www.web-data.online/
 * Description: Add your favourite social media chat buttons easily to your WordPress website for easy contact.
 * Author: web-data.online
 * Requires at least: 4.0
 * Tested up to: 5.8.1
 *
 * Text Domain: wb-social-media-chat
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author web-data.io
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-wb-social-media-chat.php' );
require_once( 'includes/class-wb-social-media-chat-functions.php' );
require_once( 'includes/class-wb-social-media-chat-dynamic-css.php' );
require_once( 'includes/class-wb-social-media-chat-ajax.php' );
require_once( 'includes/class-wb-social-media-chat-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-wb-social-media-chat-admin-api.php' );

/**
 * Returns the main instance of WB_Social_Media_Chat to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object WB_Social_Media_Chat
 */
function WB_Social_Media_Chat () {
	$instance = WB_Social_Media_Chat::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = WB_Social_Media_Chat_Settings::instance( $instance );
	}

	return $instance;
}

WB_Social_Media_Chat();

$wb_cta_email = esc_attr(sanitize_text_field(get_option('wb_cta_email')));
$wb_cta_whatsapp = esc_attr(sanitize_text_field(get_option('wb_cta_whatsapp')));
$wb_cta_line = esc_attr(sanitize_text_field(get_option('wb_cta_line')));
$wb_cta_telegram = esc_attr(sanitize_text_field(get_option('wb_cta_telegram')));
$wb_cta_skype = esc_attr(sanitize_text_field(get_option('wb_cta_skype')));
$wb_cta_facebook = esc_attr(sanitize_text_field(get_option('wb_cta_facebook')));
$wb_cta_vk = esc_attr(sanitize_text_field(get_option('wb_cta_vk')));
$wb_cta_viber = esc_attr(sanitize_text_field(get_option('wb_cta_viber')));
$wb_cta_custom_url = esc_attr(sanitize_text_field(get_option('wb_cta_custom_url')));
$wb_cta_phone = esc_attr(sanitize_text_field(get_option('wb_cta_phone')));

// Settings notice
if($wb_cta_email == '' && $wb_cta_whatsapp == '' && $wb_cta_line == '' && $wb_cta_telegram == '' && $wb_cta_skype == '' && $wb_cta_facebook == '' && $wb_cta_vk == '' && $wb_cta_viber == '' && $wb_cta_custom_url == '' && $wb_cta_phone == '') {
	function snc_admin_notice__settings_empty() {
		$class = 'notice notice-success snc-notice-success';
		$message = 'You have Social Network Chat plugin enabled, but you don´t seem to have any channels enabled yet. Please visit the <a href="' . admin_url() . 'admin.php?page=wb_social_media_chat_settings&tab=email"> settings page to enable some channels.</a>';
	
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message ); 
	}

	add_action( 'admin_notices', 'snc_admin_notice__settings_empty' );
} 