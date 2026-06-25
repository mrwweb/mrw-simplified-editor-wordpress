<?php
/**
 * Block Editor Modifications
 */
namespace MRW\SimplifiedEditor;

use Jetpack_Gutenberg;

add_action( 'after_setup_theme', __NAMESPACE__ . '\block_editor_theme_support', 11 );
/**
 * Make modifications to editor that can be made using default add_theme_support() calls
 */
function block_editor_theme_support() {
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
	 * Filter to hide default color palette if the theme has not explicitly registered one or the Block Editor Colors plugin is not active
	 *
	 * @since 2.0.0
	 */
	$hide_palette = apply_filters(
		'mrw_block_editor_hide_color_palette',
		empty( $theme_palette )
	);

	if ( $hide_palette && ! $block_editor_colors_plugin_is_active ) {
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
	 * Filter to hide default gradient presets if the theme has not explicitly registered any
	 *
	 * @since 2.1.0
	 */
	$hide_gradients = apply_filters(
		'mrw_block_editor_hide_gradient_presets',
		empty( $theme_gradients )
	);

	if ( $hide_gradients ) {
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

add_action( 'plugins_loaded', __NAMESPACE__ . '\hide_block_directory' );
/**
 * Hide the block directory
 *
 * @see https://github.com/WordPress/gutenberg/issues/23961#issuecomment-666683997
 */
function hide_block_directory() {

	if ( in_array( 'block-directory', hidden_block_editor_settings(), true ) ) {
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
function hidden_blocks() {

	$current_screen = get_current_screen();
	$context        = $current_screen->id;

	/**
	 * Filter `mrw_hidden_core_blocks` allows showing all hidden "Core" blocks by removing them from the hidden list. Use __return_empty_array to unhide all blocks.
	 *
	 * @since 2.5.0
	 */
	$hidden_core_blocks = apply_filters(
		'mrw_hidden_core_blocks',
		array(
			'core/accordion',
			'core/audio',
			'core/code',
			'core/details',
			'core/footnotes',
			'core/freeform',
			'core/icon',
			'core/latest-posts',
			'core/math',
			'core/nextpage',
			'core/preformatted',
			'core/shortcode',
			'core/spacer',
			'core/table',
			'core/verse',
			'core/video',
			'videopress/video', // jetpack
		),
		$context
	);

	/**
	 * Filter `mrw_hidden_widget_blocks` showing all hidden "Widget" blocks by removing them from the hidden list. Use __return_empty_array to unhide all blocks.
	 *
	 * @since 2.5.0
	 */
	$hidden_widgets = apply_filters(
		'mrw_hidden_widget_blocks',
		array(
			'core/archives',
			'core/calendar',
			'core/categories',
			'core/latest-comments',
			'core/legacy-widget',
			'core/rss',
			'core/search',
			'core/tag-cloud',
		),
		$context
	);

	/**
	 * Filter `mrw_hidden_query_blocks` allows showing all hidden "Query" and "Post" blocks by removing them from the hidden list. Use __return_empty_array to unhide all blocks.
	 *
	 * @since 2.5.0
	 */
	$hidden_query_blocks = apply_filters(
		'mrw_hidden_query_blocks',
		array(
			'core/avatar',
			'core/query',
			'core/query-title',
			'core/post-title',
			'core/post-comments-count',
			'core/post-comments-link',
			'core/post-content',
			'core/post-date',
			'core/post-excerpt',
			'core/post-featured-image',
			'core/post-terms',
			'core/post-author',
			'core/post-author-biography',
			'core/read-more',
			'core/term-count',
			'core/term-name',
			'core/term-description',
			'core/terms-query',
			'core/post-time-to-read',
		),
		$context
	);

	/**
	 * Filter `mrw_hidden_site_blocks` allows showing all hidden "Site"/"Theme" blocks by removing them from the hidden list. Use __return_empty_array to unhide all blocks.
	 *
	 * @since 2.5.0
	 */
	$hidden_site_blocks = apply_filters(
		'mrw_hidden_site_blocks',
		array(
			'core/breadcrumbs',
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
			'core/template-part',
		),
		$context
	);

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

	if ( ! in_array( 'wp_more', $mce_buttons, true ) ) {
		$hidden_blocks[] = 'core/more';
	}

	/**
	 * Filter the full list of hidden blocks
	 *
	 * @param array $blocks array of all blocks hidden by default
	 * @param string $context name of editor context
	 *
	 * @since 2.3.0
	 */
	return apply_filters( 'mrw_hidden_blocks', $hidden_blocks, $context );
}

add_filter( 'mrw_hidden_site_blocks', __NAMESPACE__ . '\show_blocks_in_site_editor', 0, 2 );
add_filter( 'mrw_hidden_query_blocks', __NAMESPACE__ . '\show_blocks_in_site_editor', 0, 2 );
/**
 * Show all query- and post-related blocks in the Site Editor
 *
 * @param array  $blocks array of all hidden blocks
 * @param string $context name of editor context
 */
function show_blocks_in_site_editor( $blocks, $context ) {
	if ( $context === 'site-editor' ) {
		$blocks = array();
	}

	return $blocks;
}

/**
 * Return list of hidden embeds
 */
function hidden_embeds() {

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
	 * Filter list of hidden embeds
	 *
	 * @since 2.4.0
	 */
	return apply_filters( 'mrw_hidden_embeds', $hidden_embeds );
}

/**
 * Return list of hidden social links
 */
function hidden_social_links() {

	$hidden_social_links = array(
		'amazon',
		'bandcamp',
		'behance',
		'behance',
		'codepen',
		'deviantart',
		'discord',
		'dribbble',
		'dropbox',
		'etsy',
		'fivehundredpx',
		'foursquare',
		'goodreads',
		'gravatar',
		'lastfm',
		'medium',
		'meetup',
		'pocket',
		'twitch',
		'vk',
		'yelp',
	);

	/**
	 * Filter list of hidden social links
	 *
	 * @since 2.14.0
	 */
	return apply_filters( 'mrw_hidden_social_links', $hidden_social_links );
}

add_action( 'jetpack_register_gutenberg_extensions', __NAMESPACE__ . '\jetpack_hidden_blocks', 99 );
/**
 * Hidden Jetpack Blocks
 *
 * @see  https://developer.jetpack.com/hooks/jetpack_register_gutenberg_extensions/
 */
function jetpack_hidden_blocks() {

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
		'goodreads',
		'markdown',
		'nextdoor',
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
	 * Filter the list of hidden Jetpack blocks
	 *
	 * @since 2.3.0
	 */
	$mrw_jetpack_hidden_blocks = apply_filters(
		'mrw_jetpack_hidden_blocks',
		$jetpack_hidden_content_blocks
	);

	foreach ( $mrw_jetpack_hidden_blocks as $block ) {
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
function hidden_block_styles() {

	$hidden_styles = array(
		'core/image'        => array( 'default', 'circle-mask', 'rounded' ),
		'core/button'       => array( 'default', 'fill', 'squared', 'outline' ),
		'core/quote'        => array( 'default', 'large' ),
		'core/separator'    => array( 'default', 'wide', 'dots' ),
		'core/pullquote'    => array( 'default', 'solid-color' ),
		'core/table'        => array( 'default', 'stripes' ),
		'core/social-links' => array( 'default', 'logos-only', 'pill-shape' ),
	);

	/**
	 * Filter the list of hidden block styles
	 *
	 * @since 2.3.0
	 */
	return apply_filters( 'mrw_hidden_block_styles', $hidden_styles );
}

/**
 * Return filtered array of Block Editor Features/Settings to hide
 *
 * @return array every option to hide via CSS or JS
 */
function hidden_block_editor_settings() {

	$hidden_block_editor_settings = array(
		'block-directory',
		'border',
		'border-radius',
		'custom-css',
		'default-color-palette',
		'default-gradients',
		'default-style-variation',
		'drop-cap',
		'duotone',
		'fit-text-heading',
		'fit-text-paragraph',
		'font-library',
		'font-weight',
		'font-style',
		'heading-1',
		'heading-5',
		'heading-6',
		'heading-variations',
		'highlight',
		'image-background',
		'image-dimensions',
		'image-file-upload',
		'image-url',
		'inline-code',
		'inline-image',
		'justification-group',
		'keyboard',
		'layout-width',
		'letter-spacing',
		'line-height',
		'min-height-group',
		'new-tabs',
		'padding',
		'pullquote-border',
		'shadow',
		'spacing',
		'sticky-position',
		'text-decoration',
		'text-indent',
		'text-orientation',
		'text-transform',
	);

	/**
	 * Filter the list of hidden block editor settings
	 *
	 * @since 2.3.0
	 */
	return apply_filters( 'mrw_hidden_block_editor_settings', $hidden_block_editor_settings );
}

add_filter( 'block_type_metadata', __NAMESPACE__ . '\filter_block_type_metadata', 99 );
/**
 * Filters the metadata provided for registering a block type.
 *
 * @param array $metadata Metadata for registering a block type.
 *
 * @return array Metadata for registering a block type.
 *
 * @since 2.15.0
 */
function filter_block_type_metadata( $metadata ) {
	$hidden_settings = hidden_block_editor_settings();

	/* Custom CSS */
	if ( in_array( 'custom-css', $hidden_settings, true ) ) {
		$metadata['supports']['customCSS'] = false;
	}

	/* Text Indent */
	if ( isset( $metadata['supports']['typography']['textIndent'] ) && in_array( 'text-indent', $hidden_settings, true ) ) {
		$metadata['supports']['typography']['textIndent'] = false;
	}

	/* Fit Text in WP7.0+ */
	if ( $metadata['name'] === 'core/paragraph' && in_array( 'fit-text-paragraph', $hidden_settings, true ) ) {
		$metadata['supports']['typography']['fitText'] = false;
	}

	/* Fit Text in WP7.0+ */
	if ( $metadata['name'] === 'core/heading' && in_array( 'fit-text-heading', $hidden_settings, true ) ) {
		$metadata['supports']['typography']['fitText'] = false;
	}

	return $metadata;
}

add_filter( 'block_editor_settings_all', __NAMESPACE__ . '\block_editor_settings', 99 );
/**
 * Make changes to editor settings, accounting for plugin filters, via the core block_editor_settings filter
 *
 * @param  array $editor_settings default editor settings
 * @return array                  modified settings
 *
 * @see https://github.com/joppuyo/remove-drop-cap/blob/v1.1.0/remove-drop-cap.php#L22
 */
function block_editor_settings( $editor_settings ) {

	$hidden_settings = hidden_block_editor_settings();

	/* Border */
	if ( in_array( 'border', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['border'] = array();
	}

	/* Border Radius, Button */
	if ( in_array( 'border-radius', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['blocks']['core/button']['border']['radius'] = false;
	}

	/* Default Color Pallete */
	if ( in_array( 'default-color-palette', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['color']['defaultPalette'] = false;
	}

	/* Default Gradients */
	if ( in_array( 'default-gradients', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['color']['defaultGradients'] = false;
	}

	/* Drop Cap */
	if ( in_array( 'drop-cap', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['typography']['dropCap'] = false;
	}

	/* Duotone */
	if ( in_array( 'duotone', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['color']['defaultDuotone'] = false;
		$editor_settings['__experimentalFeatures']['color']['customDuotone']  = false;
	}

	/* Font Library - Seems like this doesn't work, leaving for now: https://github.com/WordPress/developer-blog-content/issues/337*/
	if ( in_array( 'font-library', $hidden_settings, true ) ) {
		$editor_settings['fontLibraryEnabled'] = false;
	}

	/* Font Style */
	if ( in_array( 'font-style', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['typography']['fontStyle'] = false;
	}

	/* Font Weight */
	if ( in_array( 'font-weight', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['typography']['fontWeight'] = false;
	}

	/* Gap and Margin */
	if ( in_array( 'spacing', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['spacing'] = array();
	}

	/* Image Background (just Group for not, not including Cover) */
	if ( in_array( 'image-background', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['background']['backgroundImage'] = false;
	}

	/* Letter Spacing */
	if ( in_array( 'letter-spacing', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['typography']['letterSpacing'] = false;
	}

	/* Line Height */
	if ( in_array( 'line-height', $hidden_settings, true ) ) {
		$editor_settings['enableCustomLineHeight'] = false;
	}

	/* Padding */
	if ( in_array( 'padding', $hidden_settings, true ) ) {
		$editor_settings['enableCustomSpacing'] = false;
	}

	/* Pullquote Border */
	if ( in_array( 'pullquote-border', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border'] = array();
	}

	/* Shadow */
	if ( in_array( 'shadow', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['shadow']['defaultPresets'] = false;
	}

	/* Text Decoration */
	if ( in_array( 'text-decoration', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['typography']['textDecoration'] = false;
	}

	/* Text Orientation */
	if ( in_array( 'text-orientation', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['typography']['writingMode'] = false;
	}

	/* Text Transform */
	if ( in_array( 'text-transform', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['typography']['textTransform'] = false;
	}

	/* Min Height on the Group block (not the cover block) */
	if ( in_array( 'min-height-group', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['dimensions']['minHeight'] = false;
	}

	/* Position Sticky */
	if ( in_array( 'sticky-position', $hidden_settings, true ) ) {
		$editor_settings['__experimentalFeatures']['position']['sticky'] = false;
	}

	return $editor_settings;
}

add_action( 'admin_menu', __NAMESPACE__ . '\remove_font_library_menu' );
/**
 * Removes the new Font Library menu item for Classic in WP 7.0
 *
 * @since 2.15.0
 *
 * @return void
 */
function remove_font_library_menu() {
	$hidden_settings = hidden_block_editor_settings();

	if ( in_array( 'font-library', $hidden_settings, true ) ) {
		remove_submenu_page( 'themes.php', 'font-library.php' );
	}
}

/**
 * Prepare all plugin options (after being filtered) for use in JavaScript
 *
 * @return array all hidden blocks, block styles, and block editor settings
 */
function block_editor_js_config() {

	$js_options = array();

	// Note: using array_values to ensure this is passed as an array and not an object

	/* Blocks */
	$js_options['hiddenBlocks'] = array_values( hidden_blocks() );

	/* Embed Variations */
	$js_options['hiddenEmbeds'] = array_values( hidden_embeds() );

	/* Social Links */
	$js_options['hiddenSocialLinks'] = array_values( hidden_social_links() );

	/* Block Styles */
	$hidden_styles = array();
	foreach ( hidden_block_styles() as $block => $styles ) {
		$hidden_styles[ $block ] = array_values( $styles );
	}

	$js_options['hiddenStyles'] = $hidden_styles;

	/* Features */
	$js_options['hiddenSettings'] = array_values( hidden_block_editor_settings() );

	return $js_options;
}

add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\block_editor_assets' );
/**
 * Enqueue CSS and JS files that modify/hide block editor settings in the admin
 */
function block_editor_assets() {

	/**
	 * Ensure the correct dependencies depending on the editor being used
	 *
	 * Thank you Sally CJ! https://wordpress.stackexchange.com/a/413631/9844
	 */
	$script_dependencies = array( 'wp-blocks', 'wp-dom-ready' );
	$screen              = get_current_screen();
	$context             = $screen ? $screen->id : '';
	switch ( $context ) {
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
		plugins_url( 'css/block-editor.css', __DIR__ ),
		array(),
		MRW_SIMPLIFIED_EDITOR_VERSION
	);

	wp_register_script(
		'mrw-block-editor-js',
		plugins_url( 'js/block-editor.js', __DIR__ ),
		$script_dependencies,
		MRW_SIMPLIFIED_EDITOR_VERSION,
		array( 'in_footer' => true )
	);

	wp_localize_script(
		'mrw-block-editor-js',
		'mrwEditorOptions',
		block_editor_js_config()
	);

	wp_enqueue_script( 'mrw-block-editor-js' );
}

add_action( 'enqueue_block_assets', __NAMESPACE__ . '\block_styles' );
/**
 * Enqueue CSS that styles blocks, not the editor. For example, changing the display of the media placeholder block
 *
 * @return void
 */
function block_styles() {
	if ( is_admin() ) {
		wp_enqueue_style(
			'mrw-blocks-css',
			plugins_url( 'css/blocks.css', __DIR__ ),
			array(),
			MRW_SIMPLIFIED_EDITOR_VERSION
		);
	}
}

add_action( 'admin_body_class', __NAMESPACE__ . '\block_editor_settings_admin_classes' );
/**
 * Apply body classes to admin for each features that are hidden via CSS
 *
 * @param  array $classes list of hidden features
 * @return array
 */
function block_editor_settings_admin_classes( $classes ) {

	$current_screen = get_current_screen();

	if ( isset( $current_screen->is_block_editor ) && (bool) $current_screen->is_block_editor ) {
		$prefix                       = ' mrw-block-editor-no-';
		$hidden_block_editor_settings = hidden_block_editor_settings();
		$hidden_blocks                = hidden_blocks();

		foreach ( $hidden_block_editor_settings as $setting ) {
			$classes .= $prefix . sanitize_title_with_dashes( $setting );
		}

		if ( in_array( 'core/cover', $hidden_blocks, true ) ) {
			$classes .= $prefix . 'cover-block';
		}
	}

	return $classes;
}
