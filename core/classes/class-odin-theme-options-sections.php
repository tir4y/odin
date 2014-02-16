<?php
/**
 * Odin_Theme_Options_Sections class.
 *
 * Creates sections for the tabs of the theme options pages.
 *
 * @package  Odin
 * @category Options
 * @author   WPBrasil
 * @version  3.0.0
 */
class Odin_Theme_Options_Sections {

	/**
	 * Section fields.
	 *
	 * @var array
	 */
	public $fields = array();

	/**
	 * Section construct.
	 *
	 * @param string $id   Section ID.
	 * @param string $name Section name.
	 */
	public function __construct( $id, $name ) {
		$this->id   = $id;
		$this->name = $name;
	}

	/**
	 * Add a text field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 */
	public function add_text_field( $id, $label, $default = '', $description = '', $attributes = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'text',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => array()
		);
	}

	/**
	 * Add a textarea field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 */
	public function add_textarea_field( $id, $label, $default = '', $description = '', $attributes = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'textarea',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => array()
		);
	}

	/**
	 * Add a editor field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 * @param array  $options     Field options.
	 */
	public function add_editor_field( $id, $label, $default = '', $description = '', $attributes = array(), $options = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'editor',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => $options
		);
	}

	/**
	 * Add a checkbox field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 */
	public function add_checkbox_field( $id, $label, $default = '', $description = '', $attributes = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'checkbox',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => array()
		);
	}

	/**
	 * Add a radio field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 * @param array  $options     Field options.
	 */
	public function add_radio_field( $id, $label, $default = '', $description = '', $attributes = array(), $options = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'radio',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => $options
		);
	}

	/**
	 * Add a select field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 * @param array  $options     Field options.
	 */
	public function add_select_field( $id, $label, $default = '', $description = '', $attributes = array(), $options = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'select',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => $options
		);
	}

	/**
	 * Add a color field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 */
	public function add_color_field( $id, $label, $default = '', $description = '', $attributes = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'color',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => array()
		);
	}

	/**
	 * Add a upload field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 */
	public function add_upload_field( $id, $label, $default = '', $description = '', $attributes = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'upload',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => array()
		);
	}

	/**
	 * Add a image field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 */
	public function add_image_field( $id, $label, $default = '', $description = '', $attributes = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'image',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => array()
		);
	}

	/**
	 * Add a image_plupload field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 */
	public function add_image_plupload_field( $id, $label, $default = '', $description = '', $attributes = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'image_plupload',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => array()
		);
	}

	/**
	 * Add a input field.
	 *
	 * @param string $id          Field ID.
	 * @param string $label       Field label.
	 * @param string $default     Default value.
	 * @param string $description Field description.
	 * @param array  $attributes  Field attributes.
	 */
	public function add_input_field( $id, $label, $default = '', $description = '', $attributes = array() ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => $label,
			'type'        => 'input',
			'default'     => $default,
			'description' => $description,
			'attributes'  => $attributes,
			'options'     => array()
		);
	}

	/**
	 * Add a html field.
	 *
	 * @param string $id      Field ID.
	 * @param string $content Field content.
	 */
	public function add_html( $id, $content = '' ) {
		$this->fields[] = array(
			'id'          => $id,
			'label'       => '',
			'type'        => 'html',
			'default'     => '',
			'description' => $content,
			'attributes'  => array(),
			'options'     => array()
		);
	}
}
