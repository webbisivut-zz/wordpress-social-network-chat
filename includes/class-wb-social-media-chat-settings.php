<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WB_Social_Media_Chat_Settings {

	/**
	 * The single instance of WB_Social_Media_Chat_Settings.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The main plugin object.
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	public function __construct ( $parent ) {
		$this->parent = $parent;

		$this->base = 'wb_cta_';

		// Initialise settings
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_settings_link' ) );
	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init_settings () {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item () {
		$page = add_menu_page( __( 'Social Network Chat', 'wb-social-media-chat' ) , __( 'Social Network Chat', 'wb-social-media-chat' ) , 'manage_options' , $this->parent->_token . '_settings' ,  array( $this, 'settings_page' ), plugin_dir_url( __FILE__ ) . '../assets/img/icon.png' );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );

		//$page2 = add_submenu_page(  $this->parent->_token . '_settings', __( 'Support', 'wb-social-media-chat' ) , __( 'Support', 'wb-social-media-chat' ) , 'manage_options' , $this->parent->_token . '_support' ,  array( $this, 'settings_page_support' ));
		//add_action( 'admin_print_styles-' . $page2, array( $this, 'settings_assets' ) );
	}

	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets () {

		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
		wp_enqueue_style( 'farbtastic' );
    	wp_enqueue_script( 'farbtastic' );

    	// We're including the WP media scripts here because they're needed for the image upload field
    	// If you're not including an image upload then you can leave this function call out
    	wp_enqueue_media();

    	wp_register_script( $this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
    	wp_enqueue_script( $this->parent->_token . '-settings-js' );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link ( $links ) {
		$settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __( 'Settings', 'wb-social-media-chat' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {

		$settings['standard'] = array(
			'title'					=> __( 'Standard', 'wb-social-media-chat' ),
			'description'			=> __( 'Plugin standard settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'visible_on_hover',
					'label'			=> __( 'Chat button' , 'wb-social-media-chat' ),
					'description'	=> __( 'If enabled, contact buttons are visible only when user clicks the chat button.', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'true'
				),
				array(
					'id' 			=> 'width',
					'label'			=> __( 'Button width' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your button width', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '52',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'height',
					'label'			=> __( 'Button height' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your button height', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '52',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'border_radius',
					'label'			=> __( 'Button radius' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your button radius', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '30',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'btn_right_margin',
					'label'			=> __( 'Right margin' , 'wb-social-media-chat' ),
					'description'	=> __( 'Adjust right margin', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '15',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'btn_bottom_margin',
					'label'			=> __( 'Bottom margin' , 'wb-social-media-chat' ),
					'description'	=> __( 'Adjust bottom margin', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '15',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'box_right_margin',
					'label'			=> __( 'Chat Box and Notice Box Right margin' , 'wb-social-media-chat' ),
					'description'	=> __( 'Adjust chat box right margin', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '25',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'box_bottom_margin',
					'label'			=> __( 'Chat Box and Notice Box Bottom margin' , 'wb-social-media-chat' ),
					'description'	=> __( 'Adjust chat box bottom margin', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '90',
					'placeholder'	=> ''
				),
			)
		);

		$pages = get_pages();
		$pagesArr = array();

		foreach($pages as $page) {
			$pagesArr[$page->ID] = $page->post_name;
		}

		$settings['email'] = array(
			'title'					=> __( 'Email', 'wb-social-media-chat' ),
			'description'			=> __( 'Email settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'email',
					'label'			=> __( 'Email address' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your email address, or leave empty to disable this button.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'hide_on_desktop_email',
					'label'			=> __( 'Hide email button on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide email button on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_email',
					'label'			=> __( 'Hide email button on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide email button on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'email_box',
					'label'			=> __( 'Email message area' , 'wb-social-media-chat' ),
					'description'	=> __( 'If enabled, a message box with textarea will be opened when user cliks the email button.', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'email_header',
					'label'			=> __( 'Email header' , 'wb-social-media-chat' ),
					'description'	=> __( 'Header text for the email box.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Contact us',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'thankyou',
					'label'			=> __( 'Thank you message' , 'wb-social-media-chat' ),
					'description'	=> __( 'Message to be given for user when mail has been sent succesfully', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Thank you for your message!',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'error',
					'label'			=> __( 'Error message' , 'wb-social-media-chat' ),
					'description'	=> __( 'Message to be given for user when email is incorrect', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Email is incorrect',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'form_email',
					'label'			=> __( 'From email field text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place text for from email field', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Email*',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'form_message',
					'label'			=> __( 'From message field text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place text for from message field', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Message*',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'form_submit',
					'label'			=> __( 'From submit field text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place text for from submit field', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Submit',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'subject',
					'label'			=> __( 'Mail subject' , 'wb-social-media-chat' ),
					'description'	=> __( 'Subject for email', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'New message from website',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'from',
					'label'			=> __( 'From text' , 'wb-social-media-chat' ),
					'description'	=> __( 'From text in mail', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'From',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'from_message',
					'label'			=> __( 'Message text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Message text in mail', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Message',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'email_messagebox_height',
					'label'			=> __( 'Email message box height' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your Email message box height in pixels here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '115',
					'placeholder'	=> '115'
				),
				array(
					'id' 			=> 'email_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'email_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'email_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'email2',
					'label'			=> __( 'Email address 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your email address, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'email_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'email_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'email_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'email3',
					'label'			=> __( 'Email address 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your email address, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'email_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'email_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'email_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['whatsapp'] = array(
			'title'					=> __( 'WhatsApp', 'wb-social-media-chat' ),
			'description'			=> __( 'WhatsApp settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'whatsapp',
					'label'			=> __( 'WhatsApp number' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your WhatsApp number, or leave empty to disable this button. You need to use international format and you need to omit any zeroes, brackets or dashes when adding the phone number in international format. For exmaple, use: 15551234567. More info here: <a target="_blank" href="https://faq.whatsapp.com/en/general/21016748">https://faq.whatsapp.com/en/general/21016748</a>', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> '15551234567'
				),
				array(
					'id' 			=> 'hide_on_desktop_whatsapp',
					'label'			=> __( 'Hide WhatsApp on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide WhatsApp on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_whatsapp',
					'label'			=> __( 'Hide WhatsApp on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide WhatsApp on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'whatsapp_box',
					'label'			=> __( 'WhatsApp message area' , 'wb-social-media-chat' ),
					'description'	=> __( 'If enabled, a message box with textarea will be opened when user cliks the WhatsApp button.', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'whatsapp_message',
					'label'			=> __( 'WhatsApp box message' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your default message here, for the WhatsApp box.', 'wb-social-media-chat' ),
					'type'			=> 'textarea',
					'default'		=> 'Please type your message here to chat with us on WhatsApp.',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'whatsapp_messagebox_height',
					'label'			=> __( 'WhatsApp message box height' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your WhatsApp message box height in pixels here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '115',
					'placeholder'	=> '115'
				),
				array(
					'id' 			=> 'whatsapp_header',
					'label'			=> __( 'WhatsApp box header text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your WhatsApp box header text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'WhatsApp',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'whatsapp_submit',
					'label'			=> __( 'WhatsApp submit text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your WhatsApp box submit text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Send',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'whatsapp_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'whatsapp_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'whatsapp_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'whatsapp2',
					'label'			=> __( 'WhatsApp number 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your second WhatsApp number, or leave empty to disable this feature. You need to use international format and you need to omit any zeroes, brackets or dashes when adding the phone number in international format. For exmaple, use: 15551234567. More info here: <a target="_blank" href="https://faq.whatsapp.com/en/general/21016748">https://faq.whatsapp.com/en/general/21016748</a>', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'whatsapp_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'whatsapp_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'whatsapp_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'whatsapp3',
					'label'			=> __( 'WhatsApp number 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your second WhatsApp number, or leave empty to disable this feature. You need to use international format and you need to omit any zeroes, brackets or dashes when adding the phone number in international format. For exmaple, use: 15551234567. More info here: <a target="_blank" href="https://faq.whatsapp.com/en/general/21016748">https://faq.whatsapp.com/en/general/21016748</a>', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'whatsapp_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'whatsapp_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'whatsapp_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['line'] = array(
			'title'					=> __( 'LINE', 'wb-social-media-chat' ),
			'description'			=> __( 'LINE settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'line',
					'label'			=> __( 'LINE ID' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your LINE ID, or leave empty to disable this button. You need to have LINE Official Account to use this feature. More info: <a href="https://manager.line.biz" target="_blank">https://manager.line.biz</a>', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'hide_on_desktop_line',
					'label'			=> __( 'Hide LINE on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide LINE on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_line',
					'label'			=> __( 'Hide LINE on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide LINE on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'line_header',
					'label'			=> __( 'Line box header text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your Line box header text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Line',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'line_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'line_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'line_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'line2',
					'label'			=> __( 'Line ID 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your LINE ID, or leave empty to disable this button. You need to have LINE ID set on your phone app, and you need to enable option to let others to add you by your ID. More info can be found at <a href="https://help.line.me/line/ios/?contentId=20000126" target="_blank">https://help.line.me/line/ios/?contentId=20000126</a>', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'line_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'line_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'line_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'line3',
					'label'			=> __( 'Line ID 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your LINE ID, or leave empty to disable this button. You need to have LINE ID set on your phone app, and you need to enable option to let others to add you by your ID. More info can be found at <a href="https://help.line.me/line/ios/?contentId=20000126" target="_blank">https://help.line.me/line/ios/?contentId=20000126</a>', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'line_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'line_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'line_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['telegram'] = array(
			'title'					=> __( 'Telegram', 'wb-social-media-chat' ),
			'description'			=> __( 'Telegram settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'telegram',
					'label'			=> __( 'Telegram ID' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Telegram username, or leave empty to disable this button. Set this on your mobile app, by clicking your profile and choosing "Username"', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'hide_on_desktop_telegram',
					'label'			=> __( 'Hide Telegram on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide Telegram on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_telegram',
					'label'			=> __( 'Hide Telegram on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide Telegram on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'telegram_header',
					'label'			=> __( 'Telegram box header text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your Telegram box header text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Telegram',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'telegram_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'telegram_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'telegram_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'telegram2',
					'label'			=> __( 'Telegram username 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Telegram username 2, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'telegram_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'telegram_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'telegram_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'telegram3',
					'label'			=> __( 'Telegram username 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Telegram username 3, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'telegram_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'telegram_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'telegram_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['skype'] = array(
			'title'					=> __( 'Skype', 'wb-social-media-chat' ),
			'description'			=> __( 'Skype settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'skype',
					'label'			=> __( 'Skype  name' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Skype  name, or leave empty to disable this button. Use your skype account name id here. More info: <a href="https://support.skype.com/en/faq/FA10858/what-s-my-skype-name" target="_blank">https://support.skype.com/en/faq/FA10858/what-s-my-skype-name</a>', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'hide_on_desktop_skype',
					'label'			=> __( 'Hide Skype on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide Skype on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_skype',
					'label'			=> __( 'Hide Skype on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide Skype on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'skype_header',
					'label'			=> __( 'Skype box header text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your Skype box header text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Skype',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'skype_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'skype_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'skype_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'skype2',
					'label'			=> __( 'Skype  name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Skype  name, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'skype_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'skype_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'skype_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'skype3',
					'label'			=> __( 'Skype  name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Skype  name, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'skype_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'skype_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'skype_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['facebook'] = array(
			'title'					=> __( 'Facebook Messenger', 'wb-social-media-chat' ),
			'description'			=> __( 'Facebook Messenger settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'facebook',
					'label'			=> __( 'Facebook id' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Facebook id, or leave empty to disable this button. https://www.facebook.com/YOUR_ID', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'hide_on_desktop_facebook',
					'label'			=> __( 'Hide Facebook Messenger on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide Facebook Messenger on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_facebook',
					'label'			=> __( 'Hide Facebook Messenger on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide Facebook Messenger on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'fb_mobile_action',
					'label'			=> __( 'Mobile action' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your action when user clicks the channel button.', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'app' 	=> 'Open App', 
						'web' 	=> 'Open Facebook Mobile' ),
					'default'		=> 'app'
				),
				array(
					'id' 			=> 'facebook_header',
					'label'			=> __( 'Facebook box header text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your Facebook box header text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Facebook',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'facebook_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'facebook_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'facebook_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'facebook2',
					'label'			=> __( 'Facebook ID 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Facebook ID, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'facebook_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'facebook_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'facebook_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'facebook3',
					'label'			=> __( 'Facebook ID 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Facebook ID, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'facebook_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'facebook_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'facebook_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['vk'] = array(
			'title'					=> __( 'VKontakte', 'wb-social-media-chat' ),
			'description'			=> __( 'VKontakte settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'vk',
					'label'			=> __( 'VK username' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your VK id (short name), or leave empty to disable this button. Find your id on your mobile app: Click settings (cog in the top corner) - Account - Short name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'hide_on_desktop_vk',
					'label'			=> __( 'Hide VK Messenger on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide VK Messenger on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_vk',
					'label'			=> __( 'Hide VK Messenger on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide VK Messenger on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'vkontakte_header',
					'label'			=> __( 'Vkontakte box header text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your Vkontakte box header text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Vkontakte',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'vkontakte_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'vkontakte_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'vkontakte_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'vkontakte2',
					'label'			=> __( 'Vkontakte ID 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Vkontakte ID, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'vkontakte_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'vkontakte_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'vkontakte_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'vkontakte3',
					'label'			=> __( 'Vkontakte ID 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Vkontakte ID, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'vkontakte_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'vkontakte_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'vkontakte_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['viber'] = array(
			'title'					=> __( 'Viber', 'wb-social-media-chat' ),
			'description'			=> __( 'Viber settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'viber',
					'label'			=> __( 'Viber number' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Viber number here. You need to use international format and you need to omit any zeroes, brackets or dashes when adding the phone number in international format and use + as the first character. For exmaple if your area code is 1 and your phone number is 5551234567, use: +15551234567.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'hide_on_desktop_viber',
					'label'			=> __( 'Hide Viber on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide Viber on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_viber',
					'label'			=> __( 'Hide Viber on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide Viber on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'viber_header',
					'label'			=> __( 'Viber box header text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your Viber box header text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Viber',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'viber_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'viber_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'viber_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'viber2',
					'label'			=> __( 'Viber number 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Viber number, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'viber_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'viber_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'viber_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'viber3',
					'label'			=> __( 'Viber number 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your Viber number, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'viber_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'viber_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'viber_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['custom'] = array(
			'title'					=> __( 'Custom', 'wb-social-media-chat' ),
			'description'			=> __( 'Custom channel settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'custom_url',
					'label'			=> __( 'Custom url' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your url here, or leave empty to disable this button.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'custom_icon',
					'label'			=> __( 'Custom icon' , 'wb-social-media-chat' ),
					'description'	=> __( 'Plugin uses Font Awesome icons, and here you can place your own icon. For example: fas fa-location-arrow. All available icons can be found here: <a href="https://fontawesome.com/icons/" target="_blank">https://fontawesome.com/icons/</a>', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'fas fa-location-arrow'
				),
				array(
					'id' 			=> 'hide_on_desktop_custom',
					'label'			=> __( 'Hide custom link on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide custom link on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_custom',
					'label'			=> __( 'Hide custom link on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide custom link on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'custom_header',
					'label'			=> __( 'custom box header text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your custom box header text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Contact us',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'custom',
					'label'			=> __( 'Custom id' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your custom id here, or leave empty to disable this button.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'custom_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'custom_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'custom_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'custom2',
					'label'			=> __( 'Custom ID 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your custom ID, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'custom_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'custom_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'custom_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'custom3',
					'label'			=> __( 'Custom ID 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your custom ID, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'custom_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'custom_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'custom_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['phone'] = array(
			'title'					=> __( 'Phone', 'wb-social-media-chat' ),
			'description'			=> __( 'Phone number settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'phone',
					'label'			=> __( 'Phone number' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your phone number, or leave empty to disable this button.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '15551234567',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'hide_on_desktop_phone',
					'label'			=> __( 'Hide phone number on desktop devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide phone number on desktop devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'hide_on_mobile_phone',
					'label'			=> __( 'Hide phone number on mobile devices?' , 'wb-social-media-chat' ),
					'description'	=> __( 'Set true to hide phone number on mobile devices', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'phone_header',
					'label'			=> __( 'Phone box header text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Please type your phone box header text here.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Call us',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'phone_box_agent',
					'label'			=> __( 'Agent name' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'phone_box_agent_title',
					'label'			=> __( 'Agent title' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'phone_box_agent_img',
					'label'			=> __( 'Agent image' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'phone2',
					'label'			=> __( 'Phone number 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your phone number, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'phone_box_agent2',
					'label'			=> __( 'Agent name 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'phone_box_agent_title2',
					'label'			=> __( 'Agent title 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'phone_box_agent_img2',
					'label'			=> __( 'Agent image 2' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'phone3',
					'label'			=> __( 'Phone number 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your phone number, or leave empty to disable this feature.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'phone_box_agent3',
					'label'			=> __( 'Agent name 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s name is shown in the chatbox', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'John Doe'
				),
				array(
					'id' 			=> 'phone_box_agent_title3',
					'label'			=> __( 'Agent title 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s title is shown in the chatbox under the chat agent´s name', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> 'Support agent'
				),
				array(
					'id' 			=> 'phone_box_agent_img3',
					'label'			=> __( 'Agent image 3' , 'wb-social-media-chat' ),
					'description'	=> __( 'If set, chat agent´s photo is shown in the chatbox. Use square shaped image. Preferred size is 256x256 pixels.', 'wb-social-media-chat' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);

		$settings['pro'] = array(
			'title'					=> __( 'Advanced Settings', 'wb-social-media-chat' ),
			'description'			=> __( 'Social Network Chat advanced package settings.', 'wb-social-media-chat' ),
			'fields'				=> array(
				array(
					'id' 			=> 'analytics_support',
					'label'			=> __( 'Enable Google Analytics support' , 'wb-social-media-chat' ),
					'description'	=> __( 'If selected, everytime user clicks one of the icons, a Google Analytics event will be launched.', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'true'
				),
				array(
					'id' 			=> 'woocommerce_support',
					'label'			=> __( 'Enable WooCommerce button' , 'wb-social-media-chat' ),
					'description'	=> __( 'Contact button can be hooked on a WooCommerce product page. Hook can be chosen below, or choose "false" if you dont want to use this option.', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'false' => 'False',
						'before_add_to_cart' => 'Before add to cart button', 
						'after_add_to_cart' => 'After add to cart button', 
						'before_short_description' => 'Before short description', 
						'after_short_description' => 'After short description', 
					),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'shortcode_btn_text',
					'label'			=> __( 'Shortcode button text' , 'wb-social-media-chat' ),
					'description'	=> __( 'Add your text here for the [social-network-chat] shortcode contact button. Shortcode can be placed on any page or post to show the contact button. Use shortcode <strong>[social-network-chat]</strong> to place your contact button.', 'wb-social-media-chat' ),
					'type'			=> 'text',
					'default'		=> 'Contact us',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'show_only_on_pages',
					'label'			=> __( 'Show contact buttons only on following pages', 'wb-social-media-chat' ),
					'description'	=> __( 'If you want to show the contact buttons only on specific pages, you can select them here. Use Ctrl or Cmd (Mac) to select multiple pages.', 'wb-social-media-chat' ),
					'type'			=> 'select_multi',
					'options'		=> $pagesArr,
					'default'		=> ''
				),
				array(
					'id' 			=> 'popup_pulse',
					'label'			=> __( 'PopUp pulse' , 'wb-social-media-chat' ),
					'description'	=> __( 'Enable pulse effect for chat button.', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'popup_notice',
					'label'			=> __( 'PopUp notice' , 'wb-social-media-chat' ),
					'description'	=> __( 'Small popup will be visible over the contact button for the user after 10 seconds if enabled.', 'wb-social-media-chat' ),
					'type'			=> 'select',
					'options'		=> array( 
						'true' => 'True', 
						'false' => 'False' ),
					'default'		=> 'false'
				),
				array(
					'id' 			=> 'popup_message',
					'label'			=> __( 'PopUp box message' , 'wb-social-media-chat' ),
					'description'	=> __( 'Place your default message here, for the PopUp notice.', 'wb-social-media-chat' ),
					'type'			=> 'textarea',
					'default'		=> 'Hello, would you like to know more about our services?',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'chat_btn_color',
					'label'			=> __( 'Chat button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your chat button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#68467e',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'whatsapp_btn_color',
					'label'			=> __( 'WhatsApp button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your WhatsApp button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#59a736',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'line_btn_color',
					'label'			=> __( 'LINE button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your LINE button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#67ba0f',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'viber_btn_color',
					'label'			=> __( 'Viber button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your Viber button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#7c5594',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'skype_btn_color',
					'label'			=> __( 'Skype button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your Skype button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#00aff0',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'telegram_btn_color',
					'label'			=> __( 'Telegram button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your Telegram button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#2ba6e1',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'facebook_btn_color',
					'label'			=> __( 'Facebook button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your Facebook button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#3a559f',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'vk_btn_color',
					'label'			=> __( 'VKontakte button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your VKontakte button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#3a559f',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'custom_btn_color',
					'label'			=> __( 'Custom button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your Custom button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#6bc10f',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'phone_btn_color',
					'label'			=> __( 'Phone button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your Phone button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#23838f',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'email_btn_color',
					'label'			=> __( 'Email button color' , 'wb-social-media-chat' ),
					'description'	=> __( 'Select your Email button color.', 'wb-social-media-chat' ),
					'type'			=> 'color',
					'default'		=> '#59a736',
					'placeholder'	=> ''
				),
	
			),
		);

		$settings = apply_filters( $this->parent->_token . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings () {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = sanitize_text_field($_POST['tab']);
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = sanitize_text_field($_GET['tab']);
				}
			}

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section != $section ) continue;

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->base . $field['id'];
					register_setting( $this->parent->_token . '_settings', $option_name, $validation );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), $this->parent->_token . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ) );
				}

				if ( ! $current_section ) break;
			}
		}
	}

	public function settings_section ( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page_license () {
		// Build page HTML
		$html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
		$html .= '<h2>' . __( 'Social Network Chat License' , 'wb-social-media-chat' ) . '</h2>' . "\n";
		$html .= '<div id="settings_page_license"></div>' . "\n";

		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page_support () {
		// Build page HTML
		$html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
		$html .= '<h2>' . __( 'Social Network Chat Support' , 'wb-social-media-chat' ) . '</h2>' . "\n";

		$html .= '<div id="settings_page_support"></div>' . "\n";				
		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page () {

		// Build page HTML
		$html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
			$html .= '<h2>' . __( 'Social Network Chat Settings' , 'wb-social-media-chat' ) . '</h2>' . "\n";

			$tab = '';
			if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
				$tab .= sanitize_text_field($_GET['tab']);
			}

			// Show page tabs
			if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

				$html .= '<h2 class="nav-tab-wrapper">' . "\n";

				$c = 0;
				foreach ( $this->settings as $section => $data ) {

					// Set tab class
					$class = 'nav-tab';
					if ( ! isset( $_GET['tab'] ) ) {
						if ( 0 == $c ) {
							$class .= ' nav-tab-active';
						}
					} else {
						if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
							$class .= ' nav-tab-active';
						}
					}

					// Set tab link
					$tab_link = add_query_arg( array( 'tab' => $section ) );
					if ( isset( $_GET['settings-updated'] ) ) {
						$tab_link = remove_query_arg( 'settings-updated', $tab_link );
					}

					// Output tab
					$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

					++$c;
				}

				$html .= '</h2>' . "\n";
			}

			$html .= '<div class="settings_page_enabled">' . "\n";
			
				$html .= '<form class="settings_form" method="post" action="options.php" enctype="multipart/form-data">' . "\n";

						// Get settings fields
						ob_start();
						settings_fields( $this->parent->_token . '_settings' );
						do_settings_sections( $this->parent->_token . '_settings' );
						$html .= ob_get_clean();

						$html .= '<p class="submit">' . "\n";
							$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
							$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'wb-social-media-chat' ) ) . '" />' . "\n";
						$html .= '</p>' . "\n";
					$html .= '</form>' . "\n";
				$html .= '</div>' . "\n";

			$html .= '</div>' . "\n";

		echo $html;
	}

	/**
	 * Main WB_Social_Media_Chat_Settings Instance
	 *
	 * Ensures only one instance of WB_Social_Media_Chat_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WB_Social_Media_Chat()
	 * @return Main WB_Social_Media_Chat_Settings instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __wakeup()

}