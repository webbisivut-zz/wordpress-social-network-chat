<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WB_Cta_Buttons_Class {
    
    /**
	 * Constructor function
	 * @access  public
	 * @since   1.0.0
	 */
    public function __construct() {
        add_action('wp_footer', array($this, 'wb_cta_buttons_function'));

        $add_social_btn_to_product_page = esc_attr(get_option('wb_cta_woocommerce_support'));

        if($add_social_btn_to_product_page == 'before_add_to_cart') {
            add_action( 'woocommerce_before_add_to_cart_button', array($this, 'social_network_chat_before_add_to_cart'), 10 );
        } else if($add_social_btn_to_product_page == 'after_add_to_cart') {
            add_action( 'woocommerce_after_add_to_cart_button', array($this, 'social_network_chat_after_add_to_cart'), 10 );
        } else if($add_social_btn_to_product_page == 'before_short_description') {
            add_action( 'woocommerce_before_single_product_summary', array($this, 'social_network_chat_before_short_description'), 10 );
        } else if($add_social_btn_to_product_page == 'after_short_description') {
            add_action( 'woocommerce_before_add_to_cart_form', array($this, 'social_network_chat_before_add_to_cart_form'), 10 );
        }

        // Shortcode
        add_shortcode( 'social-network-chat', array($this, 'social_network_chat_function'), 10 );
        		
		// Gutenberg blocks
		add_action( 'init', array( $this, 'register_gutenberg_blocks' ), 10 );
    }

    /**
	 * Shortcode
	 * @access  public
	 * @since   1.0.0
	 */
    public function social_network_chat_function () {
        ob_start();

        $contactText = 'Contact us for more info!';
        $contactText = esc_attr(get_option('wb_cta_shortcode_btn_text'));

        $contactText = apply_filters('wb_cta_input_contact_text', $contactText);
        
        $wb_cta_buttons_class = new WB_Cta_Buttons_Class();
        $btns = $wb_cta_buttons_class->getButtons();

        $generate_id = rand(1111, 99999);
        $set_id = 'id_' . $generate_id;

        echo '<div class="wb_cta_btn_chat_shortcode_wrap">';
            echo '<div id="wrap_id_' . $generate_id . '" class="wb_cta_contact_buttons_shortcode_wrap">';
                echo $btns;
            echo '</div>';
        
            echo '<div class="wb_cta_btn_chat_shortcode_buttons_wrap">';
                echo '<div class="wb_cta_btn_chat_shortcode" id="' . $set_id . '">';
                    echo '<div class="wb_cta_icon_shortcode"><i class="fas fa-comment-dots wb_cta_i"></i> ' . $contactText . '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

        $clean_variable = ob_get_clean();
		return $clean_variable;
    }


	/**
	 * Gutenberg blocks.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function register_gutenberg_blocks() {
		if ( ! function_exists( 'register_block_type' ) ) {
			// Gutenberg is not active.
			return;
        }

		wp_register_script( 'wd_social_network_chat-gutenberg-shortcode', esc_url( plugin_dir_url(__FILE__) ) . '../assets/js/gutenberg_shortcode.min.js', array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
		wp_enqueue_script( 'wd_social_network_chat-gutenberg-shortcode' );

		register_block_type(
			'wd-social-network-chat-pro-dev/wd-social-network-chat-pro', 
			array(
                'editor_script' => 'social-network-chat'
			) 
		);
	}
    
    /**
	 * Footer hook
	 * @access  public
	 * @since   1.0.0
	 */
    public function wb_cta_buttons_function() {
        $visible_on_hover = esc_attr(sanitize_text_field(get_option('wb_cta_visible_on_hover')));
        $popup_notice = esc_attr(get_option('wb_cta_popup_notice'));

        $activate_the_plugin = $this->activatePlugin();

		if($activate_the_plugin) {
            echo '<div id="wb_cta_wrap">';
            echo '<div id="wb_cta_wrap_relative">';

            if($visible_on_hover == 'false' && $popup_notice == 'true') {
                $message = esc_attr(sanitize_text_field(get_option('wb_cta_popup_message')));
                $message = apply_filters('wb_cta_popup_message', $message);
            
                echo '<div class="social-network-speech-bubble">';
                    echo '<div class="social-network-speech-bubble-inner">';
                        echo '<div class="wb_cta_close_bubble">x</div>';
                        echo $message;
                    echo '</div>';
                echo '</div>';
            }

            echo $this->getButtons();
            echo '</div>';   

            if($visible_on_hover == 'true' || $visible_on_hover == '') {
                echo '<div id="wb_cta_wrap_relative2">';

                    $message = esc_attr(sanitize_text_field(get_option('wb_cta_popup_message')));
                    $message = apply_filters('wb_cta_popup_message', $message);

                    if($popup_notice == 'true') {
                        echo '<div class="social-network-speech-bubble">';
                            echo '<div class="social-network-speech-bubble-inner">';
                                echo '<div class="wb_cta_close_bubble">x</div>';
                                echo $message;
                            echo '</div>';
                        echo '</div>';
                    }
                    
                    echo '<div class="wb_cta_btn_chat" id="wb_cta_chat">';
                        echo '<div id="open_cta_chat" class="wb_cta_icon"><i class="fas fa-comment-dots wb_cta_i"></i></div>';
                    echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
            
                
            $this->getWhatsAppForm();
            $this->getLineForm();
            $this->getTelegramForm();
            $this->getSkypeForm();
            $this->getViberForm();
            $this->getFacebookForm();
            $this->getVkontakteForm();
            $this->getPhoneForm();
            $this->getCustomForm();

            $this->getEmailForm();
            echo '</div>';
		}
    }

    /**
	 * Email Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getEmailForm() {
        $email_header = esc_attr(sanitize_text_field(get_option('wb_cta_email_header')));
        $email_header = apply_filters('wb_cta_input_email_header', $email_header);
        
        $success = esc_attr(sanitize_text_field(get_option('wb_cta_thankyou')));
        $error = esc_attr(sanitize_text_field(get_option('wb_cta_error')));
    
        $success = apply_filters('wb_cta_thankyou', $success);
        $error = apply_filters('wb_cta_error', $error);

        $email_text = esc_attr(sanitize_text_field(get_option('wb_cta_form_email')));
        $message = esc_attr(sanitize_text_field(get_option('wb_cta_form_message')));
        $submit = esc_attr(sanitize_text_field(get_option('wb_cta_form_submit')));
    
        $email_text = apply_filters('wb_cta_input_email', $email_text);
        $message = apply_filters('wb_cta_input_message', $message);
        $submit = apply_filters('wb_cta_input_submit', $submit);

        if($email_header == '') {
            $email_header = 'Contact us';
        }

        if($success == '') {
            $success = 'Thank you for your message!';
        }  

        if($error == '') {
            $error = 'Email is incorrect';
        }

        if($email_text == '') {
            $email_text = 'Email*';
        }

        if($message == '') {
            $message = 'Message*';
        }

        if($submit == '') {
            $submit = 'Submit';
        }

        $email = esc_attr(sanitize_email(get_option('wb_cta_email')));
        $email2 = esc_attr(sanitize_email(get_option('wb_cta_email2')));
        $email3 = esc_attr(sanitize_email(get_option('wb_cta_email3')));
        
        $email_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_email_box_agent')));
        $email_box_agent_title = esc_attr(sanitize_text_field(get_option('wb_cta_email_box_agent_title')));
        $email_box_agent_img = esc_attr(get_option('wb_cta_email_box_agent_img'));

        if($email_box_agent_img == '') {
            $email_box_agent_img_url = array(esc_url( plugins_url( '../assets/img/user_placeholder.jpeg', __FILE__ ) ));
        } else {
            $email_box_agent_img_url = wp_get_attachment_image_src($email_box_agent_img);
        }
        
        $email_box_agent2 = esc_attr(sanitize_text_field(get_option('wb_cta_email_box_agent2')));
        $email_box_agent_title2 = esc_attr(sanitize_text_field(get_option('wb_cta_email_box_agent_title2')));
        $email_box_agent_img2 = esc_attr(get_option('wb_cta_email_box_agent_img2'));

        if($email_box_agent_img2 == '') {
            $email_box_agent_img_url2 = array(esc_url( plugins_url( '../assets/img/user_placeholder.jpeg', __FILE__ ) ));
        } else {
            $email_box_agent_img_url2 = wp_get_attachment_image_src($email_box_agent_img2);
        }
        
        $email_box_agent3 = esc_attr(sanitize_text_field(get_option('wb_cta_email_box_agent3')));
        $email_box_agent_title3 = esc_attr(sanitize_text_field(get_option('wb_cta_email_box_agent_title3')));
        $email_box_agent_img3 = esc_attr(get_option('wb_cta_email_box_agent_img3'));

        if($email_box_agent_img3 == '') {
            $email_box_agent_img_url3 = array(esc_url( plugins_url( '../assets/img/user_placeholder.jpeg', __FILE__ ) ));
        } else {
            $email_box_agent_img_url3 = wp_get_attachment_image_src($email_box_agent_img3);
        }

        $url = "mailto:";

        $html = '<div class="wb_cta_email_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_email_message_window_header"><i class="fas fa-envelope wb_cta_i"></i>&nbsp;';
            $html .= $email_header;
                $html .= '<div class="wb_cta_email_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_email_message_window_wrap">';

                if($email_box_agent != '') {
                    $html .= '<div class="wb_cta_email_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_email_col_1">';
                            $html .= '<div class="smc_email_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $email_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_email_col_2">';
                            $html .= '<div class="smc_email_name_wrap">';
                                $html .= '<div class="smc_email_box_agent_name"> ' . $email_box_agent . ' </div>';
                                $html .= '<div class="smc_email_box_agent_title"> ' . $email_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_email_col_3">';
                            $html .= '<div class="smc_email_box_agent_icon"><i class="fas fa-envelope wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($email2 != '') {
                    $html .= '<div class="wb_cta_email_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_email_col_1">';
                            $html .= '<div class="smc_email_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $email_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_email_col_2">';
                            $html .= '<div class="smc_email_name_wrap">';
                                $html .= '<div class="smc_email_box_agent_name"> ' . $email_box_agent2 . ' </div>';
                                $html .= '<div class="smc_email_box_agent_title"> ' . $email_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_email_col_3">';
                            $html .= '<div class="smc_email_box_agent_icon"><i class="fas fa-envelope wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($email3 != '') {
                    $html .= '<div class="wb_cta_email_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_email_col_1">';
                            $html .= '<div class="smc_email_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $email_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_email_col_2">';
                            $html .= '<div class="smc_email_name_wrap">';
                                $html .= '<div class="smc_email_box_agent_name"> ' . $email_box_agent3 . ' </div>';
                                $html .= '<div class="smc_email_box_agent_title"> ' . $email_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_email_col_3">';
                            $html .= '<div class="smc_email_box_agent_icon"><i class="fas fa-envelope wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                $html .= '<div id="wb_cta_input_form_wrap">';
                    $html .= '<input id="wb_cta_input_mail" class="wb_cta_input" placeholder="' . $email_text . '">';
                    $html .= '<textarea id="wb_cta_input_textarea" class="wb_cta_input" placeholder="' . $message . '"></textarea>';
                    $html .= '<div class="wb_cta_input_email_submit">' . $submit . '</div>';
                    $html .= '<div class="wb_cta_error_in_email">' . $error . '</div>';
                    $html .= '<div class="wb_cta_success">' . $success . '</div>';
                    $html .= '<div class="wb_cta_loader"></div>';
                $html .= '</div>';
            
                $html .= '<form>';
                    $html .= '<input type="hidden" id="snc_email_name" name="email" value="' . $email . '">';
                    $html .= '<input type="hidden" id="snc_email_name2" name="email2" value="' . $email2 . '">';
                    $html .= '<input type="hidden" id="snc_email_name3" name="email3" value="' . $email3 . '">';
                    $html .= '<input type="hidden" id="snc_email_chosen_agent" name="snc_email_chosen_agent">';
                    $html .= '<input type="hidden" id="snc_email_url" name="url" value="' . $url . '">';
                    $html .= '<input type="hidden" id="snc_email_quickchat" name="email3" value="true">';
                $html .= '</form>';

            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * Channel Buttons
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getButtons($visible_on_hover = false) {
        $whatsapp = esc_attr(sanitize_text_field(get_option('wb_cta_whatsapp')));
        $line = esc_attr(sanitize_text_field(get_option('wb_cta_line')));
        $telegram = esc_attr(sanitize_text_field(get_option('wb_cta_telegram')));
        $skype = esc_attr(sanitize_text_field(get_option('wb_cta_skype')));
        $facebook = esc_attr(sanitize_text_field(get_option('wb_cta_facebook')));
        $vk = esc_attr(sanitize_text_field(get_option('wb_cta_vk')));
        $viber = esc_attr(sanitize_text_field(get_option('wb_cta_viber')));
        $custom = esc_attr(sanitize_text_field(get_option('wb_cta_custom_url')));
        $custom_icon = esc_attr(sanitize_text_field(get_option('wb_cta_custom_icon')));

        if($custom_icon == '') {
            $custom_icon = 'fas fa-location-arrow';
        }
        
        $phone = esc_attr(sanitize_text_field(get_option('wb_cta_phone')));
        $email = esc_attr(sanitize_email(get_option('wb_cta_email')));

        $proActive = true;
        
        ob_start();
        $html = '';
        
        if($whatsapp != '') { 
            $whatsapp_box = esc_attr(sanitize_text_field(get_option('wb_cta_whatsapp_box')));
            $whatsapp_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_whatsapp_box_agent')));
            $whatsapp2 = esc_attr(sanitize_text_field(get_option('wb_cta_whatsapp2')));
            $whatsapp3 = esc_attr(sanitize_text_field(get_option('wb_cta_whatsapp3')));

            if(wp_is_mobile()) {
                if($whatsapp_box == 'true' OR $whatsapp_box_agent != '' && $proActive != '' OR $whatsapp2 != '' && $proActive != '' OR $whatsapp3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_whatsapp">';
                        $html .= '<span class="scs_open_whatsapp_chatbox"><div class="wb_cta_icon"><i class="fab fa-whatsapp wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_whatsapp">';
                     $html .= '<a target="_blank" href="https://wa.me/' . $whatsapp . '"><div class="wb_cta_icon"><i class="fab fa-whatsapp wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            } else {
                if($whatsapp_box == 'true' OR $whatsapp_box_agent != '' && $proActive != '' OR $whatsapp2 != '' && $proActive != '' OR $whatsapp3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_whatsapp">';
                        $html .= '<span class="scs_open_whatsapp_chatbox"><div class="wb_cta_icon"><i class="fab fa-whatsapp wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_whatsapp">';
                        $html .= '<a target="_blank" href="https://web.whatsapp.com/send?phone=' . $whatsapp . '"><div class="wb_cta_icon"><i class="fab fa-whatsapp wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            }
        }
        
        if($line != '') { 
            $line_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_line_box_agent')));
            $line2 = esc_attr(sanitize_text_field(get_option('wb_cta_line2')));
            $line3 = esc_attr(sanitize_text_field(get_option('wb_cta_line3')));

            if(wp_is_mobile()) {
                if($line_box_agent != '' && $proActive != '' OR $line2 != '' && $proActive != '' OR $line3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_line">';
                        $html .= '<span class="scs_open_line_chatbox"><div class="wb_cta_icon"><i class="fab fa-line wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_line">';
                        $html .= '<a target="_blank" href="https://line.me/R/ti/p/' . $line . '"><div class="wb_cta_icon"><i class="fab fa-line wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                } 
            } else {
                if($line_box_agent != '' && $proActive != '' OR $line2 != '' && $proActive != '' OR $line3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_line">';
                        $html .= '<span class="scs_open_line_chatbox"><div class="wb_cta_icon"><i class="fab fa-line wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_line">';
                        $html .= '<a target="_blank" href="https://line.me/R/ti/p/' . $line . '"><div class="wb_cta_icon"><i class="fab fa-line wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            }
        }
        
        if($telegram != '') {
            $telegram_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_telegram_box_agent')));
            $telegram2 = esc_attr(sanitize_text_field(get_option('wb_cta_telegram2')));
            $telegram3 = esc_attr(sanitize_text_field(get_option('wb_cta_telegram3')));

            if(wp_is_mobile()) {
                if($telegram_box_agent != '' && $proActive != '' OR $telegram2 != '' && $proActive != '' OR $telegram3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_telegram">';
                        $html .= '<span class="scs_open_telegram_chatbox"><div class="wb_cta_icon"><i class="fab fa-telegram wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_telegram">';
                        $html .= '<a target="_blank" href="https://t.me/' . $telegram . '"><div class="wb_cta_icon"><i class="fab fa-telegram wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            } else {
                if($telegram_box_agent != '' && $proActive != '' OR $telegram2 != '' && $proActive != '' OR $telegram3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_telegram">';
                        $html .= '<span class="scs_open_telegram_chatbox"><div class="wb_cta_icon"><i class="fab fa-telegram wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_telegram">';
                        $html .= '<a target="_blank" href="https://web.telegram.im/?p=@' . $telegram . '"><div class="wb_cta_icon"><i class="fab fa-telegram wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            }
        }
        
        if($skype != '') { 
            $skype_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_skype_box_agent')));
            $skype2 = esc_attr(sanitize_text_field(get_option('wb_cta_skype2')));
            $skype3 = esc_attr(sanitize_text_field(get_option('wb_cta_skype3')));

            if(wp_is_mobile()) {
                if($skype_box_agent != '' && $proActive != '' OR $skype2 != '' && $proActive != '' OR $skype3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_skype">';
                        $html .= '<span class="scs_open_skype_chatbox"><div class="wb_cta_icon"><i class="fab fa-skype wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_skype">';
                        $html .= '<a target="_blank" href="skype:' . $skype . '?chat' . '"><div class="wb_cta_icon"><i class="fab fa-skype wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            } else {
                if($skype_box_agent != '' && $proActive != '' OR $skype2 != '' && $proActive != '' OR $skype3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_skype">';
                        $html .= '<span class="scs_open_skype_chatbox"><div class="wb_cta_icon"><i class="fab fa-skype wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_skype">';
                        $html .= '<a target="_blank" href="skype:' . $skype . '?chat' . '"><div class="wb_cta_icon"><i class="fab fa-skype wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            }
        }
        
        if($facebook != '') {
            $facebook_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_facebook_box_agent')));
            $facebook2 = esc_attr(sanitize_text_field(get_option('wb_cta_facebook2')));
            $facebook3 = esc_attr(sanitize_text_field(get_option('wb_cta_facebook3')));

            if(wp_is_mobile()) {
                if($facebook_box_agent != '' && $proActive != '' OR $facebook2 != '' && $proActive != '' OR $facebook3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_facebook">';
                        $html .= '<span class="scs_open_facebook_chatbox"><div class="wb_cta_icon"><i class="fab fa-facebook wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_facebook">';
                        $html .= '<a target="_blank" href="https://m.me/' . $facebook . '"><div class="wb_cta_icon"><i class="fab fa-facebook-messenger wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            } else {
                if($facebook_box_agent != '' && $proActive != '' OR $facebook2 != '' && $proActive != '' OR $facebook3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_facebook">';
                        $html .= '<span class="scs_open_facebook_chatbox"><div class="wb_cta_icon"><i class="fab fa-facebook wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_facebook">';
                        $html .= '<a target="_blank" href="https://m.me/' . $facebook .'"><div class="wb_cta_icon"><i class="fab fa-facebook-messenger wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            }
        }
        
        if($vk != '') {
            $vkontakte_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_vkontakte_box_agent')));
            $vkontakte2 = esc_attr(sanitize_text_field(get_option('wb_cta_vkontakte2')));
            $vkontakte3 = esc_attr(sanitize_text_field(get_option('wb_cta_vkontakte3')));

            if(wp_is_mobile()) {
                if($vkontakte_box_agent != '' && $proActive != '' OR $vkontakte2 != ''&& $proActive != ''  OR $vkontakte3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_vkontakte">';
                        $html .= '<span class="scs_open_vkontakte_chatbox"><div class="wb_cta_icon"><i class="fab fa-vk wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_vk">';
                        $html .= '<a target="_blank" href="https://vk.me/' . $vk . '"><div class="wb_cta_icon"><i class="fab fa-vk wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            } else {
                if($vkontakte_box_agent != '' && $proActive != '' OR $vkontakte2 != '' && $proActive != '' OR $vkontakte3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_vkontakte">';
                        $html .= '<span class="scs_open_vkontakte_chatbox"><div class="wb_cta_icon"><i class="fab fa-vk wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_vk">';
                        $html .= '<a target="_blank" href="https://vk.me/' . $vk .'"><div class="wb_cta_icon"><i class="fab fa-vk wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            }
        }
        
        if($viber != '') { 
            $viber_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_viber_box_agent')));
            $viber2 = esc_attr(sanitize_text_field(get_option('wb_cta_viber2')));
            $viber3 = esc_attr(sanitize_text_field(get_option('wb_cta_viber3')));

            if(wp_is_mobile()) {
                if($viber_box_agent != '' && $proActive != '' OR $viber2 != '' && $proActive != '' OR $viber3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_viber">';
                        $html .= '<span class="scs_open_viber_chatbox"><div class="wb_cta_icon"><i class="fab fa-viber wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_viber">';
                        $html .= '<a target="_blank" href="viber://chat?number=' . $viber . '"><div class="wb_cta_icon"><i class="fab fa-viber wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            } else {
                if($viber_box_agent != '' && $proActive != '' OR $viber2 != '' && $proActive != '' OR $viber3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_viber">';
                        $html .= '<span class="scs_open_viber_chatbox"><div class="wb_cta_icon"><i class="fab fa-viber wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_viber">';
                        $html .= '<a target="_blank" href="viber://chat?number=' . $viber .'"><div class="wb_cta_icon"><i class="fab fa-viber wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            }
        }
        
        if($custom != '') {
            $custom_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_custom_box_agent')));
            $custom2 = esc_attr(sanitize_text_field(get_option('wb_cta_custom2')));
            $custom3 = esc_attr(sanitize_text_field(get_option('wb_cta_custom3')));

            $custom_icon = esc_attr(sanitize_text_field(get_option('wb_cta_custom_icon')));

            if(wp_is_mobile()) {
                if($custom_box_agent != '' && $proActive != '' OR $custom2 != '' && $proActive != '' OR $custom3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_custom">';
                        $html .= '<span class="scs_open_custom_chatbox"><div class="wb_cta_icon"><i class="' . $custom_icon . ' wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_custom">';
                        $html .= '<a target="_blank" href="' . $custom . '"><div class="wb_cta_icon"><i class="' . $custom_icon . ' wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            } else {
                if($custom_box_agent != '' && $proActive != '' OR $custom2 != '' && $proActive != '' OR $custom3 != '' && $proActive != '') {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_custom">';
                        $html .= '<span class="scs_open_custom_chatbox"><div class="wb_cta_icon"><i class="' . $custom_icon . ' wb_cta_i"></i></div></span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="wb_cta_btn" id="wb_cta_custom">';
                        $html .= '<a target="_blank" href="' . $custom .'"><div class="wb_cta_icon"><i class=" ' . $custom_icon . ' wb_cta_i"></i></div></a>';
                    $html .= '</div>';
                }
            }
        }
        
        if($phone != '') {
            $phone_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_phone_box_agent')));
            $phone2 = esc_attr(sanitize_text_field(get_option('wb_cta_phone2')));
            $phone3 = esc_attr(sanitize_text_field(get_option('wb_cta_phone3')));

            if($phone_box_agent != '' && $proActive != '' OR $phone2 != '' && $proActive != '' OR $phone3 != '' && $proActive != '') {
                $html .= '<div class="wb_cta_btn" id="wb_cta_phone">';
                    $html .= '<span class="scs_open_phone_chatbox"><div class="wb_cta_icon"><i class="fas fa-phone-square wb_cta_i"></i></div></span>';
                $html .= '</div>';
            } else {
                $html .= '<div class="wb_cta_btn" id="wb_cta_phone">';
                    $html .= '<a href="tel:' . $phone . '"><div class="wb_cta_icon"><i class="fas fa-phone-square wb_cta_i"></i></div></a>';
                $html .= '</div>';
            }
            
        }
        
        if($email != '') {
            $email_box_agent = esc_attr(sanitize_text_field(get_option('wb_cta_email_box_agent')));
            $email2 = esc_attr(sanitize_text_field(get_option('wb_cta_email2')));
            $email3 = esc_attr(sanitize_text_field(get_option('wb_cta_email3')));

            $email_box = esc_attr(sanitize_textarea_field(get_option('wb_cta_email_box')));

            if($email_box_agent != '' OR $email2 != '' OR $email3 != '' OR $email_box == 'true') {
                $html .= '<div class="wb_cta_btn" id="wb_cta_email">';
                    $html .= '<span class="scs_open_email_chatbox"><div class="wb_cta_icon"><i class="fas fa-envelope wb_cta_i"></i></div></span>';
                $html .= '</div>';
            } else {
                $html .= '<div class="wb_cta_btn" id="wb_cta_email">';
                    $html .= '<a href="mailto:' . $email . '"><div class="wb_cta_icon"><i class="fas fa-envelope wb_cta_i"></i></div></a>';
                $html .= '</div>';
            }
            
        }

        $html .= ob_get_clean();

        return $html;
    }

    /**
	 * WooCommerce chat button
	 * @access  public
	 * @since   1.0.0
	 */
    public function social_network_chat_before_add_to_cart () {
        echo do_shortcode('[social-network-chat]');
    }
 
    /**
	 * WooCommerce chat button
	 * @access  public
	 * @since   1.0.0
	 */
    public function social_network_chat_after_add_to_cart () {
        echo do_shortcode('[social-network-chat]');
    }
 
    /**
	 * WooCommerce chat button
	 * @access  public
	 * @since   1.0.0
	 */
    public function social_network_chat_before_add_to_cart_form () {
        echo do_shortcode('[social-network-chat]');
    }
 
    /**
	 * WooCommerce chat button
	 * @access  public
	 * @since   1.0.0
	 */
    public function social_network_chat_before_short_description () {
        echo do_shortcode('[social-network-chat]');
    }

    /**
	 * WhatsApp Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getWhatsAppForm() {   
        $whatsapp_message = esc_attr(get_option('wb_cta_whatsapp_message'));
        $whatsapp_message = apply_filters('wb_cta_input_whatsapp_message', $whatsapp_message);
        
        $whatsapp_header = esc_attr(get_option('wb_cta_whatsapp_header'));
        $whatsapp_header = apply_filters('wb_cta_input_whatsapp_header', $whatsapp_header);
        
        $whatsapp_submit = esc_attr(get_option('wb_cta_whatsapp_submit'));
        $whatsapp_submit = apply_filters('wb_cta_input_whatsapp_submit', $whatsapp_submit);

        $whatsapp = esc_attr(get_option('wb_cta_whatsapp'));
        $whatsapp2 = esc_attr(get_option('wb_cta_whatsapp2'));
        $whatsapp3 = esc_attr(get_option('wb_cta_whatsapp3'));

        $whatsapp_box = esc_attr(get_option('wb_cta_whatsapp_box'));
        
        $whatsapp_box_agent = esc_attr(get_option('wb_cta_whatsapp_box_agent'));
        $whatsapp_box_agent_title = esc_attr(get_option('wb_cta_whatsapp_box_agent_title'));
        $whatsapp_box_agent_img = esc_attr(get_option('wb_cta_whatsapp_box_agent_img'));

        if($whatsapp_box_agent_img == '') {
            $whatsapp_box_agent_img_url = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $whatsapp_box_agent_img_url = wp_get_attachment_image_src($whatsapp_box_agent_img);
        }
        
        $whatsapp_box_agent2 = esc_attr(get_option('wb_cta_whatsapp_box_agent2'));
        $whatsapp_box_agent_title2 = esc_attr(get_option('wb_cta_whatsapp_box_agent_title2'));
        $whatsapp_box_agent_img2 = esc_attr(get_option('wb_cta_whatsapp_box_agent_img2'));

        if($whatsapp_box_agent_img2 == '') {
            $whatsapp_box_agent_img_url2 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $whatsapp_box_agent_img_url2 = wp_get_attachment_image_src($whatsapp_box_agent_img2);
        }
        
        $whatsapp_box_agent3 = esc_attr(get_option('wb_cta_whatsapp_box_agent3'));
        $whatsapp_box_agent_title3 = esc_attr(get_option('wb_cta_whatsapp_box_agent_title3'));
        $whatsapp_box_agent_img3 = esc_attr(get_option('wb_cta_whatsapp_box_agent_img3'));

        if($whatsapp_box_agent_img3 == '') {
            $whatsapp_box_agent_img_url3 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $whatsapp_box_agent_img_url3 = wp_get_attachment_image_src($whatsapp_box_agent_img3);
        }

        if(wp_is_mobile()) {
            $url = "https://wa.me/";
        } else {
            $url = "https://web.whatsapp.com/send";
        }

        $html = '<div class="wb_cta_whatsapp_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_whatsapp_message_window_header"><i class="fab fa-whatsapp wb_cta_i"></i>&nbsp;';
            $html .= $whatsapp_header;
                $html .= '<div class="wb_cta_whatsapp_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_whatsapp_message_window_wrap">';

                if($whatsapp_box_agent != '') {
                    $html .= '<div class="wb_cta_whatsapp_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_whatsapp_col_1">';
                            $html .= '<div class="smc_whatsapp_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $whatsapp_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_whatsapp_col_2">';
                            $html .= '<div class="smc_whatsapp_name_wrap">';
                                $html .= '<div class="smc_whatsapp_box_agent_name"> ' . $whatsapp_box_agent . ' </div>';
                                $html .= '<div class="smc_whatsapp_box_agent_title"> ' . $whatsapp_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_whatsapp_col_3">';
                            $html .= '<div class="smc_whatsapp_box_agent_icon"><i class="fab fa-whatsapp wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($whatsapp2 != '') {
                    $html .= '<div class="wb_cta_whatsapp_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_whatsapp_col_1">';
                            $html .= '<div class="smc_whatsapp_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $whatsapp_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_whatsapp_col_2">';
                            $html .= '<div class="smc_whatsapp_name_wrap">';
                                $html .= '<div class="smc_whatsapp_box_agent_name"> ' . $whatsapp_box_agent2 . ' </div>';
                                $html .= '<div class="smc_whatsapp_box_agent_title"> ' . $whatsapp_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_whatsapp_col_3">';
                            $html .= '<div class="smc_whatsapp_box_agent_icon"><i class="fab fa-whatsapp wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($whatsapp3 != '') {
                    $html .= '<div class="wb_cta_whatsapp_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_whatsapp_col_1">';
                            $html .= '<div class="smc_whatsapp_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $whatsapp_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_whatsapp_col_2">';
                            $html .= '<div class="smc_whatsapp_name_wrap">';
                                $html .= '<div class="smc_whatsapp_box_agent_name"> ' . $whatsapp_box_agent3 . ' </div>';
                                $html .= '<div class="smc_whatsapp_box_agent_title"> ' . $whatsapp_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_whatsapp_col_3">';
                            $html .= '<div class="smc_whatsapp_box_agent_icon"><i class="fab fa-whatsapp wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            
                $html .= '<form>';
                $html .= '<input type="hidden" id="snc_whatsapp_name" name="phone" value="' . $whatsapp . '">';
                $html .= '<input type="hidden" id="snc_whatsapp_name2" name="phone2" value="' . $whatsapp2 . '">';
                $html .= '<input type="hidden" id="snc_whatsapp_name3" name="phone3" value="' . $whatsapp3 . '">';
                $html .= '<input type="hidden" id="snc_whatsapp_chosen_agent" name="snc_whatsapp_chosen_agent">';
                $html .= '<input type="hidden" id="snc_whatsapp_url" name="url" value="' . $url . '">';
                
                if($whatsapp_box == 'true') {
                    $html .= '<textarea name="text" id="wb_cta_input_whatsapp_textarea" class="wb_cta_whatsapp_input" placeholder="' . $whatsapp_message . '"></textarea>';
                    $html .= '<div id="snc_whatsapp_submit" class="wb_cta_input_whatsapp_submit">' . $whatsapp_submit . '</div>';
                } else {
                    $html .= '<input type="hidden" id="snc_whatsapp_quickchat" name="phone3" value="true">';
                }
                
                $html .= '</form>';
            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * LINE Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getLineForm() {
        $line_header = esc_attr(get_option('wb_cta_line_header'));
        $line_header = apply_filters('wb_cta_input_line_header', $line_header);

        $line = esc_attr(get_option('wb_cta_line'));
        $line2 = esc_attr(get_option('wb_cta_line2'));
        $line3 = esc_attr(get_option('wb_cta_line3'));
        
        $line_box_agent = esc_attr(get_option('wb_cta_line_box_agent'));
        $line_box_agent_title = esc_attr(get_option('wb_cta_line_box_agent_title'));
        $line_box_agent_img = esc_attr(get_option('wb_cta_line_box_agent_img'));

        if($line_box_agent_img == '') {
            $line_box_agent_img_url = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $line_box_agent_img_url = wp_get_attachment_image_src($line_box_agent_img);
        }
        
        $line_box_agent2 = esc_attr(get_option('wb_cta_line_box_agent2'));
        $line_box_agent_title2 = esc_attr(get_option('wb_cta_line_box_agent_title2'));
        $line_box_agent_img2 = esc_attr(get_option('wb_cta_line_box_agent_img2'));

        if($line_box_agent_img2 == '') {
            $line_box_agent_img_url2 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $line_box_agent_img_url2 = wp_get_attachment_image_src($line_box_agent_img2);
        }
        
        $line_box_agent3 = esc_attr(get_option('wb_cta_line_box_agent3'));
        $line_box_agent_title3 = esc_attr(get_option('wb_cta_line_box_agent_title3'));
        $line_box_agent_img3 = esc_attr(get_option('wb_cta_line_box_agent_img3'));

        if($line_box_agent_img3 == '') {
            $line_box_agent_img_url3 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $line_box_agent_img_url3 = wp_get_attachment_image_src($line_box_agent_img3);
        }

        if(wp_is_mobile()) {
            //$url = "line://ti/p/";
            $url = "https://line.me/R/ti/p/";
        } else {
            $url = "https://line.me/R/ti/p/";
        }

        $html = '<div class="wb_cta_line_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_line_message_window_header"><i class="fab fa-line wb_cta_i"></i>&nbsp;';
            $html .= $line_header;
                $html .= '<div class="wb_cta_line_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_line_message_window_wrap">';

                if($line_box_agent != '') {
                    $html .= '<div class="wb_cta_line_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_line_col_1">';
                            $html .= '<div class="smc_line_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $line_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_line_col_2">';
                            $html .= '<div class="smc_line_name_wrap">';
                                $html .= '<div class="smc_line_box_agent_name"> ' . $line_box_agent . ' </div>';
                                $html .= '<div class="smc_line_box_agent_title"> ' . $line_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_line_col_3">';
                            $html .= '<div class="smc_line_box_agent_icon"><i class="fab fa-line wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($line2 != '') {
                    $html .= '<div class="wb_cta_line_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_line_col_1">';
                            $html .= '<div class="smc_line_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $line_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_line_col_2">';
                            $html .= '<div class="smc_line_name_wrap">';
                                $html .= '<div class="smc_line_box_agent_name"> ' . $line_box_agent2 . ' </div>';
                                $html .= '<div class="smc_line_box_agent_title"> ' . $line_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_line_col_3">';
                            $html .= '<div class="smc_line_box_agent_icon"><i class="fab fa-line wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($line3 != '') {
                    $html .= '<div class="wb_cta_line_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_line_col_1">';
                            $html .= '<div class="smc_line_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $line_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_line_col_2">';
                            $html .= '<div class="smc_line_name_wrap">';
                                $html .= '<div class="smc_line_box_agent_name"> ' . $line_box_agent3 . ' </div>';
                                $html .= '<div class="smc_line_box_agent_title"> ' . $line_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_line_col_3">';
                            $html .= '<div class="smc_line_box_agent_icon"><i class="fab fa-line wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            
                $html .= '<form>';
                $html .= '<input type="hidden" id="snc_line_name" name="phone" value="' . $line . '">';
                $html .= '<input type="hidden" id="snc_line_name2" name="phone2" value="' . $line2 . '">';
                $html .= '<input type="hidden" id="snc_line_name3" name="phone3" value="' . $line3 . '">';
                $html .= '<input type="hidden" id="snc_line_chosen_agent" name="snc_line_chosen_agent">';
                $html .= '<input type="hidden" id="snc_line_url" name="url" value="' . $url . '">';
                $html .= '<input type="hidden" id="snc_line_quickchat" name="phone3" value="true">';
                
                $html .= '</form>';
            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * Telegram Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getTelegramForm() {
        $telegram_header = esc_attr(get_option('wb_cta_telegram_header'));
        $telegram_header = apply_filters('wb_cta_input_telegram_header', $telegram_header);

        $telegram = esc_attr(get_option('wb_cta_telegram'));
        $telegram2 = esc_attr(get_option('wb_cta_telegram2'));
        $telegram3 = esc_attr(get_option('wb_cta_telegram3'));
        
        $telegram_box_agent = esc_attr(get_option('wb_cta_telegram_box_agent'));
        $telegram_box_agent_title = esc_attr(get_option('wb_cta_telegram_box_agent_title'));
        $telegram_box_agent_img = esc_attr(get_option('wb_cta_telegram_box_agent_img'));

        if($telegram_box_agent_img == '') {
            $telegram_box_agent_img_url = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $telegram_box_agent_img_url = wp_get_attachment_image_src($telegram_box_agent_img);
        }
        
        $telegram_box_agent2 = esc_attr(get_option('wb_cta_telegram_box_agent2'));
        $telegram_box_agent_title2 = esc_attr(get_option('wb_cta_telegram_box_agent_title2'));
        $telegram_box_agent_img2 = esc_attr(get_option('wb_cta_telegram_box_agent_img2'));

        if($telegram_box_agent_img2 == '') {
            $telegram_box_agent_img_url2 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $telegram_box_agent_img_url2 = wp_get_attachment_image_src($telegram_box_agent_img2);
        }
        
        $telegram_box_agent3 = esc_attr(get_option('wb_cta_telegram_box_agent3'));
        $telegram_box_agent_title3 = esc_attr(get_option('wb_cta_telegram_box_agent_title3'));
        $telegram_box_agent_img3 = esc_attr(get_option('wb_cta_telegram_box_agent_img3'));

        if($telegram_box_agent_img3 == '') {
            $telegram_box_agent_img_url3 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $telegram_box_agent_img_url3 = wp_get_attachment_image_src($telegram_box_agent_img3);
        }

        if(wp_is_mobile()) {
            $url = "https://t.me/";
        } else {
            $url = "https://web.telegram.org/?p=@";
        }

        $html = '<div class="wb_cta_telegram_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_telegram_message_window_header"><i class="fab fa-telegram wb_cta_i"></i>&nbsp;';
            $html .= $telegram_header;
                $html .= '<div class="wb_cta_telegram_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_telegram_message_window_wrap">';

                if($telegram_box_agent != '') {
                    $html .= '<div class="wb_cta_telegram_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_telegram_col_1">';
                            $html .= '<div class="smc_telegram_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $telegram_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_telegram_col_2">';
                            $html .= '<div class="smc_telegram_name_wrap">';
                                $html .= '<div class="smc_telegram_box_agent_name"> ' . $telegram_box_agent . ' </div>';
                                $html .= '<div class="smc_telegram_box_agent_title"> ' . $telegram_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_telegram_col_3">';
                            $html .= '<div class="smc_telegram_box_agent_icon"><i class="fab fa-telegram wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($telegram2 != '') {
                    $html .= '<div class="wb_cta_telegram_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_telegram_col_1">';
                            $html .= '<div class="smc_telegram_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $telegram_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_telegram_col_2">';
                            $html .= '<div class="smc_telegram_name_wrap">';
                                $html .= '<div class="smc_telegram_box_agent_name"> ' . $telegram_box_agent2 . ' </div>';
                                $html .= '<div class="smc_telegram_box_agent_title"> ' . $telegram_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_telegram_col_3">';
                            $html .= '<div class="smc_telegram_box_agent_icon"><i class="fab fa-telegram wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($telegram3 != '') {
                    $html .= '<div class="wb_cta_telegram_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_telegram_col_1">';
                            $html .= '<div class="smc_telegram_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $telegram_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_telegram_col_2">';
                            $html .= '<div class="smc_telegram_name_wrap">';
                                $html .= '<div class="smc_telegram_box_agent_name"> ' . $telegram_box_agent3 . ' </div>';
                                $html .= '<div class="smc_telegram_box_agent_title"> ' . $telegram_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_telegram_col_3">';
                            $html .= '<div class="smc_telegram_box_agent_icon"><i class="fab fa-telegram wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            
                $html .= '<form>';
                $html .= '<input type="hidden" id="snc_telegram_name" name="phone" value="' . $telegram . '">';
                $html .= '<input type="hidden" id="snc_telegram_name2" name="phone2" value="' . $telegram2 . '">';
                $html .= '<input type="hidden" id="snc_telegram_name3" name="phone3" value="' . $telegram3 . '">';
                $html .= '<input type="hidden" id="snc_telegram_chosen_agent" name="snc_telegram_chosen_agent">';
                $html .= '<input type="hidden" id="snc_telegram_url" name="url" value="' . $url . '">';
                $html .= '<input type="hidden" id="snc_telegram_quickchat" name="phone3" value="true">';
                
                $html .= '</form>';
            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * Skype Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getSkypeForm() {
        $skype_header = esc_attr(get_option('wb_cta_skype_header'));
        $skype_header = apply_filters('wb_cta_input_skype_header', $skype_header);

        $skype = esc_attr(get_option('wb_cta_skype'));
        $skype2 = esc_attr(get_option('wb_cta_skype2'));
        $skype3 = esc_attr(get_option('wb_cta_skype3'));
        
        $skype_box_agent = esc_attr(get_option('wb_cta_skype_box_agent'));
        $skype_box_agent_title = esc_attr(get_option('wb_cta_skype_box_agent_title'));
        $skype_box_agent_img = esc_attr(get_option('wb_cta_skype_box_agent_img'));

        if($skype_box_agent_img == '') {
            $skype_box_agent_img_url = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $skype_box_agent_img_url = wp_get_attachment_image_src($skype_box_agent_img);
        }
        
        $skype_box_agent2 = esc_attr(get_option('wb_cta_skype_box_agent2'));
        $skype_box_agent_title2 = esc_attr(get_option('wb_cta_skype_box_agent_title2'));
        $skype_box_agent_img2 = esc_attr(get_option('wb_cta_skype_box_agent_img2'));

        if($skype_box_agent_img2 == '') {
            $skype_box_agent_img_url2 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $skype_box_agent_img_url2 = wp_get_attachment_image_src($skype_box_agent_img2);
        }
        
        $skype_box_agent3 = esc_attr(get_option('wb_cta_skype_box_agent3'));
        $skype_box_agent_title3 = esc_attr(get_option('wb_cta_skype_box_agent_title3'));
        $skype_box_agent_img3 = esc_attr(get_option('wb_cta_skype_box_agent_img3'));

        if($skype_box_agent_img3 == '') {
            $skype_box_agent_img_url3 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $skype_box_agent_img_url3 = wp_get_attachment_image_src($skype_box_agent_img3);
        }

        $url = "skype:";

        $html = '<div class="wb_cta_skype_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_skype_message_window_header"><i class="fab fa-skype wb_cta_i"></i>&nbsp;';
            $html .= $skype_header;
                $html .= '<div class="wb_cta_skype_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_skype_message_window_wrap">';

                if($skype_box_agent != '') {
                    $html .= '<div class="wb_cta_skype_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_skype_col_1">';
                            $html .= '<div class="smc_skype_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $skype_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_skype_col_2">';
                            $html .= '<div class="smc_skype_name_wrap">';
                                $html .= '<div class="smc_skype_box_agent_name"> ' . $skype_box_agent . ' </div>';
                                $html .= '<div class="smc_skype_box_agent_title"> ' . $skype_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_skype_col_3">';
                            $html .= '<div class="smc_skype_box_agent_icon"><i class="fab fa-skype wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($skype2 != '') {
                    $html .= '<div class="wb_cta_skype_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_skype_col_1">';
                            $html .= '<div class="smc_skype_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $skype_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_skype_col_2">';
                            $html .= '<div class="smc_skype_name_wrap">';
                                $html .= '<div class="smc_skype_box_agent_name"> ' . $skype_box_agent2 . ' </div>';
                                $html .= '<div class="smc_skype_box_agent_title"> ' . $skype_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_skype_col_3">';
                            $html .= '<div class="smc_skype_box_agent_icon"><i class="fab fa-skype wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($skype3 != '') {
                    $html .= '<div class="wb_cta_skype_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_skype_col_1">';
                            $html .= '<div class="smc_skype_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $skype_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_skype_col_2">';
                            $html .= '<div class="smc_skype_name_wrap">';
                                $html .= '<div class="smc_skype_box_agent_name"> ' . $skype_box_agent3 . ' </div>';
                                $html .= '<div class="smc_skype_box_agent_title"> ' . $skype_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_skype_col_3">';
                            $html .= '<div class="smc_skype_box_agent_icon"><i class="fab fa-skype wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            
                $html .= '<form>';
                    $html .= '<input type="hidden" id="snc_skype_name" name="phone" value="' . $skype . '">';
                    $html .= '<input type="hidden" id="snc_skype_name2" name="phone2" value="' . $skype2 . '">';
                    $html .= '<input type="hidden" id="snc_skype_name3" name="phone3" value="' . $skype3 . '">';
                    $html .= '<input type="hidden" id="snc_skype_chosen_agent" name="snc_skype_chosen_agent">';
                    $html .= '<input type="hidden" id="snc_skype_url" name="url" value="' . $url . '">';
                    $html .= '<input type="hidden" id="snc_skype_quickchat" name="phone3" value="true">';
                $html .= '</form>';

            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * Facebook Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getFacebookForm() {
        $facebook_header = esc_attr(get_option('wb_cta_facebook_header'));
        $facebook_header = apply_filters('wb_cta_input_facebook_header', $facebook_header);

        $facebook = esc_attr(get_option('wb_cta_facebook'));
        $facebook2 = esc_attr(get_option('wb_cta_facebook2'));
        $facebook3 = esc_attr(get_option('wb_cta_facebook3'));
        
        $facebook_box_agent = esc_attr(get_option('wb_cta_facebook_box_agent'));
        $facebook_box_agent_title = esc_attr(get_option('wb_cta_facebook_box_agent_title'));
        $facebook_box_agent_img = esc_attr(get_option('wb_cta_facebook_box_agent_img'));

        if($facebook_box_agent_img == '') {
            $facebook_box_agent_img_url = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $facebook_box_agent_img_url = wp_get_attachment_image_src($facebook_box_agent_img);
        }
        
        $facebook_box_agent2 = esc_attr(get_option('wb_cta_facebook_box_agent2'));
        $facebook_box_agent_title2 = esc_attr(get_option('wb_cta_facebook_box_agent_title2'));
        $facebook_box_agent_img2 = esc_attr(get_option('wb_cta_facebook_box_agent_img2'));

        if($facebook_box_agent_img2 == '') {
            $facebook_box_agent_img_url2 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $facebook_box_agent_img_url2 = wp_get_attachment_image_src($facebook_box_agent_img2);
        }
        
        $facebook_box_agent3 = esc_attr(get_option('wb_cta_facebook_box_agent3'));
        $facebook_box_agent_title3 = esc_attr(get_option('wb_cta_facebook_box_agent_title3'));
        $facebook_box_agent_img3 = esc_attr(get_option('wb_cta_facebook_box_agent_img3'));

        if($facebook_box_agent_img3 == '') {
            $facebook_box_agent_img_url3 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $facebook_box_agent_img_url3 = wp_get_attachment_image_src($facebook_box_agent_img3);
        }

        $mobile_action = esc_attr(get_option('wb_cta_fb_mobile_action'));

        if(wp_is_mobile()) {
            if($mobile_action == 'app') {
                $url = "fb-messenger://user-thread/";
            } else {
                $url = "https://m.me/";
            }   
        } else {
            $url = "https://m.me/";
        }

        $html = '<div class="wb_cta_facebook_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_facebook_message_window_header"><i class="fab fa-facebook wb_cta_i"></i>&nbsp;';
            $html .= $facebook_header;
                $html .= '<div class="wb_cta_facebook_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_facebook_message_window_wrap">';

                if($facebook_box_agent != '') {
                    $html .= '<div class="wb_cta_facebook_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_facebook_col_1">';
                            $html .= '<div class="smc_facebook_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $facebook_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_facebook_col_2">';
                            $html .= '<div class="smc_facebook_name_wrap">';
                                $html .= '<div class="smc_facebook_box_agent_name"> ' . $facebook_box_agent . ' </div>';
                                $html .= '<div class="smc_facebook_box_agent_title"> ' . $facebook_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_facebook_col_3">';
                            $html .= '<div class="smc_facebook_box_agent_icon"><i class="fab fa-facebook wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($facebook2 != '') {
                    $html .= '<div class="wb_cta_facebook_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_facebook_col_1">';
                            $html .= '<div class="smc_facebook_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $facebook_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_facebook_col_2">';
                            $html .= '<div class="smc_facebook_name_wrap">';
                                $html .= '<div class="smc_facebook_box_agent_name"> ' . $facebook_box_agent2 . ' </div>';
                                $html .= '<div class="smc_facebook_box_agent_title"> ' . $facebook_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_facebook_col_3">';
                            $html .= '<div class="smc_facebook_box_agent_icon"><i class="fab fa-facebook wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($facebook3 != '') {
                    $html .= '<div class="wb_cta_facebook_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_facebook_col_1">';
                            $html .= '<div class="smc_facebook_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $facebook_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_facebook_col_2">';
                            $html .= '<div class="smc_facebook_name_wrap">';
                                $html .= '<div class="smc_facebook_box_agent_name"> ' . $facebook_box_agent3 . ' </div>';
                                $html .= '<div class="smc_facebook_box_agent_title"> ' . $facebook_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_facebook_col_3">';
                            $html .= '<div class="smc_facebook_box_agent_icon"><i class="fab fa-facebook wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            
                $html .= '<form>';
                    $html .= '<input type="hidden" id="snc_facebook_name" name="phone" value="' . $facebook . '">';
                    $html .= '<input type="hidden" id="snc_facebook_name2" name="phone2" value="' . $facebook2 . '">';
                    $html .= '<input type="hidden" id="snc_facebook_name3" name="phone3" value="' . $facebook3 . '">';
                    $html .= '<input type="hidden" id="snc_facebook_chosen_agent" name="snc_facebook_chosen_agent">';
                    $html .= '<input type="hidden" id="snc_facebook_url" name="url" value="' . $url . '">';
                    $html .= '<input type="hidden" id="snc_facebook_quickchat" name="phone3" value="true">';
                $html .= '</form>';

            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * VKontakte Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getVkontakteForm() {
        $vkontakte_header = esc_attr(get_option('wb_cta_vkontakte_header'));
        $vkontakte_header = apply_filters('wb_cta_input_vkontakte_header', $vkontakte_header);

        $vkontakte = esc_attr(get_option('wb_cta_vk'));
        $vkontakte2 = esc_attr(get_option('wb_cta_vkontakte2'));
        $vkontakte3 = esc_attr(get_option('wb_cta_vkontakte3'));
        
        $vkontakte_box_agent = esc_attr(get_option('wb_cta_vkontakte_box_agent'));
        $vkontakte_box_agent_title = esc_attr(get_option('wb_cta_vkontakte_box_agent_title'));
        $vkontakte_box_agent_img = esc_attr(get_option('wb_cta_vkontakte_box_agent_img'));

        if($vkontakte_box_agent_img == '') {
            $vkontakte_box_agent_img_url = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $vkontakte_box_agent_img_url = wp_get_attachment_image_src($vkontakte_box_agent_img);
        }
        
        $vkontakte_box_agent2 = esc_attr(get_option('wb_cta_vkontakte_box_agent2'));
        $vkontakte_box_agent_title2 = esc_attr(get_option('wb_cta_vkontakte_box_agent_title2'));
        $vkontakte_box_agent_img2 = esc_attr(get_option('wb_cta_vkontakte_box_agent_img2'));

        if($vkontakte_box_agent_img2 == '') {
            $vkontakte_box_agent_img_url2 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $vkontakte_box_agent_img_url2 = wp_get_attachment_image_src($vkontakte_box_agent_img2);
        }
        
        $vkontakte_box_agent3 = esc_attr(get_option('wb_cta_vkontakte_box_agent3'));
        $vkontakte_box_agent_title3 = esc_attr(get_option('wb_cta_vkontakte_box_agent_title3'));
        $vkontakte_box_agent_img3 = esc_attr(get_option('wb_cta_vkontakte_box_agent_img3'));

        if($vkontakte_box_agent_img3 == '') {
            $vkontakte_box_agent_img_url3 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $vkontakte_box_agent_img_url3 = wp_get_attachment_image_src($vkontakte_box_agent_img3);
        }

        if(wp_is_mobile()) {
            $url = "https://vk.me/";
        } else {
            $url = "https://vk.me/";
        }

        $html = '<div class="wb_cta_vkontakte_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_vkontakte_message_window_header"><i class="fab fa-vk wb_cta_i"></i>&nbsp;';
            $html .= $vkontakte_header;
                $html .= '<div class="wb_cta_vkontakte_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_vkontakte_message_window_wrap">';

                if($vkontakte_box_agent != '') {
                    $html .= '<div class="wb_cta_vkontakte_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_vkontakte_col_1">';
                            $html .= '<div class="smc_vkontakte_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $vkontakte_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_vkontakte_col_2">';
                            $html .= '<div class="smc_vkontakte_name_wrap">';
                                $html .= '<div class="smc_vkontakte_box_agent_name"> ' . $vkontakte_box_agent . ' </div>';
                                $html .= '<div class="smc_vkontakte_box_agent_title"> ' . $vkontakte_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_vkontakte_col_3">';
                            $html .= '<div class="smc_vkontakte_box_agent_icon"><i class="fab fa-vk wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($vkontakte2 != '') {
                    $html .= '<div class="wb_cta_vkontakte_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_vkontakte_col_1">';
                            $html .= '<div class="smc_vkontakte_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $vkontakte_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_vkontakte_col_2">';
                            $html .= '<div class="smc_vkontakte_name_wrap">';
                                $html .= '<div class="smc_vkontakte_box_agent_name"> ' . $vkontakte_box_agent2 . ' </div>';
                                $html .= '<div class="smc_vkontakte_box_agent_title"> ' . $vkontakte_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_vkontakte_col_3">';
                            $html .= '<div class="smc_vkontakte_box_agent_icon"><i class="fab fa-vk wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($vkontakte3 != '') {
                    $html .= '<div class="wb_cta_vkontakte_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_vkontakte_col_1">';
                            $html .= '<div class="smc_vkontakte_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $vkontakte_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_vkontakte_col_2">';
                            $html .= '<div class="smc_vkontakte_name_wrap">';
                                $html .= '<div class="smc_vkontakte_box_agent_name"> ' . $vkontakte_box_agent3 . ' </div>';
                                $html .= '<div class="smc_vkontakte_box_agent_title"> ' . $vkontakte_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_vkontakte_col_3">';
                            $html .= '<div class="smc_vkontakte_box_agent_icon"><i class="fab fa-vk wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            
                $html .= '<form>';
                    $html .= '<input type="hidden" id="snc_vkontakte_name" name="phone" value="' . $vkontakte . '">';
                    $html .= '<input type="hidden" id="snc_vkontakte_name2" name="phone2" value="' . $vkontakte2 . '">';
                    $html .= '<input type="hidden" id="snc_vkontakte_name3" name="phone3" value="' . $vkontakte3 . '">';
                    $html .= '<input type="hidden" id="snc_vkontakte_url" name="url" value="' . $url . '">';
                    $html .= '<input type="hidden" id="snc_vkontakte_quickchat" name="phone3" value="true">';
                $html .= '</form>';

            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * Viber Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getViberForm() {
        $viber_header = esc_attr(get_option('wb_cta_viber_header'));
        $viber_header = apply_filters('wb_cta_input_viber_header', $viber_header);

        $viber = esc_attr(get_option('wb_cta_viber'));
        $viber2 = esc_attr(get_option('wb_cta_viber2'));
        $viber3 = esc_attr(get_option('wb_cta_viber3'));
        
        $viber_box_agent = esc_attr(get_option('wb_cta_viber_box_agent'));
        $viber_box_agent_title = esc_attr(get_option('wb_cta_viber_box_agent_title'));
        $viber_box_agent_img = esc_attr(get_option('wb_cta_viber_box_agent_img'));

        if($viber_box_agent_img == '') {
            $viber_box_agent_img_url = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $viber_box_agent_img_url = wp_get_attachment_image_src($viber_box_agent_img);
        }
        
        $viber_box_agent2 = esc_attr(get_option('wb_cta_viber_box_agent2'));
        $viber_box_agent_title2 = esc_attr(get_option('wb_cta_viber_box_agent_title2'));
        $viber_box_agent_img2 = esc_attr(get_option('wb_cta_viber_box_agent_img2'));

        if($viber_box_agent_img2 == '') {
            $viber_box_agent_img_url2 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $viber_box_agent_img_url2 = wp_get_attachment_image_src($viber_box_agent_img2);
        }
        
        $viber_box_agent3 = esc_attr(get_option('wb_cta_viber_box_agent3'));
        $viber_box_agent_title3 = esc_attr(get_option('wb_cta_viber_box_agent_title3'));
        $viber_box_agent_img3 = esc_attr(get_option('wb_cta_viber_box_agent_img3'));

        if($viber_box_agent_img3 == '') {
            $viber_box_agent_img_url3 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $viber_box_agent_img_url3 = wp_get_attachment_image_src($viber_box_agent_img3);
        }

        if(wp_is_mobile()) {
            $url = "viber://chat?number=";
        } else {
            $url = "viber://chat?number=";
        }

        $html = '<div class="wb_cta_viber_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_viber_message_window_header"><i class="fab fa-viber wb_cta_i"></i>&nbsp;';
            $html .= $viber_header;
                $html .= '<div class="wb_cta_viber_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_viber_message_window_wrap">';

                if($viber_box_agent != '') {
                    $html .= '<div class="wb_cta_viber_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_viber_col_1">';
                            $html .= '<div class="smc_viber_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $viber_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_viber_col_2">';
                            $html .= '<div class="smc_viber_name_wrap">';
                                $html .= '<div class="smc_viber_box_agent_name"> ' . $viber_box_agent . ' </div>';
                                $html .= '<div class="smc_viber_box_agent_title"> ' . $viber_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_viber_col_3">';
                            $html .= '<div class="smc_viber_box_agent_icon"><i class="fab fa-viber wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($viber2 != '') {
                    $html .= '<div class="wb_cta_viber_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_viber_col_1">';
                            $html .= '<div class="smc_viber_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $viber_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_viber_col_2">';
                            $html .= '<div class="smc_viber_name_wrap">';
                                $html .= '<div class="smc_viber_box_agent_name"> ' . $viber_box_agent2 . ' </div>';
                                $html .= '<div class="smc_viber_box_agent_title"> ' . $viber_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_viber_col_3">';
                            $html .= '<div class="smc_viber_box_agent_icon"><i class="fab fa-viber wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($viber3 != '') {
                    $html .= '<div class="wb_cta_viber_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_viber_col_1">';
                            $html .= '<div class="smc_viber_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $viber_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_viber_col_2">';
                            $html .= '<div class="smc_viber_name_wrap">';
                                $html .= '<div class="smc_viber_box_agent_name"> ' . $viber_box_agent3 . ' </div>';
                                $html .= '<div class="smc_viber_box_agent_title"> ' . $viber_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_viber_col_3">';
                            $html .= '<div class="smc_viber_box_agent_icon"><i class="fab fa-viber wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            
                $html .= '<form>';
                    $html .= '<input type="hidden" id="snc_viber_name" name="phone" value="' . $viber . '">';
                    $html .= '<input type="hidden" id="snc_viber_name2" name="phone2" value="' . $viber2 . '">';
                    $html .= '<input type="hidden" id="snc_viber_name3" name="phone3" value="' . $viber3 . '">';
                    $html .= '<input type="hidden" id="snc_viber_chosen_agent" name="snc_viber_chosen_agent">';
                    $html .= '<input type="hidden" id="snc_viber_url" name="url" value="' . $url . '">';
                    $html .= '<input type="hidden" id="snc_viber_quickchat" name="phone3" value="true">';
                $html .= '</form>';

            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * Phone Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getPhoneForm() {
        $phone_header = esc_attr(get_option('wb_cta_phone_header'));
        $phone_header = apply_filters('wb_cta_input_phone_header', $phone_header);

        $phone = esc_attr(get_option('wb_cta_phone'));
        $phone2 = esc_attr(get_option('wb_cta_phone2'));
        $phone3 = esc_attr(get_option('wb_cta_phone3'));
        
        $phone_box_agent = esc_attr(get_option('wb_cta_phone_box_agent'));
        $phone_box_agent_title = esc_attr(get_option('wb_cta_phone_box_agent_title'));
        $phone_box_agent_img = esc_attr(get_option('wb_cta_phone_box_agent_img'));

        if($phone_box_agent_img == '') {
            $phone_box_agent_img_url = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $phone_box_agent_img_url = wp_get_attachment_image_src($phone_box_agent_img);
        }
        
        $phone_box_agent2 = esc_attr(get_option('wb_cta_phone_box_agent2'));
        $phone_box_agent_title2 = esc_attr(get_option('wb_cta_phone_box_agent_title2'));
        $phone_box_agent_img2 = esc_attr(get_option('wb_cta_phone_box_agent_img2'));

        if($phone_box_agent_img2 == '') {
            $phone_box_agent_img_url2 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $phone_box_agent_img_url2 = wp_get_attachment_image_src($phone_box_agent_img2);
        }
        
        $phone_box_agent3 = esc_attr(get_option('wb_cta_phone_box_agent3'));
        $phone_box_agent_title3 = esc_attr(get_option('wb_cta_phone_box_agent_title3'));
        $phone_box_agent_img3 = esc_attr(get_option('wb_cta_phone_box_agent_img3'));

        if($phone_box_agent_img3 == '') {
            $phone_box_agent_img_url3 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $phone_box_agent_img_url3 = wp_get_attachment_image_src($phone_box_agent_img3);
        }

        $url = "tel:";

        $html = '<div class="wb_cta_phone_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_phone_message_window_header"><i class="fas fa-phone-square wb_cta_i"></i>&nbsp;';
            $html .= $phone_header;
                $html .= '<div class="wb_cta_phone_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_phone_message_window_wrap">';

                if($phone_box_agent != '') {
                    $html .= '<div class="wb_cta_phone_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_phone_col_1">';
                            $html .= '<div class="smc_phone_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $phone_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_phone_col_2">';
                            $html .= '<div class="smc_phone_name_wrap">';
                                $html .= '<div class="smc_phone_box_agent_name"> ' . $phone_box_agent . ' </div>';
                                $html .= '<div class="smc_phone_box_agent_title"> ' . $phone_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_phone_col_3">';
                            $html .= '<div class="smc_phone_box_agent_icon"><i class="fas fa-phone-square wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($phone2 != '') {
                    $html .= '<div class="wb_cta_phone_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_phone_col_1">';
                            $html .= '<div class="smc_phone_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $phone_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_phone_col_2">';
                            $html .= '<div class="smc_phone_name_wrap">';
                                $html .= '<div class="smc_phone_box_agent_name"> ' . $phone_box_agent2 . ' </div>';
                                $html .= '<div class="smc_phone_box_agent_title"> ' . $phone_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_phone_col_3">';
                            $html .= '<div class="smc_phone_box_agent_icon"><i class="fas fa-phone-square wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($phone3 != '') {
                    $html .= '<div class="wb_cta_phone_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_phone_col_1">';
                            $html .= '<div class="smc_phone_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $phone_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_phone_col_2">';
                            $html .= '<div class="smc_phone_name_wrap">';
                                $html .= '<div class="smc_phone_box_agent_name"> ' . $phone_box_agent3 . ' </div>';
                                $html .= '<div class="smc_phone_box_agent_title"> ' . $phone_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_phone_col_3">';
                            $html .= '<div class="smc_phone_box_agent_icon"><i class="fas fa-phone-square wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            
                $html .= '<form>';
                    $html .= '<input type="hidden" id="snc_phone_name" name="phone" value="' . $phone . '">';
                    $html .= '<input type="hidden" id="snc_phone_name2" name="phone2" value="' . $phone2 . '">';
                    $html .= '<input type="hidden" id="snc_phone_name3" name="phone3" value="' . $phone3 . '">';
                    $html .= '<input type="hidden" id="snc_phone_chosen_agent" name="snc_phone_chosen_agent">';
                    $html .= '<input type="hidden" id="snc_phone_url" name="url" value="' . $url . '">';
                    $html .= '<input type="hidden" id="snc_phone_quickchat" name="phone3" value="true">';
                $html .= '</form>';

            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * Custom Form
	 * @access  public
	 * @since   1.0.0
     * Return HTML
	 */
    public function getCustomForm() {
        $custom_header = esc_attr(get_option('wb_cta_custom_header'));
        $custom_header = apply_filters('wb_cta_input_custom_header', $custom_header);

        $custom = esc_attr(get_option('wb_cta_custom'));
        $custom2 = esc_attr(get_option('wb_cta_custom2'));
        $custom3 = esc_attr(get_option('wb_cta_custom3'));
        
        $custom_box_agent = esc_attr(get_option('wb_cta_custom_box_agent'));
        $custom_box_agent_title = esc_attr(get_option('wb_cta_custom_box_agent_title'));
        $custom_box_agent_img = esc_attr(get_option('wb_cta_custom_box_agent_img'));
        
        $custom_icon = esc_attr(get_option('wb_cta_custom_icon'));

        if($custom_box_agent_img == '') {
            $custom_box_agent_img_url = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $custom_box_agent_img_url = wp_get_attachment_image_src($custom_box_agent_img);
        }
        
        $custom_box_agent2 = esc_attr(get_option('wb_cta_custom_box_agent2'));
        $custom_box_agent_title2 = esc_attr(get_option('wb_cta_custom_box_agent_title2'));
        $custom_box_agent_img2 = esc_attr(get_option('wb_cta_custom_box_agent_img2'));

        if($custom_box_agent_img2 == '') {
            $custom_box_agent_img_url2 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $custom_box_agent_img_url2 = wp_get_attachment_image_src($custom_box_agent_img2);
        }
        
        $custom_box_agent3 = esc_attr(get_option('wb_cta_custom_box_agent3'));
        $custom_box_agent_title3 = esc_attr(get_option('wb_cta_custom_box_agent_title3'));
        $custom_box_agent_img3 = esc_attr(get_option('wb_cta_custom_box_agent_img3'));

        if($custom_box_agent_img3 == '') {
            $custom_box_agent_img_url3 = array(plugins_url() . '/social-network-chat/assets/img/user_placeholder.jpeg');
        } else {
            $custom_box_agent_img_url3 = wp_get_attachment_image_src($custom_box_agent_img3);
        }

        $url = esc_attr(get_option('wb_cta_custom_url'));

        $html = '<div class="wb_cta_custom_message_window wb_cta_popup_window">';
            $html .= '<div class="wb_cta_custom_message_window_header"><i class="fab fa-custom wb_cta_i"></i>&nbsp;';
            $html .= $custom_header;
                $html .= '<div class="wb_cta_custom_close">x</div>';
            $html .= '</div>';

            $html .= '<div class="wb_cta_custom_message_window_wrap">';

                if($custom_box_agent != '') {
                    $html .= '<div class="wb_cta_custom_message_agent_wrap_inner" id="snc_agent1">';
                        $html .= '<div class="smc_custom_col_1">';
                            $html .= '<div class="smc_custom_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $custom_box_agent_img_url[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_custom_col_2">';
                            $html .= '<div class="smc_custom_name_wrap">';
                                $html .= '<div class="smc_custom_box_agent_name"> ' . $custom_box_agent . ' </div>';
                                $html .= '<div class="smc_custom_box_agent_title"> ' . $custom_box_agent_title . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_custom_col_3">';
                            $html .= '<div class="smc_custom_box_agent_icon"><i class="' . $custom_icon . ' wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($custom2 != '') {
                    $html .= '<div class="wb_cta_custom_message_agent_wrap_inner" id="snc_agent2">';
                        $html .= '<div class="smc_custom_col_1">';
                            $html .= '<div class="smc_custom_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $custom_box_agent_img_url2[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_custom_col_2">';
                            $html .= '<div class="smc_custom_name_wrap">';
                                $html .= '<div class="smc_custom_box_agent_name"> ' . $custom_box_agent2 . ' </div>';
                                $html .= '<div class="smc_custom_box_agent_title"> ' . $custom_box_agent_title2 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_custom_col_3">';
                            $html .= '<div class="smc_custom_box_agent_icon"><i class="' . $custom_icon . ' wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }

                if($custom3 != '') {
                    $html .= '<div class="wb_cta_custom_message_agent_wrap_inner" id="snc_agent3">';
                        $html .= '<div class="smc_custom_col_1">';
                            $html .= '<div class="smc_custom_name_image_wrap">';
                                $html .= '<img class="smc_user_agent_img" src="' . $custom_box_agent_img_url3[0] . '">';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_custom_col_2">';
                            $html .= '<div class="smc_custom_name_wrap">';
                                $html .= '<div class="smc_custom_box_agent_name"> ' . $custom_box_agent3 . ' </div>';
                                $html .= '<div class="smc_custom_box_agent_title"> ' . $custom_box_agent_title3 . ' </div>';
                            $html .= '</div>';
                        $html .= '</div>';

                        $html .= '<div class="smc_custom_col_3">';
                            $html .= '<div class="smc_custom_box_agent_icon"><i class="' . $custom_icon . ' wb_cta_i"></i></div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }
            
                $html .= '<form>';
                    $html .= '<input type="hidden" id="snc_custom_name" name="custom" value="' . $custom . '">';
                    $html .= '<input type="hidden" id="snc_custom_name2" name="custom2" value="' . $custom2 . '">';
                    $html .= '<input type="hidden" id="snc_custom_name3" name="custom3" value="' . $custom3 . '">';
                    $html .= '<input type="hidden" id="snc_custom_chosen_agent" name="snc_custom_chosen_agent">';
                    $html .= '<input type="hidden" id="snc_custom_url" name="url" value="' . $url . '">';
                    $html .= '<input type="hidden" id="snc_custom_quickchat" name="custom3" value="true">';
                $html .= '</form>';

            $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    /**
	 * Check on which pages the plugin should be active
	 * @access  public
	 * @since   1.0.0
     * Return Boolean
	 */
    public function activatePlugin() {
        $show_only_on_pages = get_option('wb_cta_show_only_on_pages');
        $activate_the_plugin = false;

        if(is_array($show_only_on_pages) && !empty($show_only_on_pages)) {
            $page_id = get_the_ID();

            foreach($show_only_on_pages as $k) {
                if((int)$page_id == (int)$k) {
                    $activate_the_plugin = true;
                }
            }
        } else {
            $activate_the_plugin = true;
        }

        return $activate_the_plugin;
    }
}

$wb_cta_buttons_class = new WB_Cta_Buttons_Class();