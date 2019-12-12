<?php
add_filter( 'mce_buttons', 'mrw_mce_buttons_1', 0 );
/**
 * Remove formatting buttons that cause more trouble than they're worth.
 * Merge remaining buttons onto first row.
 *
 * @todo - Need to include Add Media button for the classic editor block
 *
 * @since  1.0.0
 * @access public
 * @param  $buttons array the default TinyMCE buttons
 * @return array the modified TinyMCE buttons
 * @see    http://codex.wordpress.org/TinyMCE_Custom_Buttons
 */
function mrw_mce_buttons_1( $buttons ) {

	$buttons = array(
		0 => 'styleselect',
		5 => 'bold',
		10 => 'italic',
		15 => 'link',
		20 => 'unlink',
		25 => 'bullist',
		30 => 'numlist',
		35 => 'hr',
		55 => 'charmap',
		50 => 'removeformat',
		45 => 'pastetext',
		60 => 'undo',
		65 => 'redo',
		75 => 'dfw',
	);

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
	if( $screen && isset( $screen->is_block_editor ) && $screen->is_block_editor ) {
		$buttons[1000] = 'wp_add_media';
		unset( $buttons[75] );
	}

	if ( ! wp_is_mobile() ) {
		$buttons[70] = 'wp_help'; 
	}

	return $buttons;
}

// Disable second row of TinyMCE buttons
add_filter( 'mce_buttons_2', '__return_empty_array', 0 );

add_filter( 'tiny_mce_before_init', 'mrw_mce_init', 0 );
/**
 * Customize the WordPress TinyMCE editor.
 *
 * Remove h1 and address from block styles.
 * Move blockquote to block styles and del and pre to "Other Styles."
 * Add sub and sup to "Other Styles."
 *
 * @since  1.0.0
 * @access public
 * @param  $args array existing TinyMCE arguments
 * @return $args array modified TinyMCE arguments
 * @see    http://wordpress.stackexchange.com/a/128950/9844
 */
function mrw_mce_init( $args ) {
	$style_formats = array(
		array(
			'title'  => esc_attr__( 'Paragraph', 'mrw-web-design-simple-tinymce' ),
			'format' => 'p',
		),
		array(
			'title'  => esc_attr__( 'Heading 2', 'mrw-web-design-simple-tinymce' ),
			'format' => 'h2',
		),
		array(
			'title'  => esc_attr_x( '– Heading 3', 'En dash used to imply heading hierarchy', 'mrw-web-design-simple-tinymce' ),
			'format' => 'h3',
		),
		array(
			'title'  => esc_attr__( '–– Heading 4', 'En dash used to imply heading hierarchy', 'mrw-web-design-simple-tinymce' ),
			'format' => 'h4',
		),
		array(
			'title'  => esc_attr__( 'Blockquote', 'mrw-web-design-simple-tinymce' ),
			'format' => 'blockquote',
			'icon'   => 'blockquote',
		),
		array(
			'title' => esc_attr__( 'Other Formats', 'mrw-web-design-simple-tinymce' ),
			'items' => array(
				array(
					'title'  => esc_attr__( 'Strikethrough', 'mrw-web-design-simple-tinymce' ),
					'format' => 'strikethrough',
					'icon'   => 'strikethrough',
				),
				array(
					'title'  => esc_attr__( 'Superscript', 'mrw-web-design-simple-tinymce' ),
					'format' => 'superscript',
					'icon'   => 'superscript',
				),
				array(
					'title'  => esc_attr__( 'Subscript', 'mrw-web-design-simple-tinymce' ),
					'format' => 'subscript',
					'icon'   => 'subscript',
				),
			),
		),
	);

	/**
	 * Filter to add styles to "Text Styles" submenu in `styleselect`.
	 * 
	 * @since  1.0.0
	 * 
	 * @param array $text_styles array of arrays, each defining a style
	 * 
	 * @see http://wordpress.stackexchange.com/a/128950/9844
	 */
	$text_styles = array();
	$text_styles = apply_filters( 'mrw_mce_text_style', $text_styles );
	if ( ! empty( $text_styles) ) {
		// Define the "Text Style" submenu
		$text_styles = array(
			'title' => esc_attr__( 'Custom Styles', 'mrw-web-design-simple-tinymce' ),
			'items' => $text_styles,
		);

		// save "Other Formats" to append at the end.
		$other_formats = array_pop( $style_formats );
		$style_formats = array_merge(
			$style_formats,
			array( $text_styles ), // this has to be an array of arrays from above.
			array( $other_formats )
		);
	}

	$args['style_formats'] = json_encode( $style_formats );

	return $args;
}