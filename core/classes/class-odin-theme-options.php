<?php
/**
 * Odin_Theme_Options class.
 *
 * Creates theme options pages.
 *
 * @package  Odin
 * @category Options
 * @author   WPBrasil
 * @version  3.0.0
 */
class Odin_Theme_Options {

	/**
	 * Settings tabs.
	 *
	 * @var array
	 */
	protected $tabs = array();

	/**
	 * Settings construct.
	 *
	 * @param string $id         Page id.
	 * @param string $title      Page title.
	 * @param string $capability User capability.
	 */
	public function __construct( $id, $title, $capability = 'manage_options' ) {
		$this->id         = $id;
		$this->title      = $title;
		$this->capability = $capability;

		// Actions.
		add_action( 'admin_menu', array( $this, 'create_page' ) );
		add_action( 'admin_init', array( $this, 'create_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	public function add_tab( $id, $name ) {
		$this->tabs[ $id ] = new Odin_Theme_Options_Tab( $id, $name );

		return $this->tabs[ $id ];
	}

	/**
	 * Add Settings Theme page.
	 *
	 * @return void
	 */
	public function create_page() {
		add_theme_page(
			$this->title,
			$this->title,
			$this->capability,
			$this->id,
			array( $this, 'settings_page' )
		);
	}

	/**
	 * Load options scripts.
	 *
	 * @return void
	 */
	function scripts() {
		// Checks if is the settings page.
		if ( isset( $_GET['page'] ) && $this->id == $_GET['page'] ) {

			// Color Picker.
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			// Media Upload.
			wp_enqueue_media();

			// jQuery UI.
			wp_enqueue_script( 'jquery-ui-sortable' );

			// Theme Options.
			wp_enqueue_style( 'odin-admin', get_template_directory_uri() . '/core/assets/css/admin.css', array(), null, 'all' );
			wp_enqueue_script( 'odin-admin', get_template_directory_uri() . '/core/assets/js/admin.js', array( 'jquery' ), null, true );

			// Localize strings.
			wp_localize_script(
				'odin-admin',
				'odinAdminParams',
				array(
					'galleryTitle'  => __( 'Add images in gallery', 'odin' ),
					'galleryButton' => __( 'Add in gallery', 'odin' ),
					'galleryRemove' => __( 'Remove image', 'odin' ),
					'uploadTitle'   => __( 'Choose a file', 'odin' ),
					'uploadButton'  => __( 'Add file', 'odin' ),
				)
			);
		}
	}

	/**
	 * Get current tab.
	 *
	 * @return string Current tab ID.
	 */
	protected function get_current_tab() {
		if ( isset( $_GET['tab'] ) ) {
			$current_tab = sanitize_title( $_GET['tab'] );
		} else {
			$tab = reset( $this->tabs );
			$current_tab = $tab->id;
		}

		return $current_tab;
	}

	/**
	 * Get the menu current URL.
	 *
	 * @return string Current URL.
	 */
	private function get_current_url() {
		$url = 'http';
		if ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) {
			$url .= 's';
		}

		$url .= '://';

		if ( '80' != $_SERVER['SERVER_PORT'] ) {
			$url .= $_SERVER['SERVER_NAME'] . ' : ' . $_SERVER['SERVER_PORT'] . $_SERVER['PHP_SELF'];
		} else {
			$url .= $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
		}

		return esc_url( $url );
	}

	/**
	 * Get tab navigation.
	 *
	 * @param  string $current_tab Current tab ID.
	 *
	 * @return string              Tab Navigation.
	 */
	protected function get_navigation( $current_tab ) {

		$html = '<h2 class="nav-tab-wrapper">';

		foreach ( $this->tabs as $tab ) {

			$current = ( $current_tab == $tab->id ) ? ' nav-tab-active' : '';

			$html .= sprintf( '<a href="%s?page=%s&amp;tab=%s" class="nav-tab%s">%s</a>', $this->get_current_url(), $this->id, $tab->id, $current, $tab->name );
		}

		$html .= '</h2>';

		echo $html;
	}

	/**
	 * Built settings page.
	 *
	 * @return void
	 */
	public function settings_page() {
		// Get current tag.
		$current_tab = $this->get_current_tab();

		// Opens the wrap.
		echo '<div class="wrap">';

			// Display the navigation menu.
			$this->get_navigation( $current_tab );

			// Display erros.
			settings_errors();

			// Creates the option form.
			echo '<form method="post" action="options.php">';
				foreach ( $this->tabs as $tab ) {
					if ( $current_tab == $tab->id ) {

						// Prints nonce, action and options_page fields.
						settings_fields( $tab->id );

						// Prints settings sections and settings fields.
						do_settings_sections( $tab->id );

						break;
					}
				}

				// Display submit button.
				submit_button();

			// Closes the form.
			echo '</form>';

		// Closes the wrap.
		echo '</div>';
	}

	/**
	 * Create settings.
	 *
	 * @return void
	 */
	public function create_settings() {

		// Process options page tabs.
		foreach ( $this->tabs as $tab => $tab_data ) {

			// Process tab sections.
			foreach ( $tab_data->sections as $section => $section_data ) {

				// Register settings sections.
				add_settings_section(
					$section,
					$section_data->name,
					'__return_false',
					$tab
				);

				foreach ( $section_data->fields as $field => $option ) {
					$args = array(
						'id'          => $option['id'],
						'tab'         => $tab,
						'section'     => $section,
						'default'     => $option['default'],
						'description' => $option['description'],
						'attributes'  => $option['attributes'],
						'options'     => $option['options']
					);

					// Register the settings field.
					add_settings_field(
						$option['id'],
						$option['label'],
						array( 'Odin_Theme_Options_Fields', $option['type'] ),
						$tab,
						$section,
						$args
					);
				}
			}

			// Register settings.
			register_setting( $tab, $tab, array( $this, 'validate_input' ) );
		}
	}

	/**
	 * Sanitization fields callback.
	 *
	 * @param  string $input The unsanitized collection of options.
	 *
	 * @return string        The collection of sanitized values.
	 */
	public function validate_input( $input ) {

		// Create our array for storing the validated options.
		$output = array();

		// Loop through each of the incoming options.
		foreach ( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if ( isset( $input[ $key ] ) ) {
				$output[ $key ] = apply_filters( 'odin_theme_options_validate_' . $this->id, $value, $key );
			}

		}

		return $output;
	}
}
