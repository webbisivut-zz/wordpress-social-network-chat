<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WB_Social_Media_Chat {

	/**
	 * The single instance of WB_Social_Media_Chat.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Settings class object
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token;

	/**
	 * The main plugin file.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;

	/**
	 * The plugin assets directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_dir;

	/**
	 * The plugin assets URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_url;

	/**
	 * The plugin bundle JS URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $bundle_url;

	/**
	 * Suffix for Javascripts.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $script_suffix;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token = 'wb_social_media_chat';

		// Load plugin environment variables
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );
		$this->bundle_url = esc_url( trailingslashit( plugins_url( '/dist/js/', $this->file ) ) );

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		register_activation_hook( $this->file, array( $this, 'install' ) );

		// Load frontend JS & CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

		// Load admin CSS
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );

		// Load API for generic admin functions
		if ( is_admin() ) {
			$this->admin = new WB_Social_Media_Chat_Admin_API();
		}

		// Handle localisation
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );
	} // End __construct ()

	/**
	 * Load frontend CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function enqueue_styles () {
		wp_register_style( $this->_token . '-font-awesome', esc_url( $this->assets_url ) . 'css/all.min.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-font-awesome' );

		wp_register_style( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'css/frontend.min.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-frontend' );
	} // End enqueue_styles ()

	/**
	 * Load frontend Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function enqueue_scripts () {
		$analytics_support = esc_attr(get_option('wb_cta_analytics_support'));
		$popup_notice = esc_attr(get_option('wb_cta_popup_notice'));

		$whatsapp_box = esc_attr(get_option('wb_cta_whatsapp_box'));
		$whatsapp_box_agent = esc_attr(get_option('wb_cta_whatsapp_box_agent'));
		$whatsapp2 = esc_attr(get_option('wb_cta_whatsapp2'));
		$whatsapp3 = esc_attr(get_option('wb_cta_whatsapp3'));

		if($whatsapp_box == 'true' OR $whatsapp_box_agent != '' OR $whatsapp2 != '' OR $whatsapp3 != '') {
			wp_register_script( $this->_token . '-whatsapp', esc_url( $this->assets_url ) . 'js/whatsapp.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-whatsapp' );
		}

		$line_box_agent = esc_attr(get_option('wb_cta_line_box_agent'));
		$line2 = esc_attr(get_option('wb_cta_line2'));
		$line3 = esc_attr(get_option('wb_cta_line3'));

		if($line_box_agent != '' OR $line2 != '' OR $line3 != '') {
			wp_register_script( $this->_token . '-line', esc_url( $this->assets_url ) . 'js/line.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-line' );
		}

		$telegram_box_agent = esc_attr(get_option('wb_cta_telegram_box_agent'));
		$telegram2 = esc_attr(get_option('wb_cta_telegram2'));
		$telegram3 = esc_attr(get_option('wb_cta_telegram3'));

		if($telegram_box_agent != '' OR $telegram2 != '' OR $telegram3 != '') {
			wp_register_script( $this->_token . '-telegram', esc_url( $this->assets_url ) . 'js/telegram.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-telegram' );
		}

		$skype_box_agent = esc_attr(get_option('wb_cta_skype_box_agent'));
		$skype2 = esc_attr(get_option('wb_cta_skype2'));
		$skype3 = esc_attr(get_option('wb_cta_skype3'));

		if($skype_box_agent != '' OR $skype2 != '' OR $skype3 != '') {
			wp_register_script( $this->_token . '-skype', esc_url( $this->assets_url ) . 'js/skype.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-skype' );
		}

		$facebook_box_agent = esc_attr(get_option('wb_cta_facebook_box_agent'));
		$facebook2 = esc_attr(get_option('wb_cta_facebook2'));
		$facebook3 = esc_attr(get_option('wb_cta_facebook3'));

		if($facebook_box_agent != '' OR $facebook2 != '' OR $facebook3 != '') {
			wp_register_script( $this->_token . '-facebook', esc_url( $this->assets_url ) . 'js/facebook.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-facebook' );
		}

		$custom_box_agent = esc_attr(get_option('wb_cta_custom_box_agent'));
		$custom2 = esc_attr(get_option('wb_cta_custom2'));
		$custom3 = esc_attr(get_option('wb_cta_custom3'));

		if($custom_box_agent != '' OR $custom2 != '' OR $custom3 != '') {
			wp_register_script( $this->_token . '-custom', esc_url( $this->assets_url ) . 'js/custom.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-custom' );
		}

		$phone_box_agent = esc_attr(get_option('wb_cta_phone_box_agent'));
		$phone2 = esc_attr(get_option('wb_cta_phone2'));
		$phone3 = esc_attr(get_option('wb_cta_phone3'));

		if($phone_box_agent != '' OR $phone2 != '' OR $phone3 != '') {
			wp_register_script( $this->_token . '-phone', esc_url( $this->assets_url ) . 'js/phone.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-phone' );
		}

		$vkontakte_box_agent = esc_attr(get_option('wb_cta_vkontakte_box_agent'));
		$vkontakte2 = esc_attr(get_option('wb_cta_vkontakte2'));
		$vkontakte3 = esc_attr(get_option('wb_cta_vkontakte3'));

		if($vkontakte_box_agent != '' OR $vkontakte2 != '' OR $vkontakte3 != '') {
			wp_register_script( $this->_token . '-vkontakte', esc_url( $this->assets_url ) . 'js/vkontakte.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-vkontakte' );
		}

		$viber_box_agent = esc_attr(get_option('wb_cta_viber_box_agent'));
		$viber2 = esc_attr(get_option('wb_cta_viber2'));
		$viber3 = esc_attr(get_option('wb_cta_viber3'));

		if($viber_box_agent != '' OR $viber2 != '' OR $viber3 != '') {
			wp_register_script( $this->_token . '-viber', esc_url( $this->assets_url ) . 'js/viber.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-viber' );
		}

		if($analytics_support == 'true') {
			wp_register_script( $this->_token . '-g-analytics', esc_url( $this->assets_url ) . 'js/analytics.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-g-analytics' );
		}

		if($popup_notice == 'true') {
			wp_register_script( $this->_token . '-popup_notice', esc_url( $this->assets_url ) . 'js/popupnotice.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-popup_notice' );
		}

		wp_register_script( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'js/frontend.min.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-frontend' );	
		
		$visible_on_hover = esc_attr(get_option('wb_cta_visible_on_hover'));

		if($visible_on_hover == 'true') {
			wp_register_script( $this->_token . '-visibleonhover', esc_url( $this->assets_url ) . 'js/visibleonhover.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-visibleonhover' );
		}

		wp_register_script( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'js/frontend.min.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-frontend' );

		wp_localize_script( $this->_token . '-frontend', 'wbCtaAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

		$email_box_agent = esc_attr(get_option('wb_cta_email_box_agent'));
		$email2 = esc_attr(get_option('wb_cta_email2'));
		$email3 = esc_attr(get_option('wb_cta_email3'));

		$email_box = esc_attr(get_option('wb_cta_email_box'));

		if($email_box_agent != '' OR $email2 != '' OR $email3 != '' OR $email_box == 'true') {
			wp_register_script( $this->_token . '-email', esc_url( $this->assets_url ) . 'js/email.min.js', array( 'jquery' ), $this->_version );
			wp_enqueue_script( $this->_token . '-email' );
		}
	} // End enqueue_scripts ()

	/**
	 * Load admin CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_enqueue_styles ( $hook = '' ) {
		$pagesArr = [
			'wb_social_media_chat_support',
			'wb_social_media_chat_settings'
		];

		if(isset($_GET['page']) && in_array($_GET['page'], $pagesArr) ) {
			wp_register_style( $this->_token . '-admin', esc_url( $this->assets_url ) . 'css/admin.min.css', array(), $this->_version );
			wp_enqueue_style( $this->_token . '-admin' );

			wp_register_style( $this->_token . '-grid-system', esc_url( $this->assets_url ) . 'css/grid-system.min.css', array(), $this->_version );
			wp_enqueue_style( $this->_token . '-grid-system' );
		}
	} // End admin_enqueue_styles ()

	/**
	 * Load admin JS.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_enqueue_scripts ( $hook = '' ) {
		$allowedArr = [
			'wb_social_media_chat_support',
			'wb_social_media_chat_settings'
		];

		if(isset($_GET['page']) && in_array($_GET['page'], $allowedArr)) {
			//wp_register_script( $this->_token . '-bundle', esc_url( $this->bundle_url ) . 'bundle.js', array( 'jquery' ), $this->_version );
			//wp_enqueue_script( $this->_token . '-bundle' );

			//wp_localize_script( $this->_token . '-bundle', 'wb_sncAdminAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		}
	} // End admin_enqueue_styles ()

	/**
	 * Load plugin localisation
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'wb-social-media-chat', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation ()

	/**
	 * Load plugin textdomain
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'wb-social-media-chat';

	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain ()

	/**
	 * Main WB_Social_Media_Chat Instance
	 *
	 * Ensures only one instance of WB_Social_Media_Chat is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WB_Social_Media_Chat()
	 * @return Main WB_Social_Media_Chat instance
	 */
	public static function instance ( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance ()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __clone ()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __wakeup ()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install ()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	} // End _log_version_number ()

}