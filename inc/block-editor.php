<?php
add_action( 'after_setup_theme', 'mrw_block_editor_theme_support', 11 );
function mrw_block_editor_theme_support() {

	/**
	 * Disable the pixel-based font sizing
	 *
	 * Override with remove_theme_support( 'disable-custom-font-sizes' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
	 */
	add_theme_support( 'disable-custom-font-sizes' );

	/**
	 * Disable the custom color picker
	 *
	 * Override with remove_theme_support( 'disable-custom-colors' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
	 */
	add_theme_support( 'disable-custom-colors' );

	/**
	 * Disable default color palette if the theme has not explicitly registered a palette
	 *
	 * Override this with mrw_block_editor_color_palette filter
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
	 */
	$theme_palette = get_theme_support( 'editor-color-palette' );
	$hide_palette = apply_filters( 'mrw_block_editor_hide_color_palette', empty( $theme_palette ) );
	if( $hide_palette ) {
		add_theme_support( 'editor-color-palette' );
	}
	
}

function mrw_block_editor_js_config() {

	$mrw_simple_js_options = array();

	$mrw_block_blacklist = array(
		// Core
		'core/verse',
		'core/table',
		'core/preformatted',
		'core/code',
		'core/nextpage',
		'core/audio',
		'core/video',

		// Widgets
		'core/calendar',
		'core/tag-cloud',
		'core/search',
		'core/rss',
		'core/archive',

		// Embeds
		'core-embed/amazon-kindle',
		'core-embed/animoto',
		'core-embed/cloudup',
		'core-embed/collegehumor',
		'core-embed/crowdsignal',
		'core-embed/dailymotion',
		'core-embed/hulu',
		'core-embed/mixcloud',
		'core-embed/polldaddy',
		'core-embed/reverbnation',
		'core-embed/smugmug',
		'core-embed/speaker',
		'core-embed/videopress',
		'core-embed/wordpress-tv',
	);

	// attempt to detect if More Tag button was previously made available in the classic editor before overriding the More Block
	$mce_buttons = array_merge(
		apply_filters( 'mce_buttons', array() ),
		apply_filters( 'mce_buttons_2', array() )
	);
	if( ! in_array( 'wp_more', $mce_buttons ) ) {
		$mrw_block_blacklist[] = 'core/more';
	}

	// use array values to ensure this is passed as an array and not an object
	$mrw_simple_js_options['blockBlacklist'] = array_values( apply_filters( 'mrw_block_blacklist', $mrw_block_blacklist ) );

	// remove button styles
	$mrw_style_variations_blacklist = array(
		'core/image'		=> array( 'default', 'circle-mask' ),
		'core/button' 		=> array( 'default', 'fill', 'squared', 'outline' ),
		'core/quote' 		=> array( 'default', 'large' ),
		'core/separator' 	=> array( 'default', 'wide', 'dots' ),
		'core/pullquote' 	=> array( 'default', 'solid-color' ),
		'core/table'		=> array( 'default', 'stripes' ),
	);
	$mrw_simple_js_options['variationsBlacklist'] = apply_filters( 'mrw_style_variations_blacklist', $mrw_style_variations_blacklist );

	return $mrw_simple_js_options;

}

add_action( 'enqueue_block_editor_assets', 'mrw_block_editor_js' );
function mrw_block_editor_js() {

	wp_enqueue_style(
		'mrw-block-editor-css',
		plugins_url( 'mrw-web-design-simple-tinymce/css/block-editor.css' ),
		array(),
		'2.0.0'
	);

    wp_register_script(
    	'mrw-block-editor-js',
    	plugins_url( 'mrw-web-design-simple-tinymce/js/block-editor.js' ),
    	array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
    	'2.0.0'
    );

	wp_localize_script(
		'mrw-block-editor-js',
		'mrwEditorOptions',
		mrw_block_editor_js_config()
	);

	wp_enqueue_script( 'mrw-block-editor-js' );

}

add_action( 'admin_body_class', 'mrw_block_editor_settings_admin_classes' );
function mrw_block_editor_settings_admin_classes( $classes ) {

	$mrw_disabled_block_editor_settings = array(
		'drop-cap',
		'image-file-upload',
		'image-url',
		'heading-1',
		'heading-5',
		'heading-6',
		'image-dimensions',
	);

	$mrw_disabled_block_editor_settings = apply_filters( 'mrw_block_editor_disable_settings', $mrw_disabled_block_editor_settings );

	$mrw_prefix = ' mrw-block-editor-no-';
	foreach( $mrw_disabled_block_editor_settings as $setting ) {
		$classes .= $mrw_prefix . sanitize_title_with_dashes( $setting );
	}

	return $classes;

}