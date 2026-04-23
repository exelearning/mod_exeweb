# CHANGELOG

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