=== MRW Simplified Editor ===
Contributors: mrwweb
Tags: Block Editor, Blocks, Gutenberg, Editor Styles, Editor
Requires at least: 6.0
Requires PHP: 5.6.20
Tested up to: 6.5
Stable tag: 2.12.1
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
- **Some Block Editor Settings:** Drop Cap, Heading 1, Heading 5, Heading 6, font sizing by pixel, open links in new tabs (mostly hidden), duotone, text styles like line-height and letter spacing, inline formats including Highlight and Inline Image, etc.
- **Default color, gradient, and duotone settings** (Custom theme palettes/settings are never hidden)
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

- **Text & Media Blocks:** Audio, Classic/Freeform, Code, Details, Footnotes, Next Page, Preformatted, Shortcode, Spacer, Table, Verse, Video
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
= 2.12.1 (November 30, 2023) =
- Fix ability to unhide newly-hidden inline formats (Footnote, highlight, inline image, inline code, and keyboard)

= 2.12.0 (November 3, 2023) =
- WordPress 6.4 compatibility
- Fix error that hid custom theme duotone options
- Fully hide Footnotes inserter unless the block is unhidden via `mrw_hidden_blocks` filter
- Hide "Highlight", "Inline Image", "Inline Code", and "Keyboard" toolbar inline formats. Can be re-enabled via `mrw_hidden_block_editor_settings` filter.
- Hide "Upload" option in "Replace" media menu
- Remove background color options from Cover block placeholder
- Hide new Background Image option on Group block
- Hide new "Text Orientation" / writing mode option

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

= Full Changelog =
* [Changelog on Github](https://github.com/mrwweb/mrw-simplified-editor-wordpress/blob/master/changelog.txt)

== Upgrade Notice ==
= 2.12.1 =
* v2.12.0 - WP 6.4 Compatibility + hide various inline formats and placeholder options