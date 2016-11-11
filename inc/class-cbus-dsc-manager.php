<?php
class CBUS_DSC_Manager {

	protected $loader;
	protected $plugin_slug;
	protected $version;

	public function __construct() {
		$this->plugin_slug = 'cbus-dsc-manager-slug';
		$this->version = '0.1.0';

		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cbus-dsc-manager-admin.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-cbus-dsc-manager-loader.php';
		$this->loader = new CBUS_DSC_Manager_Loader();
	}

	private function define_admin_hooks() {
		$admin = new CBUS_DSC_Manager_Admin( $this->get_version() );

		$this->loader->add_action( 'admin_init', $admin, 'register_cbus_dsc_setting' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts_and_styles');
		$this->loader->add_action( 'admin_menu', $admin, 'create_cbus_dsc_menu_admin' );

	}

	private function get_version() {
		return $this->version;
	}

	public function run() {
		$this->loader->run();
	}
}