# Tajwar Tajim Portfolio

A native full-site-editing (FSE) WordPress theme for Tajwar Tajim's developer
portfolio — no page builder, no ACF, just block markup, two custom post
types, and a handful of purpose-built dynamic blocks.

Warm paper/monochrome editorial design system with a single terracotta
accent, self-hosted Archivo/Inter/JetBrains Mono type, dark/light toggle,
and a one-page scrolling layout with a real WordPress blog.

## Features

- **Full site editing** — every section of the front page is built from
  real Gutenberg blocks (Heading, Paragraph, List, Quote, Image, File,
  Buttons, Social Links) directly editable in the Site Editor, not locked
  behind Custom HTML.
- **Two native custom post types** — `project` (with a `project_category`
  taxonomy driving the Work section's filter tabs) and `testimonial`, each
  with hand-rolled meta boxes (no ACF).
- **Three custom dynamic blocks** — `project-grid`, `testimonials`, and
  `blog-preview`, server-rendered from live post data via `WP_Query`.
- **Dark/light theme toggle**, mobile nav, scrollspy, animated skill bars,
  a testimonial slider, and a project filter — all vanilla JS, no
  dependencies.
- **Working contact form** — AJAX submission via `admin-ajax.php` and
  `wp_mail()`, no forms plugin required.
- Self-hosted fonts (no Google Fonts network request), theme.json-driven
  color palette, and a CSS bridge so native blocks render pixel-identical
  to the design system.

## Requirements

- WordPress 6.7+
- PHP 8.0+
- Node.js + npm (only needed if you touch the custom blocks — see below)

## Installation

1. Copy this folder into `wp-content/themes/`.
2. Activate **Tajwar Tajim Portfolio** under Appearance → Themes.
3. Under Settings → Permalinks, resave to flush rewrite rules for the
   `project`/`testimonial` post types.

## Local development

Everything except the custom blocks is build-free — edit `templates/`,
`patterns/`, `inc/`, and `assets/css/style.css` directly, no compile step.

The three custom blocks under `src/blocks/` are built with
`@wordpress/scripts`:

```bash
npm install        # once, or after changing src/blocks/**
npm run build       # required after editing any src/blocks/**/*.js
npm run start        # watch mode while developing a block
```

## Structure

```
templates/front-page.html   # the whole one-page site, as real block markup
parts/, patterns/            # header/footer template parts
src/blocks/                  # project-grid, testimonials, blog-preview
inc/                          # CPTs, meta boxes, contact form handler
assets/                       # style.css, main.js, self-hosted fonts
theme.json                    # color palette, typography, layout
```

## Content model

- **Work** section → `project` CPT. Meta: `tj_github_url`, `tj_live_url`,
  `tj_tech_stack` (comma-separated), `tj_placeholder_class` (fallback
  gradient when no featured image is set). Taxonomy `project_category`
  terms (`shopify`, `webapp`, `wordpress`) must match the filter tabs.
- **Testimonials** section → `testimonial` CPT. Meta: `tj_client_location`,
  `tj_avatar_hue` (0–360).
- **Blog** section → the 3 latest real WordPress posts.
- Everything else (contact info, socials, footer copy, hero/about/services
  text) is directly editable block content in the Site Editor — no
  settings page, no theme-mods.

## License

GPL-2.0-or-later
