# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This Plugin Does

MRW Simplified Editor is a WordPress plugin that streamlines the block editor (Gutenberg) and classic editor (TinyMCE) to help content editors focus on semantic content rather than visual styling. It hides blocks, block styles, and editor settings that lead to inconsistent formatting. All hidden items can be re-enabled via PHP filters.

## Code Architecture

The plugin has no build step — all PHP, JS, and CSS are hand-authored and loaded directly.

### Entry Point

`mrwweb-simple-tinymce.php` — defines `MRW_SIMPLIFIED_EDITOR_VERSION` and requires the two includes.

### PHP (`inc/`)

Both files use the `MRW\SimplifiedEditor` namespace.

- `inc/block-editor.php` — All Gutenberg modifications. Key functions:
  - `hidden_blocks()` — returns filterable list of blocks hidden from the inserter (blocks are hidden, not unregistered, to avoid editor crashes on existing content)
  - `hidden_embeds()`, `hidden_social_links()`, `hidden_block_styles()`, `hidden_block_editor_settings()` — each returns a filterable array used by both PHP and JS
  - `block_editor_settings()` — hooked to `block_editor_settings_all`, modifies `__experimentalFeatures` directly
  - `block_editor_js_config()` — collects all hidden-item arrays and localizes them as `mrwEditorOptions` for JS
  - `block_editor_assets()` — enqueues `css/block-editor.css` and `js/block-editor.js` on `enqueue_block_editor_assets`
  - `block_editor_settings_admin_classes()` — adds `mrw-block-editor-no-{setting}` body classes for CSS targeting

- `inc/classic-editor.php` — TinyMCE modifications via `mce_buttons` and `tiny_mce_before_init` filters. Reduces toolbar to a single row with a curated `styleselect` menu.

### JavaScript (`js/block-editor.js`)

Plain JS (no build), uses global `wp.*` APIs. Runs on `wp.domReady`. Reads `mrwEditorOptions` (localized by PHP) to:

- Hide blocks from the inserter via `blocks.registerBlockType` filter
- Unregister embed/social-link block variations
- Unregister block styles
- Unregister inline format types (highlight, inline-image, etc.)

### CSS (`css/`)

- `block-editor.css` — hides editor UI elements via the body classes added by PHP (e.g. `.mrw-block-editor-no-drop-cap`)
- `blocks.css` — styles block placeholders in the admin (e.g. media buttons)

## Filters / Extensibility

The plugin is filter-driven. Key filters (all in `MRW\SimplifiedEditor` namespace):

- `mrw_hidden_blocks` — full merged list; receives `$context` (screen ID: `post`, `site-editor`, `widgets`)
- `mrw_hidden_core_blocks`, `mrw_hidden_widget_blocks`, `mrw_hidden_query_blocks`, `mrw_hidden_site_blocks` — category-level sublists
- `mrw_hidden_embeds`, `mrw_hidden_social_links`
- `mrw_hidden_block_styles` — keyed array: `[ 'core/image' => ['default', 'rounded'] ]`
- `mrw_hidden_block_editor_settings` — string slugs like `'drop-cap'`, `'heading-1'`
- `mrw_jetpack_hidden_blocks`
- `mrw_block_editor_hide_color_palette`, `mrw_block_editor_hide_gradient_presets`
- `mrw_mce_text_style` — add items to the classic editor styleselect

## Linting

PHP linting uses PHP_CodeSniffer with the WordPress coding standards ruleset:

```bash
# Run from plugin root (requires phpcs + WordPress-Coding-Standards installed)
phpcs --standard=phpcs.xml.dist
phpcbf --standard=phpcs.xml.dist   # auto-fix
```

Key rules configured in `phpcs.xml.dist`:

- WordPress ruleset (Yoda conditions excluded)
- Text domain: `mrw-web-design-simple-tinymce`
- Global namespace prefix required: `mrw`
- PHP 8.2+ target (`testVersion="8.2-"`)
- Minimum supported WP version: 6.7

No JavaScript/CSS linting is configured in this repo.

## Deployment

Releases are deployed to WordPress.org via GitHub Actions (`.github/workflows/deploy.yml`) on any git tag push, using the 10up deploy action. The WordPress.org plugin slug is `mrw-web-design-simple-tinymce`.

Plugin version is set in two places — keep them in sync:

1. `mrwweb-simple-tinymce.php` — `Version:` header and `MRW_SIMPLIFIED_EDITOR_VERSION` constant
2. `readme.txt` — `Stable tag:` header

## Branch / Release Conventions

- `release` is the main/stable branch (used as PR base)
- Feature branches follow `issues/{number}-{description}` naming
- Tags trigger WordPress.org deployment
