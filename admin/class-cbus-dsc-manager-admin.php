<?php
class CBUS_DSC_Manager_Admin {
	protected $version;

	public function __construct( $version ) {
		$this->version = $version;
	}

	public function register_cbus_dsc_setting() {
		$option_name = 'cbus_dsc_options';

		$option_values = get_option( $option_name );

		$default_values = array(
			'duration'		=> 5000,
			'info_text1' 	=> '',
			'info_text2'	=> '',
			'info_text3'	=> '',
			'info_text4'	=> '',
			'info_text5'	=> '',
			'running_text'	=> 'Running Text',
			'youtube_link'	=> ''
			);

		$data = shortcode_atts( $default_values, $option_values );

		register_setting(
			'cbus_dsc_option_group',
			$option_name,
			array( $this, 'cbus_dsc_validate_option_cb')
			);

		add_settings_section(
			'cbus_dsc_info_text_section',
			'Pengaturan Info',
			array( $this, 'cbus_dsc_render_info_text_section_cb'),
			'cbus_dsc'
			);

		add_settings_section(
			'cbus_dsc_running_text_section',
			'Pengaturan running text',
			array( $this, 'cbus_dsc_render_running_text_section_cb' ),
			'cbus_dsc'
			);

		add_settings_section(
			'cbus_dsc_youtube_section',
			'Pengaturan Youtube',
			array( $this, 'cbus_dsc_render_youtube_section_cb'),
			'cbus_dsc'
			);

		add_settings_field(
			'cbus_dsc_info_text1_field_text',
			__( 'Text Info 1', 'cbus_dsc'),
			array( $this, 'cbus_dsc_info_text_field_text_cb'),
			'cbus_dsc',
			'cbus_dsc_info_text_section',
			[
				'label_for'				=> 'cbus_dsc_field_info_text1',
				'class'					=> 'w3-label',
				'name'					=> 'info_text1',
				'value'					=> esc_attr( $data['info_text1']),
				'option_name'			=> $option_name
			]
			);

		add_settings_field(
			'cbus_dsc_info_text2_field_text',
			__( 'Text Info 2', 'cbus_dsc'),
			array( $this, 'cbus_dsc_info_text_field_text_cb'),
			'cbus_dsc',
			'cbus_dsc_info_text_section',
			[
				'label_for'				=> 'cbus_dsc_field_info_text2',
				'class'					=> 'w3-label',
				'name'					=> 'info_text2',
				'value'					=> esc_attr( $data['info_text2']),
				'option_name'			=> $option_name
			]
			);

		add_settings_field(
			'cbus_dsc_info_text3_field_text',
			__( 'Text Info 3', 'cbus_dsc'),
			array( $this, 'cbus_dsc_info_text_field_text_cb'),
			'cbus_dsc',
			'cbus_dsc_info_text_section',
			[
				'label_for'				=> 'cbus_dsc_field_info_text3',
				'class'					=> 'w3-label',
				'name'					=> 'info_text3',
				'value'					=> esc_attr( $data['info_text3']),
				'option_name'			=> $option_name
			]
			);

		add_settings_field(
			'cbus_dsc_info_text4_field_text',
			__( 'Text Info 4', 'cbus_dsc'),
			array( $this, 'cbus_dsc_info_text_field_text_cb'),
			'cbus_dsc',
			'cbus_dsc_info_text_section',
			[
				'label_for'				=> 'cbus_dsc_field_info_text4',
				'class'					=> 'w3-label',
				'name'					=> 'info_text4',
				'value'					=> esc_attr( $data['info_text4']),
				'option_name'			=> $option_name
			]
			);

		add_settings_field(
			'cbus_dsc_info_text5_field_text',
			__( 'Text Info 5', 'cbus_dsc'),
			array( $this, 'cbus_dsc_info_text_field_text_cb'),
			'cbus_dsc',
			'cbus_dsc_info_text_section',
			[
				'label_for'				=> 'cbus_dsc_field_info_text5',
				'class'					=> 'w3-label',
				'name'					=> 'info_text5',
				'value'					=> esc_attr( $data['info_text5']),
				'option_name'			=> $option_name
			]
			);

		add_settings_field(
			'cbus_dsc_running_text_field_text',
			__( 'Running Text', 'cbus_dsc' ),
			array( $this, 'cbus_dsc_running_text_field_text_cb'),
			'cbus_dsc',
			'cbus_dsc_running_text_section',
			[
				'label_for'				=> 'cbus_dsc_field_running_text',
				'class'					=> 'w3-label',
				'name'					=> 'running_text',
				'value'					=> esc_textarea( $data['running_text'] ),
				'option_name'			=> $option_name
			]
			);

		add_settings_field(
			'cbus_dsc_running_text_field_duration',
			__( 'Duration', 'cbus_dsc' ),
			array( $this, 'cbus_dsc_running_text_field_duration_cb'),
			'cbus_dsc',
			'cbus_dsc_running_text_section',
			[
				'label_for'				=> 'cbus_dsc_field_running_duration',
				'class'					=> 'w3-label',
				'name'					=> 'duration',
				'value'					=> esc_attr( $data['duration'] ),
				'option_name'			=> $option_name
			]
			);

		add_settings_field(
			'cbus_dsc_youtube_field_link',
			__( 'Link', 'cbus_dsc'),
			array( $this, 'cbus_dsc_youtube_link_field_cb'),
			'cbus_dsc',
			'cbus_dsc_youtube_section',
			[
				'label_for'		=> 'cbus_dsc_field_youtube_link',
				'class'			=> 'w3-label',
				'name'			=> 'youtube_link',
				'value'			=> esc_attr( $data['youtube_link'] ),
				'option_name'	=> $option_name
			]
			);
	}

