<?php

namespace OnePageExpress;


class Companion_Plugin {
	public static $plugin_state;
	public static $config = array();
	private static $instance = false;
	private static $slug;

	function __construct( $config ) {
		self::$config = $config;
		self::$slug   = $config['slug'];
		add_action( 'tgmpa_register', array( __CLASS__, 'tgma_register' ) );
		add_action( 'wp_ajax_companion_disable_popup', array( __CLASS__, 'companion_disable_popup' ) );

		if ( ! get_option( 'one_page_express_companion_disable_popup', false ) ) {
			if ( ! defined( "OPE_COMPANION_AUTOLOAD" ) ) {
				global $pagenow;
				if ( $pagenow !== "update.php" ) {
					add_action( 'admin_notices', array( __CLASS__, 'plugin_notice' ) );
					add_action( 'admin_head', function () {
						wp_enqueue_style( 'one_page_express_customizer_css', get_template_directory_uri() . '/customizer/css/companion-install.css' );
					} );
				}
			}
		}
	}


	public static function plugin_notice() {
		?>
        <div class="notice notice-success is-dismissible materialis-welcome-notice">
            <div class="notice-content-wrapper">
				<?php require_once( get_template_directory() . "/customizer/start-with-frontpage.php" ); ?>
            </div>
        </div>
		<?php
	}

	public static function companion_disable_popup() {
		$nonce = @$_POST['companion_disable_popup_wpnonce'];

		if ( ! wp_verify_nonce( $nonce, "companion_disable_popup" ) ) {
			die( "wrong nonce" );
		}

		$value = intval( @$_POST['value'] );

		update_option( "one_page_express_companion_disable_popup", $value );
	}

	public static function tgma_register() {
		self::$plugin_state = self::get_plugin_state( self::$slug );
	}

	public static function get_plugin_state( $plugin_slug ) {
		$tgmpa     = \TGM_Plugin_Activation::get_instance();
		$installed = $tgmpa->is_plugin_installed( $plugin_slug );

		return array(
			'installed' => $installed,
			'active'    => $installed && $tgmpa->is_plugin_active( $plugin_slug ),
		);
	}

	public static function output_companion_message() {
		wp_enqueue_style( 'one_page_express_customizer_css', get_template_directory_uri() . '/customizer/css/companion-install.css' );
		wp_enqueue_script( 'one_page_express_customizer_css', get_template_directory_uri() . '/customizer/js/companion-install.js' );
		?>
        <div id="extend-themes-companion-popover" style="display:none">
            <div class="extend-themes-companion-popover-close dashicons dashicons-no-alt"></div>
            <div class="extend-themes-companion-popover-wrapper">
                <p class="extend-themes-companion-popover-message"><?php _e( 'Please Install the One Page Express Companion Plugin to Enable All the Theme Features', 'one-page-express' ) ?></p>
                <div class="extend-themes-companion-popover-actions">
					<?php
					if ( self::$plugin_state['installed'] ) {
						$link  = Companion_Plugin::get_activate_link();
						$label = __( 'Activate now', 'one-page-express' );
					} else {
						$link  = Companion_Plugin::get_install_link();
						$label = __( 'Install now', 'one-page-express' );
					}
					printf( '<a class="install-now button button-large button-primary" href="%1$s">%2$s</a>', esc_url( $link ), $label );
					?>
                </div>
            </div>
        </div>
		<?php
	}

	public static function get_activate_link( $slug = false ) {
		if ( ! $slug ) {
			$slug = self::$slug;
		}
		$tgmpa = \TGM_Plugin_Activation::get_instance();
		$path  = $tgmpa->plugins[ $slug ]['file_path'];

		return add_query_arg( array(
			'action'        => 'activate',
			'plugin'        => rawurlencode( $path ),
			'plugin_status' => 'all',
			'paged'         => '1',
			'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $path ),
		), network_admin_url( 'plugins.php' ) );
	}

	public static function get_install_link( $slug = false ) {
		if ( ! $slug ) {
			$slug = self::$slug;
		}

		return add_query_arg(
			array(
				'action'   => 'install-plugin',
				'plugin'   => $slug,
				'_wpnonce' => wp_create_nonce( 'install-plugin_' . $slug ),
			),
			network_admin_url( 'update.php' )
		);
	}

	public static function check_companion( $wp_customize ) {
		$plugin_state = self::$plugin_state;

		if ( ! $plugin_state ) {
			return;
		}

		if ( ! $plugin_state['installed'] || ! $plugin_state['active'] ) {

			$wp_customize->add_setting( 'one_page_express_companion_install', array(
				'default'           => '',
				'sanitize_callback' => 'esc_attr',
			) );


			if ( ! $plugin_state['installed'] ) {
				$wp_customize->add_control(
					new Install_Companion_Control(
						$wp_customize,
						'one_page_express_page_content',
						array(
							'section'      => 'one_page_express_page_content',
							'settings'     => 'one_page_express_companion_install',
							'label'        => self::$config['install_label'],
							'msg'          => self::$config['install_msg'],
							'plugin_state' => $plugin_state,
							'slug'         => self::$slug,
						)
					)
				);
			} else {
				$wp_customize->add_control(
					new Activate_Companion_Control(
						$wp_customize,
						'one_page_express_page_content',
						array(
							'section'      => 'one_page_express_page_content',
							'settings'     => 'one_page_express_companion_install',
							'label'        => self::$config['activate_label'],
							'msg'          => self::$config['activate_msg'],
							'plugin_state' => $plugin_state,
							'slug'         => self::$slug,
						)
					)
				);
			}

			Companion_Plugin::show_companion_popup( $plugin_state );
		}
	}

	public static function show_companion_popup() {
		add_action( 'customize_controls_print_footer_scripts', array(
			'\OnePageExpress\Companion_Plugin',
			'output_companion_message'
		) );
	}

	// static functions

	public static function init( $config ) {
		Companion_Plugin::getInstance( $config );
	}

	public static function getInstance( $config ) {
		if ( ! self::$instance ) {
			self::$instance = new Companion_Plugin( $config );
		}

		return self::$instance;
	}
}
