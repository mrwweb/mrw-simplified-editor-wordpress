=== MRW Simplified Editor ===
Contributors: mrwweb
Tags: Block Editor, Blocks, Gutenberg, Editor Styles, Editor
Requires at least: 6.5
Requires PHP: 5.6.20
Tested up to: 7.0
Stable tag: 2.15.2
Donate link: https://www.paypal.me/rootwiley
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Focus editors on making great content and letting their themes make it beautiful by removing block editor features.

== Description ==

Help your site's editors create semantic content and style it with the theme for consistent formatting and portable content. This plugin removes blocks and other styling options to help editors focus.

> I built this plugin for use on client sites. I hope you'll find it useful! **This is an opinionated plugin.** Read an in-depth reasoning behind the decisions made by this plugin in the post ["A WordPress Formatting Manifesto."](http://mrwweb.com/wordpress-formatting-manifesto/) If you find it compelling, then you'll probably like this plugin!

[Contribute on Github.](https://github.com/mrwweb/mrw-simplified-editor-wordpress/)

= Block Editor Features =

This plugin greatly simplifies the block editor by **hiding** a significant number of blocks, block settings, and other editor-facing features.

The plugin is regularly updated following major WordPress version updates. Filters are provided for developers to adjust what is hidden (including making it easier to hide additional blocks).

- **Infrequently Used Core Blocks** such as Verse, Table, Audio, Video, etc., and all Query- and Site-related blocks when using the Post editor. See FAQ for [full list of hidden blocks](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/#faq).
- **All Core Block Styles and the "Default style" feature**
- **Some Block Editor Settings:** Drop Cap, Text-indent, Heading 1, Heading 5, Heading 6, font sizing by pixel, open links in new tabs (mostly hidden), duotone, text styles like line-height and letter spacing, inline formats including Highlight and Inline Image, etc.
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

- **Text & Media Blocks:** Accordion, Audio, Classic/Freeform, Code, Details, Icon, Footnotes, Next Page, Preformatted, Shortcode, Spacer, Table, Verse, Video
- **Widget Blocks:** Archives, Calendar, Categories, Latest Comments, RSS, Search, Tag Cloud
- **Query-Related Blocks**: Query, Archive Title (Query Title), Post Title, Post Content, Post Author, Post Date, Post Excerpt, Post Featured Image, Post Tags & Categories (Post Terms), Term Description
Page List
- **FSE Blocks:**  Breadcrumbs, Login/Out, Page List, Site Logo, Site Tagline, Site Title, Navigation, Next Post, Previous Post, Post Comments, Comments Query, Read More, Avatar, Post Author Biography, Post Comments Form

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
= 2.15.2 (June 25, 2026) =

* Fix fatal error related to textIndent setting on some sites

= 2.15.1 (May 25, 2026) =

* Fix fatal error for sites using Jetpack blocks

= 2.15.0 (May 22, 2026) =

* WordPress 7.0 updates
    * Hide New Blocks: Icon, Breadcrumbs (hidden only in post editor) (enable everywhere with the `mrw_hidden_blocks` filter)
    * Hide per-block Custom CSS (enable with `custom-css` value in `mrw_hidden_block_editor_settings`)
    * Hide text indent block setting (enable with `text-indent` value in `mrw_hidden_block_editor_settings`)
    * Fix hiding Fit Text settings for Paragraph and Heading blocks with new settings approach (Editorializing: The way it should have been all along!)
    * Hide new Heading variations for levels 1, 5, 6 to match previous behavior
    * Don't display heading variations in the block inserters. (Editors will continue to insert Heading block and then change level from 2, if necessary.) Show block variations with `heading-variations` in `mrw_hidden_block_editor_settings`.
    * Hide Appearance > Font Library menu item. Show with `font-library` in `mrw_hidden_block_editor_settings`.
    * Fix Save Draft styling to remain looking like a button
    * Fix hiding "Insert from URL" button in image block. (Currently not configurable due to editor iframe)
* Code and comment quality improvements including strict comparison in all filters that use `in_array()` such as `mrw_hidden_blocks`.

= 2.14.0 (November 18, 2025)

- New minimum supported version: WordPress 6.5
- [WordPress 6.9] Hide new blocks: Accordion, Math, Term Query, Time to Read, Word Count. Use `mrw_hidden_blocks` to show.
- [WordPress 6.9] Hide "Fit Text" block variations in WordPres 6.9: Use `mrw_hidden_block_editor_settings` filter to show.
- Hide lesser-used social links like 500px, Amazon, last.fm, Pocket (RIP), etc. Use `mrw_hidden_social_links` to show hidden links or hide additional ones.
- Hide Template Part embeds in the post editor context since they literally can't be embedded. Hopefully this gets [solved in WordPress](https://github.com/WordPress/gutenberg/issues/67797) eventually.
- Update hidden buttons in image placeholders to show "Use Featured Image" option for Media & Text block and display Media Library in the primary button style.
- Hide "text over image" toolbar button when the Cover block is hidden
- Hide Goodreads and Nextdoor blocks in Jetpack
- Resolve warning about correctly loading block styles in editor to prepare for iframed editor in WP 7.0.
- Dev: Resolve Plugin Check warnings.
- Dev: Introduce namespaces to reduce risk of naming collisions.
- Dev: Improve how block variations are unregistered.
- Dev: Update deprecated properties in `blueprint.json`
- Dev: Miscellaneous code cleanup
- Fix incorrect license listed in `readme.txt` to match link and plugin header (GPL2 and above)

= 2.13.0 (March 12, 2024, Released on a train somewhere between Seattle and Portland 🚆) =
- [New] Hide new default box-shadows design feature. Should not interfere with theme-defined shadows. Enable default shadows via `mrw_hidden_block_editor_settings` filter.
- [Fix] Hide Headings 1, 5, and 6 in WordPress 6.5+
- Add new `blueprint.json` file to support plugin repository playground feature

= Full Changelog =
* [Changelog on Github](https://github.com/mrwweb/mrw-simplified-editor-wordpress/blob/master/changelog.txt)

== Upgrade Notice ==
= 2.15.0 =
* WordPress 7.0 compatiblity: Hide new blocks, Font Library, per-block CSS, and more!