	public function cbus_dsc_validate_option_cb( $values ) {
		$default_values = array(
			'duration'		=> 5000,
			'info_text1'	=> '',
			'info_text2'	=> '',
			'info_text3'	=> '',
			'info_text4'	=> '',
			'info_text5'	=> '',
			'running_text'	=> 'Running Text',
			'youtube_link'	=> ''
			);

		if( !is_array($values)) return $default_values;

		$out = array();

		foreach ( $default_values as $key => $value) {
			if( empty($values[$key])) {
				$out[$key] = $value;
			}else {
				if( 'duration' === $key ) {
					if( 0 > $values[$key] ) {
						add_settings_error( 'cbus_dsc_option_group', 'duration-too-low', 'Durasi harus lebih lebih besar dari 0 (milidetik)');
					}
					else if (! is_numeric($values[$key])) {
						add_settings_error( 'cbus_dsc_option_group', 'duration-not-valid','Durasi harus berupa angka' );
					}
					else {
						$out[$key] = $values[$key];
					}
				}else {
					$out[$key] = $values[$key];
				}
			}
		}

		return $out;
	}

	public function cbus_dsc_render_running_text_section_cb( $args ) {
		?>
		<p>Pengaturan running text.</p>
		<?php
	}

	public function cbus_dsc_render_info_text_section_cb( $args ) {
		?>
		<p>Pengaturan info</p>
		<?php
	}

	public function cbus_dsc_render_youtube_section_cb( $args ) {
		?>
		<p>Pengaturan Youtube</p>
		<?php
	}

	public function cbus_dsc_info_text_field_text_cb( $args ) {
		?>
		<input type="text" class="w3-input" name="<?php echo $args['option_name'] ?>[<?php echo $args['name']; ?>]" value="<?php echo $args['value']; ?>" />
		<?php
	}

	public function cbus_dsc_running_text_field_text_cb( $args ) {
		$options = get_option('cbus_dsc_options'); 
		?>
		<textarea class="w3-input" name="<?php echo $args['option_name'] ?>[<?php echo $args['name']; ?>]"><?php echo $args['value']; ?></textarea>
		<?php
	}

	public function cbus_dsc_running_text_field_duration_cb($args) {
		?>
		<input type="text" name="<?php echo $args['option_name'] ?>[<?php echo $args['name']; ?>]" value="<?php echo $args['value'] ?>" id="<?php echo $args['label_for']; ?>" />
		<?php
	}

	public function cbus_dsc_youtube_link_field_cb ($args) {
		?>
		<input type="text" class="w3-input" name="<?php echo $args['option_name'] ?>[<?php echo $args['name']; ?>]" value="<?php echo $args['value'] ?>" id="<?php echo $args['label_for']; ?>" />
		<?php
	}

	public function enqueue_scripts_and_styles() {

		wp_enqueue_style(
			'w3css',
			plugin_dir_url( __FILE__ ) . 'css/w3.css',
			array(),
			'',
			'all'
			);

		wp_enqueue_style(
			'cbus-dsc-manager-admin-style',
			plugin_dir_url( __FILE__ ) . 'css/cbus-dsc-manager-admin.css',
			array(),
			$this->version,
			FALSE
			);

		wp_register_script(
			'cbus-dsc-script',
			plugin_dir_url( __FILE__ ) . 'js/cbus-dsc.js'
			);
		wp_enqueue_script( 'cbus-dsc-script' );

		wp_localize_script(
			'cbus-dsc-script',
			'cbus_dsc_ajax',
			array(
				'ajaxurl'	=> admin_url('admin-ajax.php')
				)
			);

	}

	public function create_cbus_dsc_menu_admin() {
		add_menu_page(
			'CBUS DSC',
			'<b style="color:#ff0000">CBUS DSC</b>',
			'manage_options',
			'cbus-dsc-dashboard',
			array( $this, 'render_cbus_dsc_dashboard'),
			plugins_url ( 'images/cbus-logo.png', __FILE__),
			'0.1.0'
			);

	}

	public function render_cbus_dsc_dashboard() {
		$this->get_html_template('dashboard-dsc');
	}

	private function get_html_template( $file, $attributes = null ) {
		if( ! $attributes ) {
			$attributes = array();
		}

		ob_start();
		require( $file . '.php' );
		$html = ob_get_contents();
		ob_end_clean();

		echo $html;
	}
}