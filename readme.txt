=== MRW Simplified Editor ===
Contributors: mrwweb
Tags: Block Editor, Gutenberg, TinyMCE, Editor Styles, Editor
Requires at least: 4.1
Requires PHP: 5.6.20
Tested up to: 5.6
Stable tag: 2.3.0
Donate link: https://www.paypal.me/rootwiley
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Focus editors on making great content and letting their themes make it beautiful by removing block editor features.

== Description ==

Help your CMS editors create semantic content and style it with the theme for consistent formatting and portable content. This plugin removes blocks and other styling options to help editors focus.

> I built this plugin for use on client sites. I hopes you'll find it useful! **This is an opinionated plugin.** Read an in-depth reasoning behind the decisions made by this plugin in the post ["A WordPress Formatting Manifesto."](http://mrwweb.com/wordpress-formatting-manifesto/)

[Contribute on Github.](https://github.com/mrwweb/mrw-simplified-editor-wordpress/)

= Block Editor Features =

This plugin greatly simplifies the block editor by **hiding** all of the following features. Filters are provided for developers to adjust what is hidden (including making it easier to hide blocks).

- **Infrequently Used Core Blocks:** Verse, Table, Audio, Video, Code, More, Nextpage, Spacer, *and more*. See [FAQ for full list of hidden blocks](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/#faq).
- **Block Styles and the "Default style" feature**
- **Block Editor Settings:** Drop Cap, Heading 1, Heading 5, Heading 6, image percentage and pixel sizing, font sizing by pixel, open links in new tabs (mostly hidden)
- **Default Color & gradient settings** (Custom theme palettes/settings are never hidden)
- **Block Patterns (WP 5.5+)**
- **Block Directory (WP 5.5+)**
- **Infrequently Used Jetpack Blocks** - See [FAQ for full list of hidden blocks](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/#faq).
- **"Upload" and "Insert from URL" image options** to encourage use of Media Library

The plugin also improves the editor by:

- **Increase prominence of contrast errors**
- **Styles "Save draft" as a button**

= Classic Editor / Classic Block Features =

Reduce editor to a single row of buttons: "Styleselect" (Headings 2-4 and Blockquote as well as Strikethrough, Subscript, Superscript, Preformatted, and Code), Bold, Italic, Add/Edit Link, Break Link, Horizontal Rule (added 1.2.0), Paste as Plain Text, Remove Styles, Special Characters, Undo, Redo, Help, Distraction Free Mode.

== Frequently Asked Questions ==

= Full List of Hidden Blocks =

**Hidden Core Blocks:** Verse, Table, Preformatted, Code, More, Nextpage, Spacer, Calendar, Tag Cloud, Search, RSS, Audio, Video, Archive

**Hidden Core Embeds:** Amazon Kindle, Animoto, Cloudup, Crowd Signal, Daily Motion, Hulu, Mixcloud, Polldaddy, Reverbnation, Smugmug, Speaker, VideoPress, and WordPress.tv

**Hidden Jetpack Blocks:** Markdown, Star Rating, Repeat Visitor, OpenTable, Revue, Eventbrite Tickets, GIF, Calendly, and WhatsApp Button

= Plugin Filters =

The plugin provides [numerous filters](https://github.com/mrwweb/mrw-simplified-editor-wordpress/wiki/Filter-Reference) that allow developers to hide or unhide additional blocks, block styles, or editor settings.

= Code Examples for Plugin Filters =

Visit the GitHub wiki for [examples of filters](https://github.com/mrwweb/mrw-simplified-editor-wordpress/wiki/Filter-Code-Examples) to show/hide a block, block style, or editor setting.

== Screenshots ==

1. The Block Editor simplified, here with no colors or drop caps for the Paragraph block.

2. The "Classic" block of the WordPress 5.0 block editor reflects the impact of this plugin.

== Changelog ==

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