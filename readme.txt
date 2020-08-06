=== MRW Simplified Editor ===
Contributors: mrwweb
Tags: Block Editor, Gutenberg, TinyMCE, Editor Styles, Editor
Requires at least: 4.1
Requires PHP: 5.6.20
Tested up to: 5.5
Stable tag: 2.2.0
Donate link: https://www.paypal.me/rootwiley
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Focus editors on making great content and letting their themes make it beautiful by removing block editor features.

== Description ==

Help your CMS editors create semantic content and style it with the theme for consistent formatting and portable content. This plugin removes blocks and other styling options to help editors focus.

**Developers can adjust this plugin via filters. There are no settings.**

> I built this plugin for use on client sites. I hopes you'll find it useful! **This is an opinionated plugin.** Read an in-depth reasoning behind the decisions made by this plugin in the post ["A WordPress Formatting Manifesto."](http://mrwweb.com/wordpress-formatting-manifesto/)

[Contribute on Github.](https://github.com/mrwweb/mrw-simplified-editor-wordpress/)

= Block Editor Features =

- **Hidden Blocks:** Verse, Table, Preformatted, Code, More, Nextpage, Spacer, Calendar, Tag Cloud, Search, RSS, Audio, Video, Archive, many less popular embed source (see FAQ)
- **Removes default Block Style Variations and the "Default style" feature**
- **Removes default Block Patterns (WP 5.5)**
- **Removes Block Directory (WP 5.5)**
- **Hides Settings:** Drop Cap (broken in WP 5.5), Heading 1, Heading 5, Heading 6, image percentage and pixel sizing, and font sizing by pixel
- **Encourages use of Media Library** by hiding buttons for uploading images and inserting via URL
- **Disables color & gradient settings** unless a theme explicitly defines a color palette or gradient presets
- **Links:** Remove most ways of opening links in a new tab
- **Other:** Increases prominence of contrast errors, styles "Save draft" as a button

= Classic Editor / Classic Block Features =

Reduce editor to a single row of buttons: "Styleselect" (Headings 2-4 and Blockquote as well as Strikethrough, Subscript, Superscript, Preformatted, and Code), Bold, Italic, Add/Edit Link, Break Link, Horizontal Rule (added 1.2.0), Paste as Plain Text, Remove Styles, Special Characters, Undo, Redo, Help, Distraction Free Mode.

== Frequently Asked Questions ==

= Block Editor Filters =

- `mrw_disabled_blocks` - Array of blocks hidden by default.
- `mrw_disabled_style_variations` - Hides all core Block Style Variations. Unset either an entire block's worth of variations or a specific one.
- `mrw_disabled_block_editor_settings` - An array of Block Settings hidden by the editor. Current hidden settings:
	- `drop-cap` - Drop Cap setting for Paragraph Block
	- `image-file-upload` - Button to upload image directly rather than through Media Library in Image, Cover, Media & Text, and Gallery Blocks.
	- `image-url` - Button to insert image from a URL rather than uploaded to Media Library in Image, Cover, Media & Text, and Gallery Blocks.
	- `heading-1` - Heading 1 option in Heading Block
	- `heading-5` - Heading 5 option in Heading Block
	- `heading-6` - Heading 6 option in Heading Block
	- `image-dimensions` - Pixel and percentage sizing of images in Image Block
	- `new-tabs` - Option to open links in new tabs for links, buttons, and images
- `mrw_block_editor_hide_color_palette` - Whether to display the default or theme color palette. Defaults to true (hide it). Will automatically change to false if theme registers a custom palette via `get_theme_support( 'editor-color-palette' )`.
- `mrw_block_editor_hide_gradient_presets` - Whether to display the default or theme  gradient presets. Defaults to true (hide it). Will automatically change to false if theme registers a custom palette via `get_theme_support( 'editor-gradient-presets' )`.

= Which embed blocks are hidden? =

Amazon Kindle, Animoto, Cloudup, Crowd Signal, Daily Motion, Hulu, Mixcloud, Polldaddy, Reverbnation, Smugmug, Speaker, VideoPress, and WordPress.tv

= Block Editor Filter Code Examples =

Below are a variety of useful, tested code examples for modifying the plugin's settings.

**Hide or Unhide a Block**

`
add_filter( 'mrw_disabled_blocks', 'show_verse_hide_comments' );
function show_verse_hide_comments( $disabled_blocks ) {

	// Unhide the Verse Block (hidden by default)
	$disabled_blocks = array_diff( $disabled_blocks, array( 'core/verse' ) );

	// Hide the Latest Comments block (not hidden by default)
	$disabled_blocks[] = 'core/latest-comments';

	return $disabled_blocks;

}
`

**Show one or some default Block Variations hidden by the plugin**

`
add_filter( 'mrw_disabled_style_variations', 'show_rounded_img_and_separator_styles' );
function show_rounded_img_and_separator_styles( $disabled_style_variations ) {

	// Unhide (show) one specific variation for a block type
	$disabled_style_variations['core/image'] = array_diff(
		$disabled_style_variations['core/image'],
		array( 'rounded')
	);

	// Unhide (show) *all* variations for a block type
	unset( $disabled_style_variations['core/separator'] );

	return $disabled_style_variations;

}
`

**Show a few Block Settings hidden by the plugin**

`
add_filter( 'mrw_block_editor_disable_settings', 'show_drop_cap_heading_1' );
function show_drop_cap_heading_1( $features ) {
	return array_diff( $features, array( 'drop-cap', 'heading-1' ) );
}
`

= Classic Editor / Classic Block Filters =

`mrw_mce_text_style` - Add custom text/formatting styles to the Styleselect options

= Classic Editor / Block Editor: Add the "Insert More Tag" and More Block at once =

If you need the More Tag button or block, use the following snippet:

`
/* Add "Insert More Tag" Button and Block */
add_filter( 'mce_buttons', 'mrw_mce_add_more_tag_button' );
function mrw_mce_add_more_tag_button( $buttons ) {
    $buttons[57] = 'wp_more';
    ksort($buttons);
    return $buttons;
}
`

= Classic Editor Custom Styles Code Examples =

**Note:** When using this, make sure to style the CSS classes with your [`editor-style.css` file](http://codex.wordpress.org/Editor_Style).

`
add_filter( 'mrw_mce_text_style', 'mrw_add_text_styles_example' );
/**
 * Adds a "Text Styles" submenu to the "Formats" dropdown
 * 
 * @param array $styles Contains arrays of style_format arguments to define styles.
 * 						Note: Should be an "array of arrays"
 * 
 * @see tinymce.com/wiki.php/Configuration:style_formats
 * @see tinymce.com/wiki.php/Configuration:formats
 * @see wordpress.stackexchange.com/a/128950/9844
 */
function mrw_add_text_styles_example( $styles ) {
	$new_styles = array(
		/* Inline style that only applies to links */
		array(
			'title' => "Link Button", /* Label in "Formats" menu */
			'selector' => 'a', /* this style can ONLY be applied to existing <a> elements in the selection! */
			'classes' => 'button' /* class to add */
		),
		/* Inline style applied with a <span> */
		array(
			'title' => "Callout Text",
			'inline' => 'span', /* "inline" key for inline phrasing elements */
			'classes' => 'callout'
		),
		/* Block style applied to paragraph. Each paragraph in selection gets the classes. */
		array(
			'title' => "Warning Message",
			'block' => 'p', /* "block" key for block-level elements. these don't always behave */
			'classes' => 'message warning'  /* two classes work (space-separated) but can't be undone easily via editor */
		),
		/* Block style capable of containing other block-level elements */
		array(
			'title' => "Feature Box",
			'block' => 'section', 
			'classes' => 'feature-box',
			'wrapper' => true
		)
	);
	return array_merge( $styles, $new_styles );
}`

== Screenshots ==

1. The Block Editor simplified, here with no colors or drop caps for the Paragraph block.

2. The "Classic" block of the WordPress 5.0 block editor reflects the impact of this plugin.

3. The Classic Editor/Block in all its minimal glory. This shows the default set of buttons and styles.

4. "Link Button" is an example of a text style that can be added with the [`mrw_mce_text_style` filter](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/other-notes/). In this example, it's grayed-out by default since it can only be applied to links!

== Changelog ==

= 2.2.0 (Aug 5, 2020) =
* WordPress 5.5 support
* [NEW] WP 5.5 features disabled:
	* Core Block Patterns
	* Block Directory Installer
* [NEW] Hide "Default style" select for style variations (the theme's default is the default for a reason!)
* [Fix] Hide Headings 1, 5, and 6 in all languages, not just English
* [Fix] Adjust "Save draft" button to show consistently and match new secondary button styles
* [Fix] Restore more prominent color contrast errors
* [Fix] Restore ability to edit galleries (props to Mackenzie at WSCADV for reporting this one)
* [Regression] WordPress 5.5 makes it impossible to hide the Dropcap option
* [Dev] **Deprecated Filters:** Remove all instances of "blacklist" from the plugin. `mrw_block_blacklist` and `mrw_style_variations_blacklist` are now deprecated in favor of `mrw_disabled_blocks` and `mrw_disabled_style_variations`. Respective object properties in JS are also renamed. Deprecate `mrw_block_editor_disable_settings` and add `mrw_disabled_block_editor_settings` for consistency. *Filters will be removed from the plugin as early as August 2021.*
* [Dev] Refactor internal functions for managing default options

= Full Changelog =
* [Changelog on Github](https://github.com/mrwweb/mrw-simplified-editor-wordpress/blob/master/changelog.txt)

== Upgrade Notice ==
= 2.2.0 =
* Important WordPress 5.5 compatibility fixes. Remove Core Block Patterns and Block Directory.