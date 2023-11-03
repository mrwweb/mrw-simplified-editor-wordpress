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

	/**
	 * mrw_block_editor_hide_color_palette filter
	 * @since 2.0.0
	 */
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

	/**
	 * mrw_block_editor_hide_gradient_presets filter
	 * @since 2.1.0
	 */
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

	$current_screen = get_current_screen();
	$context = $current_screen->id;

	/**
	 * mrw_hidden_core_blocks filter
	 *
	 * Allows showing all hidden "Core" blocks by removing them from the hidden list. Use __return_empty_array to unhide all blocks.
	 * 
	 * @since 2.5.0
	 */
	$hidden_core_blocks = apply_filters( 'mrw_hidden_core_blocks', array(
		'core/audio',
		'core/code',
		'core/details',
		'core/footnotes',
		'core/freeform',
		'core/nextpage',
		'core/preformatted',
		'core/shortcode',
		'core/spacer',
		'core/table',
		'core/verse',
		'core/video',
		'videopress/video', // jetpack
	), $context );

	/**
	 * mrw_hidden_widget_blocks filter
	 *
	 * Allows showing all hidden "Widget" blocks by removing them from the hidden list. Use __return_empty_array to unhide all blocks.
	 * 
	 * @since 2.5.0
	 */
	$hidden_widgets = apply_filters( 'mrw_hidden_widget_blocks', array(
		'core/archives',
		'core/calendar',
		'core/categories',
		'core/latest-comments',
		'core/legacy-widget',
		'core/rss',
		'core/search',
		'core/tag-cloud',
	), $context );

	/**
	 * mrw_hidden_query_blocks filter
	 *
	 * Allows showing all hidden "Query" and "Post" blocks by removing them from the hidden list. Use __return_empty_array to unhide all blocks.
	 * 
	 * @since 2.5.0
	 */
	$hidden_query_blocks = apply_filters( 'mrw_hidden_query_blocks', array(
		'core/avatar',
		'core/query',
		'core/query-title',
		'core/post-title',
		'core/post-content',
		'core/post-date',
		'core/post-excerpt',
		'core/post-featured-image',
		'core/post-terms',
		'core/post-author',
		'core/post-author-biography',
		'core/read-more',
		'core/term-description',
	), $context );

	/**
	 * mrw_hidden_site_blocks filter
	 *
	 * Allows showing all hidden "Site"/"Theme" blocks by removing them from the hidden list. Use __return_empty_array to unhide all blocks.
	 * 
	 * @since 2.5.0
	 */
	$hidden_site_blocks = apply_filters( 'mrw_hidden_site_blocks', array(
		'core/comments',
		'core/comments-query-loop',
		'core/loginout',
		'core/page-list',
		'core/site-logo',
		'core/site-tagline',
		'core/site-title',
		'core/navigation',
		'core/post-author-name',
		'core/post-comments',
		'core/post-comments-form',
		'core/post-navigation-link',
	), $context );

	$hidden_blocks = array_merge(
		$hidden_core_blocks,
		$hidden_widgets,
		$hidden_query_blocks,
		$hidden_site_blocks,
	);

	// attempt to detect if More Tag button was previously made available in the classic editor before overriding the More Block
	$mce_buttons = array_merge(
		apply_filters( 'mce_buttons', array() ),
		apply_filters( 'mce_buttons_2', array() )
	);

	if( ! in_array( 'wp_more', $mce_buttons ) ) {
		$hidden_blocks[] = 'core/more';
	}

	/**
	 * mrw_hidden_blocks filter
	 * @since 2.3.0
	 */
	return apply_filters( 'mrw_hidden_blocks', $hidden_blocks, $context );

}

add_filter( 'mrw_hidden_site_blocks', 'mrw_show_blocks_in_site_editor', 0, 2 );
add_filter( 'mrw_hidden_query_blocks', 'mrw_show_blocks_in_site_editor', 0, 2 );
/**
 * Show all Query- and Post-related blocks in the Site Editor
 */
function mrw_show_blocks_in_site_editor( $blocks, $context ) {
	if( $context === 'site-editor' ) {
		$blocks = array();
	}

	return $blocks;
}

/**
 * Return list of hidden embeds
 */
function mrw_hidden_embeds() {

	$hidden_embeds = array(
		'amazon-kindle',
		'animoto',
		'cloudup',
		'collegehumor',
		'crowdsignal',
		'dailymotion',
		'hulu',
		'jetpack/pinterest',
		'mixcloud',
		'pocket-casts',
		'polldaddy',
		'reverbnation',
		'smartframe', // jetpack
		'smugmug',
		'speaker',
		'videopress',
		'wolfram-cloud',
		'wordpress-tv',
	);

	/**
	 * mrw_hidden_embeds filter
	 * @since 2.4.0
	 */
	return apply_filters( 'mrw_hidden_embeds', $hidden_embeds );

}

add_action( 'jetpack_register_gutenberg_extensions', 'mrw_jetpack_hidden_blocks', 99 );
/**
 * Hidden Jetpack Blocks
 *
 * @see  https://developer.jetpack.com/hooks/jetpack_register_gutenberg_extensions/
 */
