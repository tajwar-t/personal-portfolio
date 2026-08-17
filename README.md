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
- **Five custom dynamic blocks** — `project-grid` (a full "Projects
  Section" with editable subtitle/title and a post-type source picker),
  `testimonials`, `blog-preview` — all server-rendered from live post
  data via `WP_Query`, no Custom HTML block involved — plus `site-header`
  and `site-footer`, which turn the entire header/footer chrome into two
  standalone, Inspector-configurable blocks (see "Real WordPress Menus"
  below).
- **Dark/light theme toggle**, mobile nav, scrollspy, animated skill bars,
  a testimonial slider, and a project filter — all vanilla JS, no
  dependencies.
- **Working contact form** — AJAX submission via `admin-ajax.php` and
  `wp_mail()`, no forms plugin required.
- Self-hosted fonts (no Google Fonts network request), theme.json-driven
  color palette, and a CSS bridge so native blocks render pixel-identical
  to the design system.
- **Real site branding** — a genuine WordPress Custom Logo (Appearance →
  Site Identity) renders inside the theme's existing `.logo` markup via the
  `tj_logo()` helper (shared by header and footer, falls back to the
  original text/mark logo if no logo is set), and a real Site Icon drives
  the browser-tab favicon — both swappable from the Media Library, no
  hardcoded image paths.
- **Real WordPress Menus, picked per block** — `tajwar-tajim/site-header`
  and `tajwar-tajim/site-footer` each render their nav(s) via
  `wp_nav_menu()`. Every location (`primary`, `footer-sitemap`,
  `footer-elsewhere`) is registered with `register_nav_menus()` and
  editable under Appearance → Menus as usual, but each block also exposes
  a "Menu" dropdown in its Inspector (populated live from `/wp/v2/menus`)
  so a specific menu can be assigned directly on the block, overriding the
  location default — useful if the header/footer block is ever reused
  elsewhere. A `nav_menu_link_attributes` filter automatically adds
  `class="nav-link"` and derives `data-section` from each primary-menu
  link's URL fragment, so the scrollspy keeps working with no extra setup.
  Every location falls back to the original hardcoded links if no menu is
  assigned yet.

## Requirements

- WordPress 6.7+
- PHP 8.0+
- Nothing else — no Node, no npm, no build step, ever.

## Installation

1. Copy this folder into `wp-content/themes/`.
2. Activate **Tajwar Tajim Portfolio** under Appearance → Themes.
3. Under Settings → Permalinks, resave to flush rewrite rules for the
   `project`/`testimonial` post types.

## Local development

The entire theme is build-free — edit `templates/`, `parts/`, `inc/`,
`assets/css/style.css`, and `blocks/` directly; changes take effect on the
next page load, no compile step.

The five custom blocks under `blocks/` register their editor UI as plain
vanilla JS (`blocks/<name>/edit.js`) written directly against WordPress's
own global scripts (`wp.blocks`, `wp.element`, `wp.blockEditor`,
`wp.serverSideRender`) instead of `@wordpress/scripts`/webpack — no JSX,
no bundling, no `node_modules`. `functions.php` registers each block's
script with its dependencies spelled out explicitly.

## Structure

```
templates/front-page.html   # the whole one-page site, as real block markup
parts/                        # header.html/footer.html — each just a single
                               #   wp:tajwar-tajim/site-header|site-footer block
blocks/                       # project-grid, testimonials, blog-preview,
                               #   site-header, site-footer
                               #   (block.json + plain-JS edit.js + render.php)
inc/                          # CPTs, meta boxes, contact form handler
assets/                       # style.css, main.js, self-hosted fonts
theme.json                    # color palette, typography, layout
```

## Content model

- **Work** section → the `tajwar-tajim/project-grid` block, fully
  configurable from its Inspector panel: `subtitle` (eyebrow), `title`
  (heading), and `postType` (which post type's published entries drive the
  grid — defaults to `project`, populated live from `/wp/v2/types`). The
  category filter tabs are generated dynamically from the `project_category`
  taxonomy's terms whenever the chosen post type supports it; they're
  omitted otherwise. `project` CPT meta: `tj_github_url`, `tj_live_url`,
  `tj_tech_stack` (comma-separated), `tj_placeholder_class` (fallback
  gradient when no featured image is set). Taxonomy `project_category`
  term slugs (`shopify`, `webapp`, `wordpress`) must match the JS filter's
  `data-filter` values — only the display names are free to edit.
- **Testimonials** section → `testimonial` CPT. Meta: `tj_client_location`,
  `tj_avatar_hue` (0–360).
- **Blog** section → the 3 latest real WordPress posts.
- **Header** → the `tajwar-tajim/site-header` block. Inspector attributes:
  `menuId` (which WP Menu drives the nav; `0` = fall back to the `primary`
  theme location), `ctaText`/`ctaUrl` (the "Let's Talk" button). Theme
  toggle, mobile menu button, cursor-glow, and the floating identity pill
  stay as plain markup inside the block's `render.php` — pure JS-driven
  chrome with no "content" to expose as an attribute.
- **Footer** → the `tajwar-tajim/site-footer` block. Inspector attributes:
  `sitemapMenuId`/`elsewhereMenuId` (which WP Menu drives each column;
  `0` = fall back to the `footer-sitemap`/`footer-elsewhere` theme
  locations), `tagline`, `newsletterHeading`, `newsletterText`,
  `copyrightText`, `creditText`. The newsletter `<form>` itself stays raw
  (disabled, JS-free utility markup).
- Everything else (contact info, socials, hero/about/services text) is
  directly editable block content in the Site Editor — no settings page,
  no theme-mods.

## License

GPL-2.0-or-later
