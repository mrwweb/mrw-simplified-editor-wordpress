=== MRW Simplified Editor ===
Contributors: mrwweb
Tags: Block Editor, Blocks, Gutenberg, Editor Styles, Editor
Requires at least: 4.1
Requires PHP: 5.6.20
Tested up to: 5.6
Stable tag: 2.5.0
Donate link: https://www.paypal.me/rootwiley
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Focus editors on making great content and letting their themes make it beautiful by removing block editor features.

== Description ==

Help your site's editors create semantic content and style it with the theme for consistent formatting and portable content. This plugin removes blocks and other styling options to help editors focus.

> I built this plugin for use on client sites. I hope you'll find it useful! **This is an opinionated plugin.** Read an in-depth reasoning behind the decisions made by this plugin in the post ["A WordPress Formatting Manifesto."](http://mrwweb.com/wordpress-formatting-manifesto/) If you find it compelling, then you'll probably like this plugin!

[Contribute on Github.](https://github.com/mrwweb/mrw-simplified-editor-wordpress/)

= Block Editor Features =

This plugin greatly simplifies the block editor by **hiding** all of the following features. Filters are provided for developers to adjust what is hidden (including making it easier to hide additional blocks).

- **Infrequently Used Core Blocks** such as Verse, Table, Audio, Video, etc., and all Query- and Site-related blocks. See [FAQ for full list of hidden blocks](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/#faq).
- **All Core Block Styles and the "Default style" feature**
- **Some Block Editor Settings:** Drop Cap, Heading 1, Heading 5, Heading 6, image percentage and pixel sizing, font sizing by pixel, open links in new tabs (mostly hidden)
- **Default Color & gradient settings** (Custom theme palettes/settings are never hidden)
- **Block Patterns (WP 5.5+)**
- **Block Directory (WP 5.5+)**
- **Infrequently Used Jetpack Blocks** - See [FAQ for full list of hidden blocks](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/#faq).
- **"Upload" and "Insert from URL" image options** to encourage use of Media Library

The plugin also improves the editor by:

- **Increasing prominence of contrast errors**
- **Styling "Save draft" as a button**

= Classic Editor / Classic Block Features =

Reduces editor to a single row of buttons: "Styleselect" (Headings 2-4 and Blockquote as well as Strikethrough, Subscript, Superscript, Preformatted, and Code), Bold, Italic, Add/Edit Link, Break Link, Horizontal Rule, Paste as Plain Text, Remove Styles, Special Characters, Undo, Redo, Help, Distraction Free Mode.

= Note on WordPress version Support =
Due to frequent changes to the block editor, features are only guaranteed for the latest version of WordPress.

== Frequently Asked Questions ==

= Full List of Hidden Blocks =

**Hidden Core Blocks:**

- **Text & Media Blocks:** Audio, Code, Next Page, Preformatted, Shortcode, Spacer, Table, Verse, Video
- **Widget Blocks:** Archives, Calendar, Categories, Latest Comments, RSS, Search, Tag Cloud
- **Query-Related Blocks**: Query, Archive Title (Query Title), Post Title, Post Content, Post Date, Post Excerpt, Post Featured Image, Post Tags & Categories (Post Terms)
Page List
- **FSE Blocks:** Login/Out, Page List, Site Logo, Site Tagline, Site Title

**Hidden Core Embeds:**

- Amazon Kindle, Animoto, Cloudup, Crowd Signal, Daily Motion, Hulu, Mixcloud, Polldaddy, Reverbnation, Smugmug, Speaker, VideoPress, and WordPress.tv

**Hidden Jetpack Blocks:**

- Markdown, Star Rating, Repeat Visitor, OpenTable, Revue, Eventbrite Tickets, GIF, Calendly, and WhatsApp Button

= Plugin Filters =

The plugin provides [numerous filters](https://github.com/mrwweb/mrw-simplified-editor-wordpress/wiki/Filter-Reference) that allow developers to hide or unhide additional blocks, block styles, or editor settings.

= Code Examples for Plugin Filters =

Visit the GitHub wiki for [examples of filters](https://github.com/mrwweb/mrw-simplified-editor-wordpress/wiki/Filter-Code-Examples) to show/hide a block, block style, or editor setting.

== Screenshots ==

1. The Block Editor simplified, here with no colors or drop caps for the Paragraph block.

2. The "Classic" block of the WordPress block editor also reflects the impact of this plugin in the Classic Editor.

== Changelog ==

= 2.5.0 (August 16, 2021) =
* tl;dr - WordPress 5.8 support and fixes, more hidden blocks by default, new filters to quickly unhide categories of hidden blocks
* [Fix] Use updated `block_editor_settings_all` filter instead of deprecated `block_editor_settings`. Support for old filter will be removed in a future version
* [New] Hide Shortcode block since shortcodes work in a Paragraph block
* [New] Hide Archives, Categories, and Latest Comments widget blocks by default after almost never using these
* [New] Hide all new Full Site Editing/FSE and Query-related blocks (e.g. Query Loop, Post Title, Site Logo, etc.)
* [New] Add new filters `mrw_hidden_core_blocks`, `mrw_hidden_widget_blocks`, `mrw_hidden_query_blocks`, and `mrw_hidden_post_blocks` that can be used to unhide entire group of related blocks with `__return_empty_array()`.
* [Fix] Re-hide `drop-cap` after change in WordPress settings array.

= 2.4.0 (January 7, 2021) =
* [Fix] Hide Embeds which were previously hidden. Refactoring of embeds in WordPress 5.6 broke the previous way of hiding them
* [Dev] Introduce new `mrw_hidden_embeds` filter. Embeds are no long hidden via the `mrw_hidden_blocks`.
* [Dev] Improve consistency of how filters are applied

= 2.3.0 (January 3, 2021) =
* WordPress 5.6 support confirmed
* [New] Hide Jetpack Blocks: Markdown, Star Rating, Repeat Visitor, OpenTable, Revue, Eventbrite Tickets, GIF, Calendly, and WhatsApp Button. Adds `mrw_jetpack_hidden_blocks` filter, allowing developers to easily unhide these blocks while also making it easier to hide other Jetpack blocks!
* [Fix] (!!!) Hide Dropcap setting in Editor ([big props](https://github.com/mrwweb/mrw-simplified-editor-wordpress/issues/15) to @xemlock and @joppuyo on Github)
* [Fix] Resolve notice from Block Editor Colors plugin when using a theme without a custom color palette.
* [Fix] Only add body classes that hide editor settings on the Block Editor screen
* [Dev] **Deprecated Filters (Sorry for doing this again, last time I foresee):** Replace "disabled" with "hidden" and "style variations" with "block styles" for improved clarity.
	* `mrw_disabled_blocks` ➡ `mrw_hidden_blocks`
	* `mrw_disabled_style_variations` ➡ `mrw_hidden_block_styles`
	* `mrw_disabled_block_editor_settings` ➡ `mrw_hidden_block_editor_settings`
* [Docs] - Moved Filter references and code examples to [GitHub wiki](https://github.com/mrwweb/mrw-simplified-editor-wordpress/wiki/MRW-Simplified-Editor-Documentation)

= Full Changelog =
* [Changelog on Github](https://github.com/mrwweb/mrw-simplified-editor-wordpress/blob/master/changelog.txt)

== Upgrade Notice ==
= 2.5.0 =
* WordPress 5.8 support and fixes, more hidden blocks by default, new filters to quickly unhide categories of hidden blocks