<?php
/**
 * Odin_Theme_Options_Fields class.
 *
 * Creates the fields in the theme options page.
 *
 * @package  Odin
 * @category Options
 * @author   WPBrasil
 * @version  3.0.0
 */
class Odin_Theme_Options_Fields {

	/**
	 * Get Option.
	 *
	 * @param  string $tab     Tab that the option belongs
	 * @param  string $id      Option ID.
	 * @param  string $default Default option.
	 *
	 * @return array           Item options.
	 */
	protected static function get_option( $tab, $id, $default = '' ) {
		$options = get_option( $tab );

		if ( isset( $options[ $id ] ) ) {
			$default = $options[ $id ];
		}

		return $default;

	}

	/**
	 * Build field attributes.
	 *
	 * @param  array $attrs Attributes as array.
	 *
	 * @return string       Attributes as string.
	 */
	protected static function attributes( $attrs ) {
		$attributes = '';

		if ( ! empty( $attrs ) ) {
			foreach ( $attrs as $key => $attr ) {
				$attributes .= ' ' . $key . '="' . $attr . '"';
			}
		}

		return $attributes;
	}

	/**
	 * Input field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Input field HTML.
	 */
	public static function input( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets default type.
		if ( ! isset( $attrs['type'] ) ) {
			$attrs['type'] = 'text';
		}

		// Sets current option.
		$current = esc_html( self::get_option( $tab, $id, $args['default'] ) );

		$html = sprintf( '<input id="%1$s" name="%2$s[%1$s]" value="%3$s"%4$s />', $id, $tab, $current, self::attributes( $attrs ) );

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	public static function text( $args ) {
		// Sets regular text class.
		$args['attributes']['class'] = 'regular-text';

		self::input( $args );
	}

	/**
	 * Textarea field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Textarea field HTML.
	 */
	public static function textarea( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		if ( ! isset( $attrs['cols'] ) ) {
			$attrs['cols'] = '60';
		}

		if ( ! isset( $attrs['rows'] ) ) {
			$attrs['rows'] = '5';
		}

		// Sets current option.
		$current = esc_textarea( self::get_option( $tab, $id, $args['default'] ) );

		$html = sprintf( '<textarea id="%1$s" name="%2$s[%1$s]"%4$s>%3$s</textarea>', $id, $tab, $current, self::attributes( $attrs ) );

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Editor field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Editor field HTML.
	 */
	public static function editor( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$options = $args['options'];

		// Sets current option.
		$current = wpautop( self::get_option( $tab, $id, $args['default'] ) );

		// Set default options.
		if ( empty( $options ) ) {
			$options = array( 'textarea_rows' => 10 );
		}

		echo '<div style="width: 600px;">';

			wp_editor( $current, $tab . '[' . $id . ']', $options );

		echo '</div>';

		// Displays the description.
		if ( $args['description'] ) {
			echo sprintf( '<p class="description">%s</p>', $args['description'] );
		}
	}

	/**
	 * Checkbox field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Checkbox field HTML.
	 */
	public static function checkbox( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets current option.
		$current = self::get_option( $tab, $id, $args['default'] );

		$html = sprintf( '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1"%3$s%4$s />', $id, $tab, checked( 1, $current, false ), self::attributes( $attrs ) );

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<label for="%s"> %s</label>', $id, $args['description'] );
		}

		echo $html;
	}

	/**
	 * Radio field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Radio field HTML.
	 */
	public static function radio( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets current option.
		$current = self::get_option( $tab, $id, $args['default'] );

		$html = '';
		foreach( $args['options'] as $key => $label ) {
			$item_id = $id . '_' . $key;
			$key = sanitize_title( $key );

			$html .= sprintf( '<input type="radio" id="%1$s_%3$s" name="%2$s[%1$s]" value="%3$s"%4$s%5$s />', $id, $tab, $key, checked( $current, $key, false ), self::attributes( $attrs ) );
			$html .= sprintf( '<label for="%s"> %s</label><br />', $item_id, $label );
		}

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Select field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Select field HTML.
	 */
	public static function select( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets current option.
		$current = self::get_option( $tab, $id, $args['default'] );

		// If multiple add a array in the option.
		$multiple = ( in_array( 'multiple', $attrs ) ) ? '[]' : '';

		$html = sprintf( '<select id="%1$s" name="%2$s[%1$s]%3$s"%4$s>', $id, $tab, $multiple, self::attributes( $attrs ) );
		foreach ( $args['options'] as $key => $label ) {
			$key = sanitize_title( $key );

			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $label );
		}
		$html .= '</select>';

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Color field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Color field HTML.
	 */
	public static function color( $args ) {
		// Sets color class.
		$args['attributes']['class'] = 'odin-color-field';

		self::input( $args );
	}

	/**
	 * Upload field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Upload field HTML.
	 */
	public static function upload( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets current option.
		$current = esc_url( self::get_option( $tab, $id, $args['default'] ) );

		$html = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="regular-text"%5$s /> <input class="button odin-upload-button" id="%1$s-button" type="button" value="%4$s" />', $id, $tab, $current, __( 'Select file', 'odin' ), self::attributes( $attrs ) );

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Image field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Image field HTML.
	 */
	public static function image( $args ) {
		$tab = $args['tab'];
		$id  = $args['id'];

		// Sets current option.
		$current = self::get_option( $tab, $id, $args['default'] );

		// Gets placeholder image.
		$image = get_template_directory_uri() . '/core/assets/images/placeholder.png';
		$html  = '<span class="odin-default-image" style="display: none;">' . $image . '</span>';

		if ( $current ) {
			$image = wp_get_attachment_image_src( $current, 'thumbnail' );
			$image = $image[0];
		}

		$html .= sprintf( '<input id="%1$s" name="%2$s[%1$s]" type="hidden" class="odin-upload-image" value="%3$s" /><img src="%4$s" class="odin-preview-image" style="height: 150px; width: 150px;" alt="" /><br /><input id="%1$s-button" class="odin-upload-image-button button" type="button" value="%5$s" /><small> <a href="#" class="odin-clear-image-button">%6$s</a></small>', $id, $tab, $current, $image, __( 'Select image', 'odin' ), __( 'Remove image', 'odin' ) );

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Image Plupload field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Image Plupload field HTML.
	 */
	public static function image_plupload( $args ) {
		$tab = $args['tab'];
		$id  = $args['id'];

		// Sets current option.
		$current = self::get_option( $tab, $id, $args['default'] );

		$html = '<div class="odin-gallery-container">';
			$html .= '<ul class="odin-gallery-images">';
				if ( ! empty( $current ) ) {
					// Gets the current images.
					$attachments = array_filter( explode( ',', $current ) );

					if ( $attachments ) {
						foreach ( $attachments as $attachment_id ) {
							$html .= sprintf( '<li class="image" data-attachment_id="%1$s">%2$s<ul class="actions"><li><a href="#" class="delete" title="%3$s">X</a></li></ul></li>',
								$attachment_id,
								wp_get_attachment_image( $attachment_id, 'thumbnail' ),
								__( 'Remove image', 'odin' )
							);
						}
					}
				}
			$html .= '</ul><div class="clear"></div>';

			// Adds the hidden input.
			$html .= sprintf( '<input type="hidden" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="odin-gallery-field" />', $id, $tab, $current );

			// Adds "adds images in gallery" url.
			$html .= sprintf( '<p class="odin-gallery-add hide-if-no-js"><a href="#">%s</a></p>', __( 'Add images in gallery', 'odin' ) );
		$html .= '</div>';

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * HTML callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string HTML.
	 */
	public static function html( $args ) {
		echo $args['description'];
	}
}
