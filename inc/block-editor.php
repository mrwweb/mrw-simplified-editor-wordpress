<?php
add_action( 'after_setup_theme', 'mrw_block_editor_theme_support', 11 );
function mrw_block_editor_theme_support() {

	/*
	 * Disable the pixel-based font sizing
	 *
	 * Override with remove_theme_support( 'disable-custom-font-sizes' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
	 */
	add_theme_support( 'disable-custom-font-sizes' );

	/*
	 * Disable the custom color picker
	 *
	 * Override with remove_theme_support( 'disable-custom-colors' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
	 */
	add_theme_support( 'disable-custom-colors' );

	/*
	 * Disable default color palette if the theme has not explicitly registered a palette
	 *
	 * Override this with mrw_block_editor_color_palette filter
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
	 */
	$theme_palette = get_theme_support( 'editor-color-palette' );

	$hide_palette = apply_filters(
		'mrw_block_editor_hide_color_palette',
		empty( $theme_palette )
	);

	if( $hide_palette ) {
		add_theme_support( 'editor-color-palette' );
	}

	/*
	 * Disable the custom gradient builder
	 *
	 * Override with remove_theme_support( 'disable-custom-gradients' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-gradients
	 */
	add_theme_support( 'disable-custom-gradients' );

	/*
	 * Disable default color palette if the theme has not explicitly registered a palette
	 *
	 * Override this with mrw_block_editor_color_palette filter
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-gradient-presets
	 */
	$theme_gradients = get_theme_support( 'editor-gradient-presets' );

	$hide_gradients = apply_filters(
		'mrw_block_editor_hide_gradient_presets',
		empty( $theme_gradients )
	);

	if( $hide_gradients ) {
		add_theme_support( 'editor-gradient-presets', array() );
	}

	/*
	 * Disable core-registered block patterns
	 *
	 * Override with add_theme_support( 'core-block-patterns' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://make.wordpress.org/core/2020/07/16/block-patterns-in-wordpress-5-5/
	 */
	remove_theme_support( 'core-block-patterns' );
	
}

add_action(	'plugins_loaded', 'mrw_disable_block_directory' );
/**
 * Disable the block directory
 * 
 * @see https://github.com/WordPress/gutenberg/issues/23961#issuecomment-666683997
 */
function mrw_disable_block_directory() {

	if( in_array( 'block-directory', mrw_disabled_block_editor_settings() ) ) {
		remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
		remove_action( 'enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory' );
	}

}

/**
 * define default disabled style variations and allow them to be filters
 * @return array slugs of all disabled core blocks
 */
function mrw_disabled_blocks() {

	$disabled_blocks = array(
		// Core
		'core/audio',
		'core/code',
		'core/nextpage',
		'core/preformatted',
		'core/spacer',
		'core/table',
		'core/verse',
		'core/video',

		// Widgets
		'core/archive',
		'core/calendar',
		'core/rss',
		'core/search',
		'core/tag-cloud',

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
		$disabled_blocks[] = 'core/more';
	}

	$disabled_blocks = apply_filters_deprecated(
		'mrw_block_blacklist',
		array( $disabled_blocks ),
		'2.2.0 of MRW Simplified Editor',
		'mrw_disabled_blocks',
		'This filter will stop functioning as soon as August 2021.'
	);

	$disabled_blocks = apply_filters( 'mrw_disabled_blocks', $disabled_blocks );

	return $disabled_blocks;

}

/**
 * define default disabled style variations and allow them to be filters
 * @return array keyed array where keys are a block slug and value is an array containing all style variations to disable
 */
function mrw_disabled_style_variations() {

	$disabled_style_variations = array(
		'core/image'		=> array( 'default', 'circle-mask', 'rounded' ),
		'core/button' 		=> array( 'default', 'fill', 'squared', 'outline' ),
		'core/quote' 		=> array( 'default', 'large' ),
		'core/separator' 	=> array( 'default', 'wide', 'dots' ),
		'core/pullquote' 	=> array( 'default', 'solid-color' ),
		'core/table'		=> array( 'default', 'stripes' ),
		'core/social-links'	=> array( 'default', 'logos-only', 'pill-shape' ),
	);

	$disabled_style_variations = apply_filters_deprecated(
		'mrw_style_variations_blacklist',
		array( $disabled_style_variations ),
		'2.2.0 of MRW Simplified Editor',
		'mrw_disabled_style_variations',
		'This filter will stop functioning as soon as August 2021.'
	);

	$disabled_style_variations = apply_filters(
		'mrw_disabled_style_variations',
		$disabled_style_variations
	);

	return $disabled_style_variations;

}

/**
 * return filtered array of Block Editor Features/Settings to Disable
 * @return array every option to disable via CSS or JS
 */
function mrw_disabled_block_editor_settings() {

	$disabled_block_editor_settings = array(
		'drop-cap',
		'image-file-upload',
		'image-url',
		'heading-1',
		'heading-5',
		'heading-6',
		'image-dimensions',
		'new-tabs',
		'block-directory'
	);

	$disabled_block_editor_settings = apply_filters_deprecated(
		'mrw_block_editor_disable_settings',
		array( $disabled_block_editor_settings ),
		'2.2.0 of MRW Simplified Editor',
		'mrw_disabled_block_editor_settings',
		'This filter will stop functioning as soon as August 2021.'
	);

	$disabled_block_editor_settings = apply_filters(
		'mrw_disabled_block_editor_settings',
		$disabled_block_editor_settings
	);

	return $disabled_block_editor_settings;

}

/**
 * prepares all plugin options (after being filtered) for use in JavaScript
 * @return array all disabled blocks, style variations, and block editor tools
 */
function mrw_block_editor_js_config() {

	$js_options = array();

	// Note: use array_values to ensure this is passed as an array and not an object

	/*==============================
	=            Blocks            =
	==============================*/
	$js_options['disabledBlocks'] = array_values( mrw_disabled_blocks() );


	/*========================================
	=            Style Variations            =
	========================================*/
	$disabled_style_variations = array();
	foreach ( mrw_disabled_style_variations() as $block => $variations ) {
		$disabled_style_variations[$block] = array_values( $variations );
	}

	$js_options['disabledVariations'] = $disabled_style_variations;


	/*================================
	=            Features            =
	================================*/
	$js_options['featureSettings'] = array_values( mrw_disabled_block_editor_settings() );
	

	return $js_options;

}

add_action( 'enqueue_block_editor_assets', 'mrw_block_editor_assets' );
function mrw_block_editor_assets() {

	wp_enqueue_style(
		'mrw-block-editor-css',
		plugins_url( 'css/block-editor.css', dirname(__FILE__) ),
		array(),
		'2.0.0'
	);

	wp_register_script(
		'mrw-block-editor-js',
		plugins_url( 'js/block-editor.js', dirname(__FILE__) ),
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
/**
 * apply body classes to admin for each disabled feature
 * @param  array $classes list of disabled features
 * @return array
 */
function mrw_block_editor_settings_admin_classes( $classes ) {

	$disabled_block_editor_settings = mrw_disabled_block_editor_settings();

	$prefix = ' mrw-block-editor-no-';
	foreach( $disabled_block_editor_settings as $setting ) {
		$classes .= $prefix . sanitize_title_with_dashes( $setting );
	}

	return $classes;

}