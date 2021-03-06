<?php
add_action( 'after_setup_theme', 'mrw_block_editor_theme_support', 11 );
/**
 * Make modifications to editor that can be made using default add_theme_support() calls
 */
function mrw_block_editor_theme_support() {

	/*
	 * Remove pixel-based font sizing
	 *
	 * Override with remove_theme_support( 'disable-custom-font-sizes' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
	 */
	add_theme_support( 'disable-custom-font-sizes' );

	/*
	 * Remove custom color picker
	 *
	 * Override with remove_theme_support( 'disable-custom-colors' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
	 */
	add_theme_support( 'disable-custom-colors' );

	/*
	 * Remove the default color palette if the theme has not explicitly registered a palette
	 *
	 * Override this with mrw_block_editor_color_palette filter
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
	 */
	$theme_palette = get_theme_support( 'editor-color-palette' );

	/**
	 * See if the Block Editor Colors plugin is activated. In that case, let it do its thing
	 * 
	 * @var bool
	 *
	 * @see  https://wordpress.org/plugins/block-editor-colors/
	 */
	$block_editor_colors_plugin_is_active = in_array( 'block-editor-colors/plugin.php', (array) get_option( 'active_plugins', array() ), true );

	$hide_palette = apply_filters(
		'mrw_block_editor_hide_color_palette',
		empty( $theme_palette )
	);

	if( $hide_palette && ! $block_editor_colors_plugin_is_active ) {
		add_theme_support( 'editor-color-palette' );
	}

	/*
	 * Hide the custom gradient builder
	 *
	 * Override with remove_theme_support( 'disable-custom-gradients' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-gradients
	 */
	add_theme_support( 'disable-custom-gradients' );

	/*
	 * Hide default gradient presets if the theme has not explicitly registered any
	 *
	 * Override this with mrw_block_editor_hide_gradient_presets filter
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
	 * Remove core-registered block patterns
	 *
	 * Override with add_theme_support( 'core-block-patterns' ) hooked to after_setup_theme with priority 12+
	 *
	 * @see https://make.wordpress.org/core/2020/07/16/block-patterns-in-wordpress-5-5/
	 */
	remove_theme_support( 'core-block-patterns' );
	
}

add_action(	'plugins_loaded', 'mrw_hide_block_directory' );
/**
 * Hide the block directory
 * 
 * @see https://github.com/WordPress/gutenberg/issues/23961#issuecomment-666683997
 */
function mrw_hide_block_directory() {

	if( in_array( 'block-directory', mrw_hidden_block_editor_settings() ) ) {
		remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
		remove_action( 'enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory' );
	}

}

/**
 * Define default hidden blocks and allow them to be filtered
 *
 * Note: Blocks are hidden from the inserter rather than unregistered to avoid editor crashing when a hidden block is in the page content
 * 
 * @return array slugs of all hidden core blocks
 */
function mrw_hidden_blocks() {

	$hidden_blocks = array(
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
	);

	// attempt to detect if More Tag button was previously made available in the classic editor before overriding the More Block
	$mce_buttons = array_merge(
		apply_filters( 'mce_buttons', array() ),
		apply_filters( 'mce_buttons_2', array() )
	);

	if( ! in_array( 'wp_more', $mce_buttons ) ) {
		$hidden_blocks[] = 'core/more';
	}

	$hidden_blocks = apply_filters_deprecated(
		'mrw_block_blacklist',
		array( $hidden_blocks ),
		'2.2.0 of MRW Simplified Editor',
		'mrw_hidden_blocks',
		'This filter will stop functioning as soon as August 2021.'
	);

	$hidden_blocks = apply_filters_deprecated(
		'mrw_disabled_blocks',
		array( $hidden_blocks ),
		'2.3.0 of MRW Simplified Editor',
		'mrw_hidden_blocks',
		'This filter will stop functioning as soon as January 2022.'
	);

	return apply_filters( 'mrw_hidden_blocks', $hidden_blocks );

}

/**
 * Return list of hidden embeds
 */
function mrw_hidden_embeds() {
	
	// Embeds
	$hidden_embeds = array(
		'amazon-kindle',
		'animoto',
		'cloudup',
		'collegehumor',
		'crowdsignal',
		'dailymotion',
		'hulu',
		'mixcloud',
		'polldaddy',
		'reverbnation',
		'smugmug',
		'speaker',
		'videopress',
		'wordpress-tv',
	);

	return apply_filters( 'mrw_hidden_embeds', $hidden_embeds );

}

add_action( 'jetpack_register_gutenberg_extensions', 'mrw_jetpack_hidden_blocks', 99 );
/**
 * Hiden Jetpack Blocks
 *
 * @see  https://developer.jetpack.com/hooks/jetpack_register_gutenberg_extensions/
 */
function mrw_jetpack_hidden_blocks() {

	if ( ! class_exists( 'Jetpack_Gutenberg' ) ) {
		return;
	}
	
	$jetpack_hidden_block_reason = 'Hidden by MRW Simplified Editor. Use mrw_jetpack_hidden_blocks filter to restore.';

	$mrw_jetpack_hidden_blocks = apply_filters(
		'mrw_jetpack_hidden_blocks',
		array(
			'markdown',
			'rating-star',
			'repeat-visitor',
			'opentable',
			'revue',
			'eventbrite',
			'gif',
			'calendly',
			'send-a-message', // required for whatsapp-button
			'whatsapp-button',
		)
	);

	foreach( $mrw_jetpack_hidden_blocks as $block ) {
		Jetpack_Gutenberg::set_extension_unavailable(
			'jetpack/' . $block,
			$jetpack_hidden_block_reason
		);
	}

}

