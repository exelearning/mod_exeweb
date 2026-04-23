# CHANGELOG

## v4.0.0 – 2025-04-28

- Version jump to 4.0.0 to align numbering with eXeLearning for consistency across related projects.
- Introduce fully integrated embedded eXeLearning editor inside Moodle, enabling content creation and editing without leaving the platform.
- Add editor bootstrap system (`editor/index.php`, `editor/static.php`, `editor/save.php`) with iframe-based loading and postMessage communication layer.
- Implement admin settings interface to install, update and uninstall the editor from GitHub releases, including improved UX feedback and multilingual status messages.
- Add external AJAX API (`manage_embedded_editor`) for installation and status management operations.
- Introduce source resolution strategy prioritizing `moodledata` over bundled assets for editor resources.
- Add postMessage bridge (`moodle_exe_bridge.js`) supporting document lifecycle events such as open, save/export and real-time change tracking via Yjs.
- Improve admin-aware error handling with differentiated messaging for administrators and standard users.
- Add blueprint configuration for default setup and sample activities.
- Extend multilingual support (en, es, ca, eu, gl).
- Introduce new capability `mod/exeweb:manageembeddededitor` for controlling editor management actions.
- Add CI support for Playground PR previews and automated editor release checks.
- Ensure compatibility with subpath deployments by restricting trusted origins to scheme + host in postMessage security model.
- Replace iframe error handling with inline HTML rendering to avoid Moodle exception screens inside embedded contexts.
- Add `manage_embedded_editor_upload.php` endpoint for environments where direct GitHub access is not available (e.g., Playground/WASM constraints).
- Add compatibility with eXeLearning 4 while maintaining support from eXeLearning 2.9 online onwards.
- Update activity icons to align with the latest eXeLearning design.

## v1.1 – 2025-06-20

### Development & tooling
- Add Docker support and Makefile for development, linting and fixing tasks.
- Improve build workflow.

### Moodle integration & compatibility
- Provide compatibility for eXe 3 and 2.9.
- Fix "Edit on eXeLearning and return to course" button functionality.
- Hide edit option when there is no `exeonlinebaseuri` setting.

### Backend & parameters
- Review parameters: pass `HOST_IP` to Moodle and refine API key handling.
- Remove unnecessary IP detection logic.
- Add provider field to payload.

### Fixes
- Fix parameter order when creating eXe user and resolve malformed Moodle site name handling.

### Defaults & requirements
- Introduce new default value for mandatory files list (required for eXeLearning v3.0.0).

---

## v1.0 – 2024-03-21

**First release of mod_exeweb**

Moodle activity module for creating and editing websites using [eXeLearning (online version)](https://github.com/exelearning/iteexe_online).

Requires the eXeLearning online version to be installed and access to its configuration files in order to operate correctly.