<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WD_Snc_Ajax_Class {

    /**
	 * Email function
	 * @access  public
	 * @since   1.0.0
	 */
    public function wb_cta_send_mail() {
        $data = esc_js($_POST['sendData']);
        $data = json_decode(str_replace('&quot;', '"', $data));
    
        $mail = sanitize_email($data->{'mail'});
        $message = sanitize_text_field($data->{'message'});
        $chosenMail = sanitize_email($data->{'chosenMail'});
    
        $headers = 'From: <' . $mail . '>' . "\r\n";
    
        $from = esc_attr(get_option('wb_cta_from'));
        $from_message = esc_attr(get_option('wb_cta_from_message'));
    
        $from = apply_filters('wb_cta_from', $from);
        $from_message = apply_filters('wb_cta_from_message', $from_message);
    
        $body = $from . ': ' . $mail . "\r\n" . $from_message . ': ' . "\r\n" . $message;
        
        $subject = esc_attr(get_option('wb_cta_subject'));
        $to = esc_attr($chosenMail);
    
        wp_mail( $to, $subject, $body, $headers );
        wp_die();
    }

}

/**
 * Action hooks
 *
 * @access  public
 * @since   1.0.0
 */
function wd_snc_ajax_actions() {
    $wd_snc_ajax_class = new WD_Snc_Ajax_Class();

    add_action( 'wp_ajax_nopriv_wb_cta_send_mail', array($wd_snc_ajax_class, 'wb_cta_send_mail' ));
    add_action( 'wp_ajax_wb_cta_send_mail', array($wd_snc_ajax_class, 'wb_cta_send_mail' ));
}

wd_snc_ajax_actions();