/**
 * Define default hidden block style and allow them to be filtered
 * 
 * @return array keyed array where keys are a block slug and value is an array containing all block style to remove
 */
function mrw_hidden_block_styles() {

	$hidden_styles = array(
		'core/image'		=> array( 'default', 'circle-mask', 'rounded' ),
		'core/button' 		=> array( 'default', 'fill', 'squared', 'outline' ),
		'core/quote' 		=> array( 'default', 'large' ),
		'core/separator' 	=> array( 'default', 'wide', 'dots' ),
		'core/pullquote' 	=> array( 'default', 'solid-color' ),
		'core/table'		=> array( 'default', 'stripes' ),
		'core/social-links'	=> array( 'default', 'logos-only', 'pill-shape' ),
	);

	$hidden_styles = apply_filters_deprecated(
		'mrw_style_variations_blacklist',
		array( $hidden_styles ),
		'2.2.0 of MRW Simplified Editor',
		'mrw_hidden_block_styles',
		'This filter will stop functioning as soon as August 2021.'
	);

	$hidden_styles = apply_filters_deprecated(
		'mrw_disabled_style_variations',
		array( $hidden_styles ),
		'2.3.0 of MRW Simplified Editor',
		'mrw_hidden_block_styles',
		'This filter will stop functioning as soon as January 2022.'
	);

	return apply_filters( 'mrw_hidden_block_styles', $hidden_styles	);

}

/**
 * Return filtered array of Block Editor Features/Settings to hide
 * 
 * @return array every option to hide via CSS or JS
 */
function mrw_hidden_block_editor_settings() {

	$hidden_block_editor_settings = array(
		'drop-cap',
		'image-file-upload',
		'image-url',
		'heading-1',
		'heading-5',
		'heading-6',
		'image-dimensions',
		'new-tabs',
		'block-directory',
		'default-style-variation'
	);

	$hidden_block_editor_settings = apply_filters_deprecated(
		'mrw_block_editor_disable_settings',
		array( $hidden_block_editor_settings ),
		'2.2.0 of MRW Simplified Editor',
		'mrw_hidden_block_editor_settings',
		'This filter will stop functioning as soon as August 2021.'
	);

	$hidden_block_editor_settings = apply_filters_deprecated(
		'mrw_disabled_block_editor_settings',
		array( $hidden_block_editor_settings ),
		'2.3.0 of MRW Simplified Editor',
		'mrw_hidden_block_editor_settings',
		'This filter will stop functioning as soon as January 2022.'
	);

	return apply_filters( 'mrw_hidden_block_editor_settings', $hidden_block_editor_settings );

}

add_filter( 'block_editor_settings', 'mrw_block_editor_settings' );
/**
 * Make changes to editor settings, accounting for plugin filters, via the core block_editor_settings filter
 * 
 * @param  array $editor_settings default editor settings
 * @return array                  modified settings
 *
 * @see https://github.com/joppuyo/remove-drop-cap/blob/v1.1.0/remove-drop-cap.php#L22
 */
function mrw_block_editor_settings( $editor_settings ) {

	$hidden_settings = mrw_hidden_block_editor_settings();

	if( in_array( 'drop-cap', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['global']['typography']['dropCap'] = false;
	}

	return $editor_settings;

}

/**
 * Prepare all plugin options (after being filtered) for use in JavaScript
 * 
 * @return array all hidden blocks, block styles, and block editor settings
 */
function mrw_block_editor_js_config() {

	$js_options = array();

	// Note: using array_values to ensure this is passed as an array and not an object

	/*==============================
	=            Blocks            =
	==============================*/
	$js_options['hiddenBlocks'] = array_values( mrw_hidden_blocks() );


	/*========================================
	=            Embed Variations            =
	========================================*/
	$js_options['hiddenEmbeds'] = array_values( mrw_hidden_embeds() );

	/*====================================
	=            Block Styles            =
	======================================*/
	$hidden_style_variations = array();
	foreach ( mrw_hidden_block_styles() as $block => $styles ) {
		$hidden_styles[$block] = array_values( $styles );
	}

	$js_options['hiddenStyles'] = $hidden_styles;

	/*================================
	=            Features            =
	================================*/
	$js_options['hiddenSettings'] = array_values( mrw_hidden_block_editor_settings() );

	return $js_options;

}

add_action( 'enqueue_block_editor_assets', 'mrw_block_editor_assets' );
/**
 * Enqueue CSS and JS files that modify/hide block editor settings in the admin
 */
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
 * Apply body classes to admin for each features that are hidden via CSS
 * 
 * @param  array $classes list of hidden features
 * @return array
 */
function mrw_block_editor_settings_admin_classes( $classes ) {

	$current_screen = get_current_screen();

	if( isset( $current_screen->is_block_editor ) && (bool) $current_screen->is_block_editor ) {

		$hidden_block_editor_settings = mrw_hidden_block_editor_settings();

		$prefix = ' mrw-block-editor-no-';
		foreach( $hidden_block_editor_settings as $setting ) {
			$classes .= $prefix . sanitize_title_with_dashes( $setting );
		}

	}

	return $classes;

}