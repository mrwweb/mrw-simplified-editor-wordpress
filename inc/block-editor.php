<?php
add_action( 'after_setup_theme', 'mrw_block_editor_theme_support', 11 );
function mrw_block_editor_theme_support() {

	// disable pixel font-sizing
	add_theme_support( 'disable-custom-font-sizes' );

	// disable color palettes
	$custom_theme_palette = apply_filters( 'mrw_block_editor_color_palette', get_theme_support( 'editor-color-palette' ) );
	if( $custom_theme_palette !== false ) {
		add_theme_support( 'editor-color-palette' );
	}

	// disable custom color feature of color palettes
	$theme_custom_colors_setting = apply_filters( 'mrw_block_editor_custom_colors', get_theme_support( 'disable-custom-colors' ) );
	if( $theme_custom_colors_setting !== true ) {
		add_theme_support( 'disable-custom-colors' );
	}
	
}

function mrw_block_editor_js_config() {

	$mrw_simple_js_options = array();

	$mrw_block_blacklist = array(
		//core
		'core/verse',
		'core/table',
		'core/preformatted',
		'core/code',
		'core/nextpage',
		'core/html',

		// widgets
		'core/calendar',
		'core/tag-cloud',
		'core/search',
	);

	// remove button styles
	$mrw_style_variations_blacklist = array(
		'core/button' 		=> array( 'squared', 'outline' ),
		'core/quote' 		=> array( 'default', 'large' ),
		'core/separator' 	=> array( 'default', 'wide', 'dots' ),
		'core/pullquote' 	=> array( 'default', 'solid-color' ),
	);

	$mrw_simple_js_options['blockBlacklist'] = apply_filters( 'mrw_block_blacklist', $mrw_block_blacklist );

	$mrw_simple_js_options['variationsBlacklist'] = apply_filters( 'mrw_style_variations_blacklist', $mrw_style_variations_blacklist );

	return $mrw_simple_js_options;

}

add_action( 'enqueue_block_editor_assets', 'mrw_block_editor_js' );
function mrw_block_editor_js() {

	wp_enqueue_style(
		'simple-block-editor-css',
		plugins_url( 'mrw-web-design-simple-tinymce/css/block-editor.css' ),
		array(),
		'2.0.0'
	);

    wp_register_script(
    	'simple-block-editor-js',
    	plugins_url( 'mrw-web-design-simple-tinymce/js/block-editor.js' ),
    	array( 'wp-blocks' ),
    	'2.0.0'
    );

	wp_localize_script(
		'simple-block-editor-js',
		'mrwSimpleOptions',
		mrw_block_editor_js_config()
	);

	wp_enqueue_script( 'simple-block-editor-js' );

}