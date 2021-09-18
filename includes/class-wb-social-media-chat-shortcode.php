<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WB_Cta_Buttons_Class_Pro_Shortcode {
    
    /**
	 * Constructor function
	 * @access  public
	 * @since   1.0.0
	 */
    public function __construct() {
        // Shortcode
        add_shortcode( 'social-network-chat', array($this, 'social_network_chat_function'), 10 );
        		
		// Gutenberg blocks
		add_action( 'init', array( $this, 'register_gutenberg_blocks' ), 10 );
    }
 
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

		wp_register_script( 'wd_social_network_chat-gutenberg-shortcode', esc_url( plugin_dir_url(__FILE__) ) . '../assets/js/gutenberg_shortcode.js', array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
		wp_enqueue_script( 'wd_social_network_chat-gutenberg-shortcode' );

		register_block_type(
			'wd-social-network-chat-pro-dev/wd-social-network-chat-pro', 
			array(
                'editor_script' => 'social-network-chat'
			) 
		);
	}
}

$wb_cta_buttons_class_pro_shortcode = new WB_Cta_Buttons_Class_Pro_Shortcode();