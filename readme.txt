=== MRW Simplified Editor ===
Contributors: mrwweb
Tags: Block Editor, Gutenberg, TinyMCE, Editor Styles, Editor
Requires at least: 4.1
Requires PHP: 5.6.20
Tested up to: 5.4
Stable tag: 2.1.0
Donate link: https://www.paypal.me/rootwiley
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Focus editors on making great content and letting their themes make it beautiful by smartly reducing the number of options in the Block and Classic Editors. Formerly "MRW Web Design Simple TinyMCE"

== Description ==

*(Formerly "MRW Web Design Simple TinyMCE")*

When publishing content with a CMS, content should be entered semantically and formatted via a design system (created by the theme) to ensure consistent formatting and portable content.

**This plugin simplifies both the Block and Classic Editors to focus users on creating content, not formatting words.** There are no settings, and a few useful filters.

> I built this plugin for use on client sites and share it in hopes that others will find it helpful. I'm highly motivated to maintain it since I use it for other people.
> 
> **This is an opinionated plugin.** You can read an in-depth reasoning behind the decisions made by this plugin in the post ["A WordPress Formatting Manifesto."](http://mrwweb.com/wordpress-formatting-manifesto/)
>
> [Submit Issues and follow development on Github.](https://github.com/mrwweb/mrw-web-design-simple-tinymce)

= Block Editor Features =

All features can be re-enabled via core filters or plugin filters.

- **Hidden Blocks:** Verse, Table, Preformatted, Code, More, Nextpage, Spacer, Calendar, Tag Cloud, Search, RSS, Audio, Video, and Archive
- **Hidden Embeds:** Amazon Kindle, Animoto, Cloudup, College Humor (Removed from Core in 5.4), Crowd Signal, Daily Motion, Hulu, Mixcloud, Polldaddy, Reverbnation, Smugmug, Speaker, Videopress, and Wordpress.tv
- **Removes all default Block Style Variations**
- **Hides Settings:** Drop Cap, Heading 1*, Heading 5*, Heading 6*, image percentage and pixel sizing, and font sizing by pixel
- **Encourages use of Media Library** by hiding buttons for uploading images or inserting images via URL
- **Disables color & gradient settings** unless a theme explicitly defines a color palette or gradient presets
- **Links:** Remove most ways of opening links in a new tab
- **Other:** Increases prominence of contrast errors

\* Currently, headings 1, 5, and 6 are only hidden on English-language sites.

= Classic Editor / Classic Block Features =

This plugin creates a single row of buttons containing the following (see also: plugin banner):

> "Styleselect,"* Bold, Italic, Add/Edit Link, Break Link, Horizontal Rule (added 1.2.0), Paste as Plain Text,** Remove Styles, Special Characters, Undo, Redo, Help, Distraction Free Mode.

This plugin also provides a simple-yet-powerful filter (see below) for developers to add the ability to apply custom styles with the editor.

*\* The Styleselect contains Headings 2-4 and Blockquote as well as Strikethrough, Subscript, Superscript, Preformatted, and Code (added in v1.1.0) in an "Other Formats" submenu.*

= Other Plugins by MRWweb =

* [Feature a Page Widget](https://wordpress.org/plugins/feature-a-page-widget/) - Shows a summary of any Page in any sidebar.
* [Post Type Archive Descriptions](https://wordpress.org/plugins/post-type-archive-descriptions/) - Enables an editable description for a post type to display at the top of the post type archive page.
* [Post Status Menu Items](http://wordpress.org/plugins/post-status-menu-items/) - Adds post status links–e.g. "Draft" (7)–to post type admin menus.
* [Hawaiian Characters](http://wordpress.org/plugins/hawaiian-characters/) - Adds the correct characters with diacriticals to the WordPress editor Character Map for Hawaiian

== Installation ==

1. Upload `/mrw-web-design-simple-tinymce/` to the `/wp-content/plugins/` directory
1. Activate the plugin through the "Plugins" menu in WordPress
1. Write away, right away!

\- OR -

1. From your WordPress site's dashboard, go to Plugins > Add New.
1. Search for "MRW Web Design Simple TinyMCE."
1. The plugin should be the first result. Click "Install."
1. Allow the plugin to install, then click "Activate."
1. Write away, right away!

== Frequently Asked Questions ==

= Is this plugin compatible with WordPress 5.0 / "Gutenberg"? =

Yes! As of v2.0.0, the plugin removes some blocks, all default style variations, and a number of annoying settings that distract from making good content.

= What happens to the old features of this plugin? =

Nothing! All the changes made to the Classic editor remain in place and appear in the Classic Block in the Block Editor.

See Screenshot #3 to see the "Classic" block with this plugin enabled.

= What happened to the "Formats" dropdown in WordPress 5.0? =

As noted earlier, any changes you've made to this plugin are still reflected in the Classic block of the new editor. You and your users can access custom styles via the Formats dropdown in the Classic block.

However, the new editor supports a ["Block Style Variation feature"](https://wordpress.org/gutenberg/handbook/designers-developers/developers/filters/block-filters/#block-style-variations) that is a better experience in the new editor. It allows you to set new styling classes on an existing block, very similar to how Formats worked in TinyMCE.

= Block Editor Filters =

- `mrw_block_blacklist` - An array of blocks hidden by default. Add blocks to hide them or remove blocks from the array to show them.
- `mrw_style_variations_blacklist` - Hides all default Block Style Variations. Unset either an entire block's worth of variations or a specific one.
- `mrw_block_editor_disable_settings` - An array of Block Settings hidden by the editor. Current hidden settings:
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

= Block Editor Filter Code Examples =

Below are a variety of useful, tested code examples for modifying the plugin's settings.

**Allow use of default color palette**

`
add_filter( 'mrw_block_editor_hide_color_palette', '__return_true' );
`

**Allow use of default gradient presets**

`
add_filter( 'mrw_block_editor_hide_gradient_presets', '__return_true' );
`

**Hide or Unhide a Block**

`
add_filter( 'mrw_block_blacklist', 'show_verse_and_hide_latest_comments' );
function show_verse_and_hide_latest_comments( $blacklist ) {

	// Unhide the Verse Block (hidden by default)
	$blacklist = array_diff( $blacklist, array( 'core/verse' ) );

	// Hide the Latest Comments block (not hidden by default)
	$blacklist[] = 'core/latest-comments';

	return $blacklist;

}
`

**Show one or some default Block Variations hidden by the plugin**

`
add_filter( 'mrw_style_variations_blacklist', 'show_circle_image_and_all_separator_styles' );
function show_circle_image_and_all_separator_styles( $blacklist ) {

	/*
	STRUCTURE:
	$blacklist = array(
		'block-1' => array( 'variation-1', 'variation-2' ),
		'block-2' => array( 'variation-1', 'variation-2' ),
		// etc...
	);
	*/

	// Unhide one specific variation for a block type
	$blacklist['core/image'] = array_diff(
		$blacklist['core/image'],
		array( 'circle-mask')
	);

	// Unhide *all* variations for a block type
	unset( $blacklist['core/separator'] );

	return $blacklist;

}
`

**Show a few Block Settings hidden by the plugin**

This will show (unhide, really) the Drop Cap and Heading 1 settings for the Paragraph and Heading Blocks, respectively.

`
add_filter( 'mrw_block_editor_disable_settings', 'bring_back_the_drop_cap_and_heading_1' );
function bring_back_the_drop_cap_and_heading_1( $features ) {
	return array_diff( $features, array( 'drop-cap', 'heading-1' ) );
}
`

= Classic Editor / Classic Block Filters =

The plugin hooks early to the standard `mce_buttons`, `mce_buttons_2`, 	and `tiny_mce_before_init` filters so that it's easy to override.

This plugin replaces the "formatselect" with the "styleselect" for its added support of custom CSS styles. There is easy-to-use filter for allowing the application of CSS classes in the editor: `mrw_mce_text_style`. You can find an [example of the filter's usage on the "Other Notes" tag](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/other_notes/). See also:

* [tinymce.com/wiki.php/Configuration:style_formats](http://tinymce.com/wiki.php/Configuration:style_formats)
* [tinymce.com/wiki.php/Configuration:formats](http://tinymce.com/wiki.php/Configuration:formats)
* [wordpress.stackexchange.com/a/128950/9844](http://wordpress.stackexchange.com/a/128950/9844)

= Classic Editor / Block Editor: Add the "Insert More Tag" and More Block at once =

This is the one button that might legitimately be missing from this plugin for a small subset of users. If you need it, use the following snippet in your theme's `functions.php` file. (Since the More Tag is used by a theme, the `functions.php` files is a good place for it.)

`
/* Add "Insert More Tag" Button in Text Editor After charmap */
add_filter( 'mce_buttons', 'mrw_mce_add_more_tag_button' );
function mrw_mce_add_more_tag_button( $buttons ) {
    $buttons[57] = 'wp_more';
    ksort($buttons);
    return $buttons;
}
`

= Classic Editor Custom Styles Code Examples =

**Warning:** The following feature is almost completely useless without an accompanying set of CSS rules in [an `editor-style.css` file](http://codex.wordpress.org/Editor_Style).

Here's how the `mrw_mce_text_style` filter works:
`
add_filter( 'mrw_mce_text_style', 'mrw_add_text_styles_example' );
/**
 * Example filter to add text styles to TinyMCE filter with Mark's "MRW TinyMCE Mods" plugin
 * 
 * Adds a "Text Styles" submenu to the "Formats" dropdown
 * 
 * This would go in a functions.php file or mu-plugin so you don't have to modify the original plugin.
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

3. The CLassic Editor in all its minimal glory. This shows the default set of buttons and styles.

4. "Link Button" is an example of a text style that can be added with the [`mrw_mce_text_style` filter](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/other-notes/). In this example, it's grayed-out by default since it can only be applied to links!

4. Example from Block Editor showing reduced settings of Paragraph block. Just write!

== Changelog ==

= 2.1.0 (Mar 30, 2020) =
* Significant WordPress 5.4 compatibility updates/fixes
* [New] Remove default Gradient Presets if theme does not provide them. This matches the existing behavior for Color Palettes.
* [New] Remove majority of ways to open links in a new tab
* [New] Style "Save Draft" button as a button for greater prominence
* [Dev] Make `mrw_block_editor_disable_settings` filterable array available in JavaScript as `mrwEditorOptions.featureBlacklist`

= 2.0.2 (Jan 13, 2019) =
* Add check for get_current_screen() to prevent errors when using TinyMCE on the front end. props @patrick-b

= 2.0.1 (Nov 14, 2019) =
* Fix release package. See 2.0.0 release notes.

= 2.0.0 (Nov 14, 2019) =
* [NEW] MAJOR UPDATE! Includes numerous changes to the Block Editor made using the same philosophy of encouraging editors to create semantic, portable content while letting themes make content beautiful. This update removes:
	* **Blocks:** Verse, Table, Preformatted, Code, More, Nextpage, HTML, Calendar, Tag Cloud, Search, RSS, Audio, Video, and Archive.
		* The "More" Block is shown if you previously used this plugin and had filtered the TinyMCE buttons to re-add the More button.
	* **Embeds:** Amazon Kindle, Animoto, Cloudup, College Humor, Crowd Signal, Daily Motion, Hulu, Mixcloud, Polldaddy, Reverbnation, Smugmug, Speaker, Videopress, and Wordpress.tv.
	* **All default Block Style Variations.**
	* **Block Settings:** Drop Cap, Heading 1, Heading 5, Heading 6, percentage and pixel sizing for images, and font sizing by pixel.
	* **Image Uploads:** All images are selected from and uploaded to "Media Library."
	* Colors: All color options unless theme explicitly defines a color palette.
* [NEW] Calls extra attention to color contrast errors.
* [NEW] Block Editor Filters
	* `mrw_block_blacklist` filter allows hiding blocks from the editor in PHP.
	* `mrw_style_variations_blacklist` filter allows hiding style variations in PHP.
	* `mrw_block_editor_disable_settings` filter for re-enabling settings hidden by this plugin
	* `mrw_block_editor_hide_color_palette` filter to unhide default Block Editor color palette

= 1.2.0 (Nov 13, 2016) =
* Update "Heading" list to emphasize implied hierarchy. (See [#38049](https://core.trac.wordpress.org/ticket/38049) for background and potential core inclusion.)
* Add horizontal rule button.
* Rename "Text Styles" to "Custom Styles" for clarity.
* Remove Indent/Outdent buttons. (Use TAB / SHIFT + TAB for list indentation.)
* Remove code and pre from "Other Formats". (Use `backticks` for code.)
* Update textdomain to support language packs.
* Escape all translations

= 1.1.0 (Mar 13, 2015) =
* Hide `wp_help` button on mobile just like WordPress 4.2 ([#31161](https://core.trac.wordpress.org/ticket/31161)).
* Add `code` element to available "Other Formats."

= 1.0.5 (Feb 13, 2015) =
* Improved code formatting thanks to [@robneu](https://profiles.wordpress.org/fatmedia/)!
* Add keys to the `$buttons` array filtered by `mce_buttons` for more intuitive button insertion.
* Example of above and working with "Text Styles" submenu added as "Code Recipes" in ["Other Notes"](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/other_notes/).
* [Breaking Change] Remove `mrw_mce_style_formats` filter. It was a stupid idea and I doubt anyone's used it yet.
* Fixed PNG mime-types for files used by repository in `/assets/`

= 1.0.4 (Feb 6, 2015) =
* Cleaned up and submitted to the repository.
* Renamed "MRW Web Design Simple TinyMCE"
* New readme, screenshots, etc.
* Feb 12, 2015: No version update, but revised screenshots and improved readme.

= 1.0.3 (Jan 5, 2015) =
* Change "fullscreen" to "dfw" for Distraction Free Writing Mode support in 4.1.

= 1.0.2 (Sept 16, 2014) =
* Fix "Header" to "Heading." D'oh!

= 1.0.1 (May 9, 2014) =
* [Fix] Fix Help Icon

= 1.0 (May 5, 2014) =
* Initial release

== Upgrade Notice ==
= 2.1.0 =
* Important WordPress 5.4 compatibility fixes. Disable default gradients and social icon style variations.

= 2.0.2 =
* Bug fix for front-end TinyMCE. (2.0.0 is a MAJOR UPDATE: Hide infrequently used blocks, all default style variations, and many block settings from WordPress 5.0+ Block Editor.)

= 2.0.1 =
* MAJOR UPDATE: Hide infrequently used blocks, all default style variations, and many block settings from WordPress 5.0+ Block Editor.

= 1.1.0 =
* Beating WordPress 4.2 to hiding `wp_help` on mobile. Adding `code` element to "Other Formats."

= 1.0.5 =
* Better formatting and inline documentation. BREAKING CHANGE: Remove `mrw_mce_style_formats` filter. I doubt you were using it.

= 1.0.4 =
* I'm impressed you had this installed already. Welcome to the beautiful world of automatic updates.