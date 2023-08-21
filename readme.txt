=== MRW Simplified Editor ===
Contributors: mrwweb
Tags: Block Editor, Blocks, Gutenberg, Editor Styles, Editor
Requires at least: 6.0
Requires PHP: 5.6.20
Tested up to: 6.3
Stable tag: 2.11.1
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

- **Infrequently Used Core Blocks** such as Verse, Table, Audio, Video, etc., and all Query- and Site-related blocks. See FAQ for [full list of hidden blocks](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/#faq).
- **All Core Block Styles and the "Default style" feature**
- **Some Block Editor Settings:** Drop Cap, Heading 1, Heading 5, Heading 6, image percentage and pixel sizing, font sizing by pixel, open links in new tabs (mostly hidden), duotone, text styles like line-height and letter spacing, etc.
- **Default Color & gradient settings** (Custom theme palettes/settings are never hidden)
- **Core Block Patterns (WP 5.5+)**
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
- **Query-Related Blocks**: Query, Archive Title (Query Title), Post Title, Post Content, Post Author, Post Date, Post Excerpt, Post Featured Image, Post Tags & Categories (Post Terms), Term Description
Page List
- **FSE Blocks:** Login/Out, Page List, Site Logo, Site Tagline, Site Title, Navigation, Next Post, Previous Post, Post Comments, Comments Query, Read More, Avatar, Post Author Biography, Post Comments Form

**Hidden Core Embeds:**

- Amazon Kindle, Animoto, Cloudup, Crowd Signal, Daily Motion, Hulu, Mixcloud, Polldaddy, Reverbnation, Smugmug, Speaker, VideoPress, Wolfram Cloud, and WordPress.tv

**Hidden Jetpack Blocks:**

- Markdown, Star Rating, Repeat Visitor, OpenTable, Revue, Eventbrite Tickets, GIF, Calendly, and WhatsApp Button

= Plugin Filters =

The plugin provides [numerous filters](https://github.com/mrwweb/mrw-simplified-editor-wordpress/wiki/Filter-Reference) that allow developers to hide or unhide additional blocks, block styles, or editor settings.

= Code Examples for Plugin Filters =

Visit the GitHub wiki for [examples of filters](https://github.com/mrwweb/mrw-simplified-editor-wordpress/wiki/Filter-Code-Examples) to show/hide a block, block style, or editor setting.

== Screenshots ==

1. The Block Editor simplified, here with no colors or drop caps for the Paragraph block.

== Changelog ==
= 2.11.0 (August 21, 2023) =
- **Requires WordPress 6.0**. Legacy code removed
- [New] Show all Post- and Query-related blocks in the Site Editor
- [New] Hide Classic (aka freeform), Details, Footnotes, Comments, and Post Author blocks
- [New] Hide Group / Cover width settings and Group child blocks Justification settings and min-height setting (does not impact Cover min-height setting). Can be shown with `mrw_hidden_block_editor_settings` filter.
- [Dev] The `mrw_hidden_blocks` and all `mrw_hidden_*_blocks` filters now support a second `$context` parameter that contains the current screen's ID so you can target the block editor (`post`), site editor (`site-editor`), or widget editor (`widgets`).
- [New] New Jetpack blocks hidden including AI Assistance, all form blocks, and payment-related blocks
- [Fix] WordPress 6.3 compatibility (re-hide media upload buttons, default gradients, comments block)
- [Fix] "getBlockVariations(…) is undefined warning in Widget and Site Editors
- [Meta] Removed "Formerly MRW Web Design Simple TinyMCE" now that the block editor is 4.5 years old!
- 2.11.1: Change `layout-width-height` value in the `mrw_hidden_block_editor_settings` filter to be accurate `layout-width`.

= 2.10.0 (October 15, 2022) =
- Tested up to WordPress 6.1
- Hide new Text Decoration settings by default (enable via `text-decoration` in  `mrw_hidden_block_editor_settings`)
- Hide image duotone setting (enable via `duotone` in `mrw_hidden_block_editor_settings`)

= 2.9.0 (May 27, 2022) =
- WordPress 6.0 compatibility fixes: hide new blocks, fix regressions
- [New] Hide the default color palette which was re-added by default in WP 5.8. Can be shown by removing `default-color-palette` value from `mrw_hidden_block_editor_settings` filter
- [New] Hide Avatar, Read More, Comments Query Loop, Post Comments Form, and Post Author Biography blocks
- [Fix] Hide Border Radius in WP 5.9 and 6.0
- [Fix] Prominent contrast error changes in WP 6.0

= 2.8.0 (February 21, 2022) =
* [New] Hide many new default block controls added in WordPress 5.9. All options can be enabled with the [mrw_hidden_block_editor_settings filter](https://github.com/mrwweb/mrw-simplified-editor-wordpress/wiki/Filter-Reference).
	* Text Formatting: line-height, font-weight, letter-spacing, and text-transform
	* Spacing: gap, margin, padding
	* Borders: General, pull-quote
* [Remove] Remove support for hiding paragraph block dropcap setting in WordPress 5.6 and earlier
* [Remove] Remove support for all old versions of `mrw_*` filters using the terms "blacklist" and "disabled"

= 2.7.0 (February 4, 2022) =
* [New] Hide new blocks added in WordPress 5.9: Navigation, Post Pagination, Post Author, Post Comments, Term Description, Wolfram Cloud Embed
* [Dev] Improve inline documentation of new `mrw_hidden_*_blocks` filters added in Simplified Editor 2.5.0
* [Preview] Version 2.8 will continue to hide new settings added in WordPress 5.9: default border controls on pullquote, new typopgraphy settings (e.g. line height, letter spacing), and default padding controls on Group, Cover, and Columns unless themes explicitly opt-in.

= Full Changelog =
* [Changelog on Github](https://github.com/mrwweb/mrw-simplified-editor-wordpress/blob/master/changelog.txt)

== Upgrade Notice ==
= 2.11.0 =
* WP 6.3 Compatibility + Relevant blocks visible in the style editor.