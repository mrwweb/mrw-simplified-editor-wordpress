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

	/**
	 * Disable the custom gradient builder
	 *
	 * Override with remove_theme_support( 'disable-custom-gradients' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-gradients
	 */
	add_theme_support( 'disable-custom-gradients' );

	/**
	 * Disable default color palette if the theme has not explicitly registered a palette
	 *
	 * Override this with mrw_block_editor_color_palette filter
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-gradient-presets
	 */
	$theme_gradients = get_theme_support( 'editor-gradient-presets' );
	$hide_gradients = apply_filters( 'mrw_block_editor_hide_gradient_presets', empty( $theme_gradients ) );
	if( $hide_gradients ) {
		add_theme_support( 'editor-gradient-presets', array() );
	}
	
}

function mrw_block_editor_js_config() {

	$mrw_simple_js_options = array();



	/*==============================
	=            Blocks            =
	==============================*/
	$mrw_block_blacklist = array(
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
		$mrw_block_blacklist[] = 'core/more';
	}

	// use array_values to ensure this is passed as an array and not an object
	$mrw_simple_js_options['blockBlacklist'] = array_values( apply_filters( 'mrw_block_blacklist', $mrw_block_blacklist ) );



	/*========================================
	=            Style Variations            =
	========================================*/
	$default_style_variations_blacklist = array(
		'core/image'		=> array( 'default', 'circle-mask', 'rounded' ),
		'core/button' 		=> array( 'default', 'fill', 'squared', 'outline' ),
		'core/quote' 		=> array( 'default', 'large' ),
		'core/separator' 	=> array( 'default', 'wide', 'dots' ),
		'core/pullquote' 	=> array( 'default', 'solid-color' ),
		'core/table'		=> array( 'default', 'stripes' ),
		'core/social-links'	=> array( 'logos-only', 'pill-shape' ),
	);

	$final_style_variations_blacklist = apply_filters( 'mrw_style_variations_blacklist', $default_style_variations_blacklist );

	// use array_values to ensure this is passed as an array and not an object
	foreach ( $final_style_variations_blacklist as $block => $variations ) {
		$final_style_variations_blacklist[$block] = array_values( $variations );
	}

	$mrw_simple_js_options['variationsBlacklist'] = $final_style_variations_blacklist;



	/*================================
	=            Features            =
	================================*/
	$mrw_simple_js_options['featureBlacklist'] = mrw_disabled_block_editor_settings();
	

	return $mrw_simple_js_options;

}

add_action( 'enqueue_block_editor_assets', 'mrw_block_editor_js' );
function mrw_block_editor_js() {

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

/**
 * return filtered array of Block Editor Features/Settings to Disable
 * @return array every option to disable via CSS or JS
 */
function mrw_disabled_block_editor_settings() {

	$mrw_disabled_block_editor_settings = array(
		'drop-cap',
		'image-file-upload',
		'image-url',
		'heading-1',
		'heading-5',
		'heading-6',
		'image-dimensions',
		'new-tabs',
	);

	// only prevent fullscreen in versions of WordPress that need it
	global $wp_version;
	if( version_compare( $wp_version, '5.4-beta1', '>=' ) ) {
		$mrw_disabled_block_editor_settings[] = 'prevent-fullscreen';
	}

	$mrw_disabled_block_editor_settings = apply_filters( 'mrw_block_editor_disable_settings', $mrw_disabled_block_editor_settings );

	return $mrw_disabled_block_editor_settings;

}

add_action( 'admin_body_class', 'mrw_block_editor_settings_admin_classes' );
function mrw_block_editor_settings_admin_classes( $classes ) {

	$mrw_disabled_block_editor_settings = mrw_disabled_block_editor_settings();

	$mrw_prefix = ' mrw-block-editor-no-';
	foreach( $mrw_disabled_block_editor_settings as $setting ) {
		$classes .= $mrw_prefix . sanitize_title_with_dashes( $setting );
	}

	return $classes;

}