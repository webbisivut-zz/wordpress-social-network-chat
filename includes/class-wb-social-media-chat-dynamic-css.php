<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WB_Fixed_Cta_Styles_Dynamic {

	/**
	 * Constructor function
	 * @access  public
	 * @since   1.0.0
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'wb_fixed_cta_styles_dynamic'), 100 );
	}

	/**
	 * Dynamic styles
	 * @access  public
	 * @since   1.0.0
	 */
	public function wb_fixed_cta_styles_dynamic() {
		$width = esc_attr(get_option('wb_cta_width'));
		$height = esc_attr(get_option('wb_cta_height'));
		$btnRightMargin = esc_attr(get_option('wb_cta_btn_right_margin'));
		$btnBottomMargin = esc_attr(get_option('wb_cta_btn_bottom_margin'));
		$text_adjust = esc_attr(get_option('wb_cta_text_adjust'));
		$border_radius = esc_attr(get_option('wb_cta_border_radius'));
		$visible_on_hover = esc_attr(get_option('wb_cta_visible_on_hover'));

		$marginBottomChatBox = esc_attr(get_option('wb_cta_box_bottom_margin'));
		$marginRightChatBox = esc_attr(get_option('wb_cta_box_right_margin'));

		if($border_radius == '' || $border_radius == null) {
			$border_radius = 30;
		}

		if($width == '' || $width == null) {
			$width = 52;
		}
	
		if($height == '' || $height == null) {
			$height = 52;
		}

		if($marginBottomChatBox == '' || $marginBottomChatBox == null) {
			$marginBottomChatBox = 90;
		}

		if($marginRightChatBox == '' || $marginRightChatBox == null) {
			$marginRightChatBox = 25;
		}

		if($btnRightMargin == '' || $btnRightMargin == null) {
			$btnRightMargin = 15;
		}

		if($btnBottomMargin == '' || $btnBottomMargin == null) {
			$btnBottomMargin = 15;
		}

		$btnBottomMargin_popup = (int)$marginBottomChatBox - 15; 
		$btnRightMargin_popup = (int)$marginRightChatBox -25; 
		
		$hide_on_desktop_whatsapp = esc_attr(get_option('wb_cta_hide_on_desktop_whatsapp'));
		$hide_on_mobile_whatsapp = esc_attr(get_option('wb_cta_hide_on_mobile_whatsapp'));
		
		$hide_on_desktop_line = esc_attr(get_option('wb_cta_hide_on_desktop_line'));
		$hide_on_mobile_line = esc_attr(get_option('wb_cta_hide_on_mobile_line'));
		
		$hide_on_desktop_telegram = esc_attr(get_option('wb_cta_hide_on_desktop_telegram'));
		$hide_on_mobile_telegram = esc_attr(get_option('wb_cta_hide_on_mobile_telegram'));
		
		$hide_on_desktop_skype = esc_attr(get_option('wb_cta_hide_on_desktop_skype'));
		$hide_on_mobile_skype = esc_attr(get_option('wb_cta_hide_on_mobile_skype'));
		
		$hide_on_desktop_facebook = esc_attr(get_option('wb_cta_hide_on_desktop_facebook'));
		$hide_on_mobile_facebook = esc_attr(get_option('wb_cta_hide_on_mobile_facebook'));
		
		$hide_on_desktop_vk = esc_attr(get_option('wb_cta_hide_on_desktop_vk'));
		$hide_on_mobile_vk = esc_attr(get_option('wb_cta_hide_on_mobile_vk'));
		
		$hide_on_desktop_viber = esc_attr(get_option('wb_cta_hide_on_desktop_viber'));
		$hide_on_mobile_viber = esc_attr(get_option('wb_cta_hide_on_mobile_viber'));
		
		$hide_on_desktop_custom = esc_attr(get_option('wb_cta_hide_on_desktop_custom'));
		$hide_on_mobile_custom = esc_attr(get_option('wb_cta_hide_on_mobile_custom'));
		
		$hide_on_desktop_phone = esc_attr(get_option('wb_cta_hide_on_desktop_phone'));
		$hide_on_mobile_phone = esc_attr(get_option('wb_cta_hide_on_mobile_phone'));
		
		$hide_on_desktop_email = esc_attr(get_option('wb_cta_hide_on_desktop_email'));
		$hide_on_mobile_email = esc_attr(get_option('wb_cta_hide_on_mobile_email'));
		
		$popup_pulse = esc_attr(get_option('wb_cta_popup_pulse'));

		$isMobile = wp_is_mobile();		

		$marginBottom = (int)$width + 10;

		// Email
		$email_messagebox_height = esc_attr(get_option('wb_cta_email_messagebox_height'));

		$email = esc_attr(get_option('wb_cta_email'));
		$email2 = esc_attr(get_option('wb_cta_email2'));
		$email3 = esc_attr(get_option('wb_cta_email3'));

		$activeArrDesktop = array();
		$activeArrMobile = array();
		
		$whatsapp = esc_attr(get_option('wb_cta_whatsapp'));
		$line = esc_attr(get_option('wb_cta_line'));
		$telegram = esc_attr(get_option('wb_cta_telegram'));
		$skype = esc_attr(get_option('wb_cta_skype'));
		$facebook = esc_attr(get_option('wb_cta_facebook'));
		$vk = esc_attr(get_option('wb_cta_vk'));
		$viber = esc_attr(get_option('wb_cta_viber'));
		$custom_url = esc_attr(get_option('wb_cta_custom_url'));
		$phone = esc_attr(get_option('wb_cta_phone'));
		$email = esc_attr(get_option('wb_cta_email'));

		if($isMobile) {
			if($whatsapp != '' && $hide_on_mobile_whatsapp == 'false') {
				array_push($activeArrMobile, $whatsapp);
			}
	
			if($line != '' && $hide_on_mobile_line == 'false') {
				array_push($activeArrMobile, $line);
			}
	
			if($telegram != '' && $hide_on_mobile_telegram == 'false') {
				array_push($activeArrMobile, $telegram);
			}
	
			if($skype != '' && $hide_on_mobile_skype == 'false') {
				array_push($activeArrMobile, $skype);
			}
	
			if($facebook != '' && $hide_on_mobile_facebook == 'false') {
				array_push($activeArrMobile, $facebook);
			}
	
			if($vk != '' && $hide_on_mobile_vk == 'false') {
				array_push($activeArrMobile, $vk);
			}
	
			if($viber != '' && $hide_on_mobile_viber == 'false') {
				array_push($activeArrMobile, $viber);
			}
	
			if($custom_url != '' && $hide_on_mobile_custom == 'false') {
				array_push($activeArrMobile, $custom_url);
			}
	
			if($phone != '' && $hide_on_mobile_phone == 'false') {
				array_push($activeArrMobile, $phone);
			}
	
			if($email != '' && $hide_on_mobile_email == 'false') {
				array_push($activeArrMobile, $email);
			}
		} else {
			if($whatsapp != '' && $hide_on_mobile_whatsapp == 'false') {
				array_push($activeArrDesktop, $whatsapp);
			}
	
			if($line != '' && $hide_on_desktop_line == 'false') {
				array_push($activeArrDesktop, $line);
			}
	
			if($telegram != '' && $hide_on_desktop_telegram == 'false') {
				array_push($activeArrDesktop, $telegram);
			}
	
			if($skype != '' && $hide_on_desktop_skype == 'false') {
				array_push($activeArrDesktop, $skype);
			}
	
			if($facebook != '' && $hide_on_desktop_facebook == 'false') {
				array_push($activeArrDesktop, $facebook);
			}
	
			if($vk != '' && $hide_on_desktop_vk == 'false') {
				array_push($activeArrDesktop, $vk);
			}
	
			if($viber != '' && $hide_on_desktop_viber == 'false') {
				array_push($activeArrDesktop, $viber);
			}
	
			if($custom_url != '' && $hide_on_desktop_custom == 'false') {
				array_push($activeArrDesktop, $custom_url);
			}
	
			if($phone != '' && $hide_on_desktop_phone == 'false') {
				array_push($activeArrDesktop, $phone);
			}
	
			if($email != '' && $hide_on_desktop_email == 'false') {
				array_push($activeArrDesktop, $email);
			}
		}
		
		$activeArrMobileLength = sizeof($activeArrMobile);
		$activeArrDesktopLength = sizeof($activeArrDesktop);

		$popup_pulse = esc_attr(get_option('wb_cta_popup_pulse'));
		$chat_btn_color = esc_attr(get_option('wb_cta_chat_btn_color'));
		$whatsapp_btn_color = esc_attr(get_option('wb_cta_whatsapp_btn_color'));
		$line_btn_color = esc_attr(get_option('wb_cta_line_btn_color'));
		$viber_btn_color = esc_attr(get_option('wb_cta_viber_btn_color'));
		$skype_btn_color = esc_attr(get_option('wb_cta_skype_btn_color'));
		$telegram_btn_color = esc_attr(get_option('wb_cta_telegram_btn_color'));
		$facebook_btn_color = esc_attr(get_option('wb_cta_facebook_btn_color'));
		$vkontakte_btn_color = esc_attr(get_option('wb_cta_vk_btn_color'));
		$custom_btn_color = esc_attr(get_option('wb_cta_custom_btn_color'));
		$phone_btn_color = esc_attr(get_option('wb_cta_phone_btn_color'));
		$email_btn_color = esc_attr(get_option('wb_cta_email_btn_color'));

		// WhatsApp
		$whatsapp_messagebox_height = esc_attr(get_option('wb_cta_whatsapp_messagebox_height'));

		$whatsapp = esc_attr(get_option('wb_cta_whatsapp'));
        $whatsapp2 = esc_attr(get_option('wb_cta_whatsapp2'));
        $whatsapp3 = esc_attr(get_option('wb_cta_whatsapp3'));

		if($chat_btn_color == '') {
			$chat_btn_color = '#68467e';
		}

		$chat_btn_shadow = $chat_btn_color . 'cc';
		?>
	
		<style>
			<?php if($email2 !== '' OR $email3 !== '') { ?>
				#wb_cta_input_form_wrap {
					display: none;
				}
			<?php } else { ?>
				#wb_cta_input_form_wrap {
					display: block;
				}

				.wb_cta_whatsapp_message_agent_wrap_inner:hover {
					cursor: default;
				}
			<?php } ?>

			<?php if($activeArrMobileLength > 7 OR $activeArrDesktopLength > 7) { ?>
				#wb_cta_wrap_relative {
					max-width: 150px;
				}

				.wb_cta_btn,
				.wb_cta_btn_chat {
					margin-left: 2px;
					float: right;
				}
			<?php } ?>

			<?php if($activeArrMobileLength > 4 OR $activeArrDesktopLength > 4) { ?>
				@media(max-height: 400px) {
					#wb_cta_wrap_relative {
						max-width: 150px;
					}

					.wb_cta_btn,
					.wb_cta_btn_chat {
						margin-left: 2px;
						float: right;
					}
				}
			<?php } ?>
			
			.wb_cta_email_message_window,
			.wb_cta_phone_message_window,
			.wb_cta_custom_message_window,
			.wb_cta_facebook_message_window,
			.wb_cta_vkontakte_message_window,
			.wb_cta_viber_message_window,
			.wb_cta_skype_message_window,
			.wb_cta_line_message_window,
			.wb_cta_telegram_message_window,
			.wb_cta_whatsapp_message_window,
			.wb_cta_message_window {
				bottom: <?php echo $marginBottomChatBox; ?>px;
				right: <?php echo $marginRightChatBox; ?>px;
			}

			#wb_cta_wrap {
				bottom: <?php echo $btnBottomMargin; ?>px;
				right: <?php echo $btnRightMargin; ?>px;
			}
			
			.social-network-speech-bubble {
				bottom: <?php echo $btnBottomMargin_popup; ?>px;
				right: <?php echo $btnRightMargin_popup; ?>px;
			}

			#wb_cta_wrap_relative,
			#wb_cta_wrap_relative2 {
				right: <?php echo $btnRightMargin; ?>px;
			}

			.wb_cta_btn_chat,
			.wb_cta_btn  {
				width: <?php echo $width; ?>px !important;
				height: <?php echo $height; ?>px !important;
				border-radius: <?php echo $border_radius; ?>px;
			}

			#wb_cta_input_textarea {
				height: <?php echo $email_messagebox_height; ?>px;
			}

			<?php if($visible_on_hover == 'true') { ?>
				#wb_cta_wrap_relative {
					display: none;
				}

				#wb_cta_wrap_relative {
					margin-bottom: <?php echo $marginBottom; ?>px !important;
				}
			<?php } ?>

			<?php if($visible_on_hover == 'true') { ?>

			<?php if($isMobile) { ?>
				<?php if($hide_on_mobile_whatsapp == 'true') { ?>
					#wb_cta_whatsapp {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_mobile_line == 'true') { ?>
					#wb_cta_line {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_mobile_telegram == 'true') { ?>
					#wb_cta_telegram {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_mobile_skype == 'true') { ?>
					#wb_cta_skype {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_mobile_facebook == 'true') { ?>
					#wb_cta_facebook {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_mobile_vk == 'true') { ?>
					#wb_cta_vk {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_mobile_viber == 'true') { ?>
					#wb_cta_viber {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_mobile_custom == 'true') { ?>
					#wb_cta_custom {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_mobile_phone == 'true') { ?>
					#wb_cta_phone {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_mobile_email == 'true') { ?>
					#wb_cta_email {
						display: none !important;
					}
				<?php } ?>
			<?php } else { ?>
				<?php if($hide_on_desktop_whatsapp == 'true') { ?>
					#wb_cta_whatsapp {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_desktop_line == 'true') { ?>
					#wb_cta_line {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_desktop_telegram == 'true') { ?>
					#wb_cta_telegram {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_desktop_skype == 'true') { ?>
					#wb_cta_skype {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_desktop_facebook == 'true') { ?>
					#wb_cta_facebook {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_desktop_vk == 'true') { ?>
					#wb_cta_vk {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_desktop_viber == 'true') { ?>
					#wb_cta_viber {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_desktop_custom == 'true') { ?>
					#wb_cta_custom {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_desktop_phone == 'true') { ?>
					#wb_cta_phone {
						display: none !important;
					}
				<?php } ?>

				<?php if($hide_on_desktop_email == 'true') { ?>
					#wb_cta_email {
						display: none !important;
					}
				<?php } ?>
			<?php } ?>
			<?php } ?>

			<?php if($whatsapp2 !== '' OR $whatsapp3 !== '') { ?>
				#wb_cta_input_whatsapp_textarea {
					display: none;
				}

				.wb_cta_whatsapp_message_agent_wrap_inner:hover {
					border: 2px solid <?php echo $whatsapp_btn_color; ?>;
				}
			<?php } else { ?>
				#wb_cta_input_whatsapp_textarea {
					display: block;
				}

				.wb_cta_whatsapp_message_agent_wrap_inner:hover {
					cursor: default;
				}
			<?php } ?>

			<?php if($popup_pulse == 'true') { ?>
			#wb_cta_chat {
				background: <?php echo $chat_btn_color; ?>;
				box-shadow: 0 0 0 <?php echo $chat_btn_shadow; ?>;
				animation: pulse 2s infinite;
			}

			#wb_cta_chat:hover {
				animation: none;
			}
			
			@-webkit-keyframes pulse {
				0% {
					-webkit-box-shadow: 0 0 0 0 <?php echo $chat_btn_shadow; ?>;
				}
				70% {
					-webkit-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
				}
				100% {
					-webkit-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
				}
			}
			@keyframes pulse {
				0% {
					-moz-box-shadow: 0 0 0 0 <?php echo $chat_btn_shadow; ?>;
					box-shadow: 0 0 0 0 <?php echo $chat_btn_shadow; ?>;
				}
				70% {
					-moz-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
					box-shadow: 0 0 0 10px rgba(204,169,44, 0);
				}
				100% {
					-moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
					box-shadow: 0 0 0 0 rgba(204,169,44, 0);
				}
			}
			<?php } ?>

			#wb_cta_input_whatsapp_textarea {
				height: <?php echo $whatsapp_messagebox_height; ?>px;
			}

			#wb_cta_chat {
				background: <?php echo $chat_btn_color; ?>;
			}

			#wb_cta_custom {
				background: <?php echo $custom_btn_color; ?>;
			}

			.wb_cta_viber_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $viber_btn_color; ?>;
			}

			.wb_cta_viber_message_agent_wrap_inner:hover {
				border: 2px solid <?php echo $viber_btn_color; ?>;
			}

			.wb_cta_viber_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $viber_btn_color; ?>;
			}

			.wb_cta_viber_message_window_header {
				background: <?php echo $viber_btn_color; ?>;
			}

			.smc_viber_box_agent_icon {
				color: <?php echo $viber_btn_color; ?>;
			}

			#wb_cta_viber {
				background: <?php echo $viber_btn_color; ?>;
			}

			.wb_cta_skype_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $skype_btn_color; ?>;
			}

			.wb_cta_skype_message_agent_wrap_inner:hover {
				border: 2px solid <?php echo $skype_btn_color; ?>;
			}

			.wb_cta_skype_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $skype_btn_color; ?>;
			}

			.wb_cta_skype_message_window_header {
				background: <?php echo $skype_btn_color; ?>;
			}

			.smc_skype_box_agent_icon {
				color: <?php echo $skype_btn_color; ?>;
			}

			#wb_cta_skype {
				background: <?php echo $skype_btn_color; ?>;
			}

			.wb_cta_telegram_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $telegram_btn_color; ?>;
			}

			.wb_cta_telegram_message_agent_wrap_inner:hover {
				border: 2px solid <?php echo $telegram_btn_color; ?>;
			}

			.wb_cta_telegram_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $telegram_btn_color; ?>;
			}

			.wb_cta_telegram_message_window_header {
				background: <?php echo $telegram_btn_color; ?>;
			}

			.smc_telegram_box_agent_icon {
				color: <?php echo $telegram_btn_color; ?>;
			}

			#wb_cta_telegram {
				background: <?php echo $telegram_btn_color; ?>;
			}

			.wb_cta_vkontakte_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $vkontakte_btn_color; ?>;
			}

			.wb_cta_vkontakte_message_agent_wrap_inner:hover {
				border: 2px solid <?php echo $vkontakte_btn_color; ?>;
			}

			.wb_cta_vkontakte_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $vkontakte_btn_color; ?>;
			}

			.wb_cta_vkontakte_message_window_header {
				background: <?php echo $vkontakte_btn_color; ?>;
			}

			#wb_cta_vkontakte {
				background: <?php echo $vkontakte_btn_color; ?>;
			}

			.smc_vkontakte_box_agent_icon {
				color: <?php echo $vkontakte_btn_color; ?>;
			}

			#wb_cta_vk {
				background: <?php echo $vkontakte_btn_color; ?>;
			}

			.wb_cta_facebook_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $facebook_btn_color; ?>;
			}

			.wb_cta_facebook_message_agent_wrap_inner:hover {
				border: 2px solid <?php echo $facebook_btn_color; ?>;
			}

			.wb_cta_facebook_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $facebook_btn_color; ?>;
			}

			.wb_cta_facebook_message_window_header {
				background: <?php echo $facebook_btn_color; ?>;
			}

			.smc_facebook_box_agent_icon {
				color: <?php echo $facebook_btn_color; ?>;
			}

			#wb_cta_facebook {
				background: <?php echo $facebook_btn_color; ?>;
			}

			.wb_cta_phone_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $phone_btn_color; ?>;
			}

			.wb_cta_phone_message_agent_wrap_inner:hover {
				border: 2px solid <?php echo $phone_btn_color; ?>;
			}

			.wb_cta_phone_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $phone_btn_color; ?>;
			}

			.wb_cta_phone_message_window_header {
				background: <?php echo $phone_btn_color; ?>;
			}

			.smc_phone_box_agent_icon {
				color: <?php echo $phone_btn_color; ?>;
			}

			#wb_cta_phone {
				background: <?php echo $phone_btn_color; ?>;
			}

			.wb_cta_email_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $email_btn_color; ?>;
			}

			.wb_cta_email_message_agent_wrap_inner:hover {
				border: 2px solid <?php echo $email_btn_color; ?>;
			}

			.wb_cta_email_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $email_btn_color; ?>;
			}

			.wb_cta_email_message_window_header {
				background: <?php echo $email_btn_color; ?>;
			}

			.smc_email_box_agent_icon {
				color: <?php echo $email_btn_color; ?>;
			}

			.wb_cta_input_email_submit,
			#wb_cta_email {
				background: <?php echo $email_btn_color; ?>;
			}

			.wb_cta_custom_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $custom_btn_color; ?>;
			}

			.wb_cta_custom_message_agent_wrap_inner:hover {
				border: 2px solid <?php echo $custom_btn_color; ?>;
			}

			.wb_cta_custom_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $custom_btn_color; ?>;
			}

			.wb_cta_custom_message_window_header {
				background: <?php echo $custom_btn_color; ?>;
			}

			.smc_custom_box_agent_icon {
				color: <?php echo $custom_btn_color; ?>;
			}

			#wb_cta_custom {
				background: <?php echo $custom_btn_color; ?>;
			}
			
			.wb_cta_line_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $line_btn_color; ?>;
			}

			.wb_cta_line_message_agent_wrap_inner:hover {
				border: 2px solid <?php echo $line_btn_color; ?>;
			}

			.wb_cta_line_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $line_btn_color; ?>;
			}

			.wb_cta_line_message_window_header {
				background: <?php echo $line_btn_color; ?>;
			}

			.smc_line_box_agent_icon {
				color: <?php echo $line_btn_color; ?>;
			}

			#wb_cta_line {
				background: <?php echo $line_btn_color; ?>;
			}

			.wb_cta_whatsapp_message_agent_wrap_inner {
				border-left: 2px solid <?php echo $whatsapp_btn_color; ?>;
			}

			.wb_cta_whatsapp_message_agent_wrap_inner_border {
				border: 2px solid <?php echo $whatsapp_btn_color; ?>;
			}

			.wb_cta_input_whatsapp_submit,
			.wb_cta_whatsapp_message_window_header {
				background: <?php echo $whatsapp_btn_color; ?>;
			}

			.smc_whatsapp_box_agent_icon {
				color: <?php echo $whatsapp_btn_color; ?>;
			}

			#wb_cta_whatsapp {
				background: <?php echo $whatsapp_btn_color; ?>;
			}

			.wb_cta_message_window_header {
				background: <?php echo $email_btn_color; ?>;
			}

			.wb_cta_btn_chat_shortcode {
				background: <?php echo $chat_btn_color; ?>;
			}
		</style>
	
	<?php }
}

$wb_fixed_cta_styles_dynamic = new WB_Fixed_Cta_Styles_Dynamic();