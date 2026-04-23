# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Moodle activity module (`mod_exeweb`) for creating and editing web sites with eXeLearning. Teachers can author educational content via three modes: local upload, eXeLearning Online (remote editor), or an embedded static editor.

**Component**: `mod_exeweb`
**Moodle compatibility**: 4.2+
**License**: GNU GPL v3+

## Common Commands

```bash
# Development environment (Docker-based)
make up              # Start containers interactively
make upd             # Start containers in background
make down            # Stop containers
make shell           # Shell into Moodle container
make clean           # Stop containers + remove volumes

# PHP dependencies
make install-deps    # composer install

# Code quality
make lint            # PHP CodeSniffer (Moodle standard)
make fix             # Auto-fix CodeSniffer violations
make phpmd           # PHP Mess Detector

# Testing
make test            # PHPUnit tests
make behat           # Behat BDD tests

# Embedded editor
make build-editor    # Fetch exelearning source + build to dist/static/
make clean-editor    # Remove built editor artifacts

# Packaging
make package RELEASE=1.2.3   # Create distributable ZIP
```

Lint/test/phpmd/behat all delegate to `composer` scripts defined in `composer.json`. Run `make install-deps` first.

## Architecture

### Three Content Origins

| Constant | Mode | How it works |
|----------|------|-------------|
| `EXEWEB_ORIGIN_LOCAL` | Upload | ZIP package uploaded via form |
| `EXEWEB_ORIGIN_EXEONLINE` | Online | Redirects to remote eXeLearning; JWT-authenticated callbacks (`get_ode.php`/`set_ode.php`) sync the package |
| `EXEWEB_ORIGIN_EMBEDDED` | Embedded | Static HTML5 editor in iframe from `dist/static/`; bridge script + postMessage for Moodle ↔ editor communication |

### Key File Groups

- **Core Moodle hooks**: `lib.php`, `locallib.php` (display/rendering), `mod_form.php` (activity form), `settings.php` (admin config)
- **Editor integration**: `editor/index.php` (bootstrap), `editor/static.php` (asset server), `editor/save.php` (AJAX save)
- **Online editor**: `get_ode.php`, `set_ode.php`, `classes/exeonline/` (redirector, JWT token manager)
- **Frontend JS** (AMD): `amd/src/editor_modal.js` (fullscreen overlay), `amd/src/admin_embedded_editor.js` (settings page AJAX + progress), `amd/src/moodle_exe_bridge.js` (runs inside editor iframe, raw — not AMD)
- **Package handling**: `classes/exeweb_package.php` (validation, extraction)
- **Database**: `db/install.xml` (schema), `db/access.php` (capabilities), `db/upgrade.php` (migrations)
- **Backup/restore**: `backup/moodle2/`

### Embedded Editor: Hybrid Source Model

The embedded editor uses a **hybrid source model** with two possible locations:

1. **Bundled**: `dist/static/` inside the plugin (from release ZIP or `make build-editor`)
2. **Admin-installed**: `$CFG->dataroot/mod_exeweb/embedded_editor/` (downloaded from GitHub Releases via the admin management page)

**Source precedence**: moodledata (admin-installed) → bundled → not available

Key classes:
- `classes/local/embedded_editor_source_resolver.php` — single source of truth for which editor source is active
- `classes/local/embedded_editor_installer.php` — download/install pipeline from GitHub Releases

The resolver is used by `lib.php` helper functions (`exeweb_get_embedded_editor_local_static_dir()`, `exeweb_embedded_editor_uses_local_assets()`, `exeweb_get_embedded_editor_index_source()`), which in turn are used by `editor/static.php` (asset proxy) and `editor/index.php` (bootstrap). This makes the source transparent to the rest of the codebase.

**Admin management (inline settings widget)**: Editor management is integrated directly into the plugin's admin settings page via a custom `admin_setting` subclass — no separate page. Actions (install/update/repair/uninstall) use AJAX external functions; a JS AMD module handles progress display and timeout resilience.

