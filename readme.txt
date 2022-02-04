=== MRW Simplified Editor ===
Contributors: mrwweb
Tags: Block Editor, Blocks, Gutenberg, Editor Styles, Editor
Requires at least: 5.2
Requires PHP: 5.6.20
Tested up to: 5.9
Stable tag: 2.7.0
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
- **Some Block Editor Settings:** Drop Cap, Heading 1, Heading 5, Heading 6, image percentage and pixel sizing, font sizing by pixel, open links in new tabs (mostly hidden)
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
- **FSE Blocks:** Login/Out, Page List, Site Logo, Site Tagline, Site Title, Navigation, Next Post, Previous Post, Post Comments

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

2. The "Classic" block of the WordPress block editor also reflects the impact of this plugin in the Classic Editor.

== Changelog ==

= 2.7.0 (February 4, 2022) =
* [New] Hide new blocks added in WordPress 5.9: Navigation, Post Pagination, Post Author, Post Comments, Term Description, Wolfram Cloud Embed
* [Dev] Improve inline documentation of new `mrw_hidden_*_blocks` filters added in Simplified Editor 2.5.0
* [Preview] Version 2.8 will continue to hide new settings added in WordPress 5.9: default border controls on pullquote, new typopgraphy settings (e.g. line height, letter spacing), and default padding controls on Group, Cover, and Columns unless themes explicitly opt-in.

= 2.6.1 (November 22, 2021) = 
* [Fix] Resolve fatal error on editor screen in WordPress versions before 5.8

= 2.6.0 (November 12, 2021) =
* [New] Hide Button block Border Radius setting by default. Show by removing `border-radius` from the array in the `mrw_hidden_block_editor_settings` filter.
* [Dev] Improve documentation of options that trigger hiding editor features with CSS in `block-editor.css`.
* [Dev] Use is_wp_compatible_version() for version comparison

= 2.5.0 (August 16, 2021) =
* tl;dr - WordPress 5.8 support and fixes, more hidden blocks by default, new filters to quickly unhide categories of hidden blocks
* [Fix] Use updated `block_editor_settings_all` filter instead of deprecated `block_editor_settings`. Support for old filter will be removed in a future version
* [New] Hide Shortcode block since shortcodes work in a Paragraph block
* [New] Hide Archives, Categories, and Latest Comments widget blocks by default after almost never using these
* [New] Hide all new Full Site Editing/FSE and Query-related blocks (e.g. Query Loop, Post Title, Site Logo, etc.)
* [New] Add new filters `mrw_hidden_core_blocks`, `mrw_hidden_widget_blocks`, `mrw_hidden_query_blocks`, and `mrw_hidden_post_blocks` that can be used to unhide entire group of related blocks with `__return_empty_array()`.
* [Fix] Re-hide `drop-cap` after change in WordPress settings array.

= Full Changelog =
* [Changelog on Github](https://github.com/mrwweb/mrw-simplified-editor-wordpress/blob/master/changelog.txt)

== Upgrade Notice ==
= 2.7.0 =
* Hide new blocks added in WordPress 5.9.