function mrw_jetpack_hidden_blocks() {

	if ( ! class_exists( 'Jetpack_Gutenberg' ) ) {
		return;
	}
	
	$jetpack_hidden_block_reason = 'Hidden by MRW Simplified Editor. Use mrw_jetpack_hidden_blocks filter to restore.';

	$jetpack_hidden_content_blocks = array(
		'ai-assistant',
		'calendly',
		'contact-form',
		'donations',
		'eventbrite',
		'gif',
		'markdown',
		'opentable',
		'payments-intro',
		'premium-content/container',
		'rating-star',
		'repeat-visitor',
		'revue',
		'send-a-message', // required for whatsapp-button
		'story',
		'tock',
		'whatsapp-button',
	);

	/**
	 * mrw_jetpack_hidden_blocks filter
	 * @since 2.3.0
	 */
	$mrw_jetpack_hidden_blocks = apply_filters(
		'mrw_jetpack_hidden_blocks',
		$jetpack_hidden_content_blocks
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

	/**
	 * mrw_hidden_block_styles filter
	 * @since 2.3.0
	 */
	return apply_filters( 'mrw_hidden_block_styles', $hidden_styles	);

}

/**
 * Return filtered array of Block Editor Features/Settings to hide
 * 
 * @return array every option to hide via CSS or JS
 */
function mrw_hidden_block_editor_settings() {

	$hidden_block_editor_settings = array(
		'block-directory',
		'border',
		'border-radius',
		'default-color-palette',
		'default-gradients',
		'default-style-variation',
		'drop-cap',
		'duotone',
		'font-weight',
		'font-style',
		'heading-1',
		'heading-5',
		'heading-6',
		'image-dimensions',
		'image-file-upload',
		'image-url',
		'justification-group',
		'layout-width',
		'letter-spacing',
		'line-height',
		'min-height-group',
		'new-tabs',
		'padding',
		'pullquote-border',
		'spacing',
		'sticky-position',
		'text-decoration',
		'text-orientation',
		'text-transform',
	);

	/**
	 * mrw_hidden_core_blocks filter
	 * @since 2.3.0
	 */
	return apply_filters( 'mrw_hidden_block_editor_settings', $hidden_block_editor_settings );

}

add_filter( 'block_editor_settings_all', 'mrw_block_editor_settings', 99, 2 );
/**
 * Make changes to editor settings, accounting for plugin filters, via the core block_editor_settings filter
 * 
 * @param  array $editor_settings default editor settings
 * @return array                  modified settings
 *
 * @see https://github.com/joppuyo/remove-drop-cap/blob/v1.1.0/remove-drop-cap.php#L22
 */
function mrw_block_editor_settings( $editor_settings, $context ) {

	$hidden_settings = mrw_hidden_block_editor_settings();

	/* Border */
	if( in_array( 'border', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['border'] = [];
	}

	/* Border Radius, Button */
	if( in_array( 'border-radius', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['blocks']['core/button']['border']['radius'] = false;	
	}

	/* Default Color Pallete */
	if( in_array( 'default-color-palette', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['color']['defaultPalette'] = false;
	}
	
	/* Default Gradients */
	if( in_array( 'default-gradients', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['color']['defaultGradients'] = false;
	}

	/* Drop Cap */
	if( in_array( 'drop-cap', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['typography']['dropCap'] = false;
	}

	/* Duotone */
	if( in_array( 'duotone', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['color']['duotone'] = null;
		$editor_settings['__experimentalFeatures']['color']['customDuotone'] = false;
	}

	/* Font Style */
	if( in_array( 'font-style', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['typography']['fontStyle'] = false;
	}

	/* Font Weight */
	if( in_array( 'font-weight', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['typography']['fontWeight'] = false;
	}

	/* Gap and Margin */
	if( in_array( 'spacing', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['spacing'] = [];
	}

	/* Letter Spacing */
	if( in_array( 'letter-spacing', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['typography']['letterSpacing'] = false;
	}

	/* Line Height */
	if( in_array( 'line-height', $hidden_settings ) ) {
		$editor_settings['enableCustomLineHeight'] = false;
	}

	/* Padding */
	if( in_array( 'padding', $hidden_settings ) ) {
		$editor_settings['enableCustomSpacing'] = false;
	}

	/* Pullquote Border */
	if( in_array( 'pullquote-border', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border'] = [];
	}

	/* Text Decoration */
	if( in_array( 'text-decoration', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['typography']['textDecoration'] = false;
	}

	/* Text Orientation */
	if( in_array( 'text-orientation', $hidden_settings ) ) {
		error_log(print_r($editor_settings, true));
		$editor_settings['__experimentalFeatures']['typography']['writingMode'] = false;
	}

	/* Text Transform */
	if( in_array( 'text-transform', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['typography']['textTransform'] = false;
	}

	/* Min Height on the Group block (not the cover block) */
	if( in_array( 'min-height-group', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['dimensions']['minHeight'] = false;
	}

	/* Position Sticky */
	if( in_array( 'sticky-position', $hidden_settings ) ) {
		$editor_settings['__experimentalFeatures']['position']['sticky'] = false;
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

	/**
	 * Ensure the correct dependencies depending on the editor being used
	 * 
	 * Thank you Sally CJ! https://wordpress.stackexchange.com/a/413631/9844
	 */
	$script_dependencies = array( 'wp-blocks', 'wp-dom-ready' );
	$screen = get_current_screen();
	$context = $screen ? $screen->id : '';
	switch( $context ) {
		case 'widgets':
			$script_dependencies[] = 'wp-edit-widgets';
			break;
		case 'site-editor':
			$script_dependencies[] = 'wp-edit-site';
			break;
		case 'page':	
		case 'post':
			$script_dependencies[] = 'wp-edit-post';
			break;
		default:
			$script_dependencies[] = 'wp-edit-post';
			break;
	}

	wp_enqueue_style(
		'mrw-block-editor-css',
		plugins_url( 'css/block-editor.css', dirname(__FILE__) ),
		array(),
		'2.0.0'
	);

	wp_register_script(
		'mrw-block-editor-js',
		plugins_url( 'js/block-editor.js', dirname(__FILE__) ),
		$script_dependencies,
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