Key files:
- `classes/external/manage_embedded_editor.php` — AJAX external functions (`execute_action` + `get_status`), modern `\core_external\external_api` pattern (Moodle 4.2+, PSR-4 namespaced `\mod_exeweb\external\manage_embedded_editor`)
- `classes/admin/admin_setting_embeddededitor.php` — Custom `admin_setting` subclass (PSR-4 namespaced `\mod_exeweb\admin\admin_setting_embeddededitor`), renders inline widget in settings page. `get_setting()`/`write_setting()` return empty string (display-only, no config stored).
- `templates/admin_embedded_editor.mustache` — Inline widget template (status card, action buttons, progress bar, result area)
- `amd/src/admin_embedded_editor.js` — AMD module: calls `get_status(checklatest=true)` on page load (async GitHub API check), handles action AJAX calls with 120s JS timeout, falls back to status polling every 10s using `CONFIG_INSTALLING` lock, polling capped at 5 minutes

**Design decisions & rationale**:
- **Why AJAX instead of synchronous POST**: Keeps user on settings page; the old `manage_embedded_editor.php` navigated away. POST with `NO_OUTPUT_BUFFERING` progress bar was considered but rejected because it still navigates away.
- **Why indeterminate progress bar**: The installer doesn't expose byte-level progress. Operation typically takes 10-30s. Animated Bootstrap stripes are sufficient.
- **Why 120s JS timeout + polling**: Reverse proxies (nginx default 60s, Apache 60-120s) may kill long AJAX requests for ~50MB ZIP downloads. The existing `CONFIG_INSTALLING` lock (300s TTL) serves as a "still running" signal. JS polls `get_status` after timeout to distinguish "still running" / "completed" / "failed". Stale lock (>300s) is detected and reported.
- **Why GitHub API only from JS**: `discover_latest_version()` hits GitHub API (60 req/hr unauthenticated). Calling it on PHP render would fire on every settings page visit. JS calls it once async after page load.
- **Why modern \core_external\external_api**: Plugin minimum is Moodle 4.2+ (`version.php`). Uses PSR-4 namespaced classes at `classes/external/`. The legacy `classes/external.php` (Frankenstyle) remains for existing external functions but new code uses the modern pattern.
- **Both capabilities required**: `moodle/site:config` AND `mod/exeweb:manageembeddededitor`, matching the original `admin_externalpage` registration.

### Embedded Editor Build (Development)

`dist/static/` is **not committed**. It's built from the `exelearning/exelearning` repo:
- `make build-editor` shallow-clones the source (configured via `.env` or env vars: `EXELEARNING_EDITOR_REPO_URL`, `EXELEARNING_EDITOR_REF`, `EXELEARNING_EDITOR_REF_TYPE`)
- Builds with Bun (`bun install && bun run build:static`)
- Copies output to `dist/static/`

### File Storage

Uses Moodle's file API — packages stored in `mod_exeweb/package` filearea, expanded content in `mod_exeweb/content`. Revision number in URLs for cache busting. Never serve files directly from disk.

### Capabilities

`mod/exeweb:view`, `mod/exeweb:addinstance`, `mod/exeweb:manageembeddededitor`

## Code Standards

- **PHP**: Moodle coding standard enforced via PHP CodeSniffer (`make lint`/`make fix`)
- **Strings**: All UI strings in `lang/{ca,en,es,eu,gl}/exeweb.php` — use `get_string('key', 'mod_exeweb')`
- **JS**: AMD modules in `amd/src/`, compiled to `amd/build/` (exception: `moodle_exe_bridge.js` loads raw in editor iframe)

## Packaging & Release

- `make package RELEASE=X.Y.Z` updates `version.php`, creates ZIP excluding files in `.distignore`, then restores dev values
- GitHub Actions `release.yml` triggers on git tags: fetches editor, builds, packages, uploads to GitHub Release
- `check-editor-releases.yml` runs daily to auto-release when new editor versions appear
