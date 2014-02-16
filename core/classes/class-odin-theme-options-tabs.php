<?php
/**
 * Odin_Theme_Options_Tab class.
 *
 * Creates tabs for the theme options pages.
 *
 * @package  Odin
 * @category Options
 * @author   WPBrasil
 * @version  3.0.0
 */
class Odin_Theme_Options_Tab {

	/**
	 * Tab sections.
	 *
	 * @var array
	 */
	public $sections = array();

	/**
	 * Tab construct.
	 *
	 * @param string $id   Tab ID.
	 * @param string $name Tab name.
	 */
	public function __construct( $id, $name ) {
		$this->id   = $id;
		$this->name = $name;
	}

	/**
	 * Add a new section.
	 *
	 * @param string $id   Section ID.
	 * @param string $name Section name.
	 */
	public function add_section( $id, $name ) {
		$this->sections[ $id ] = new Odin_Theme_Options_Sections( $id, $name );

		return $this->sections[ $id ];
	}
}
