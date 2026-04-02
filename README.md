# eXeLearning web sites for Moodle

[![Preview in Moodle Playground](https://raw.githubusercontent.com/ateeducacion/action-moodle-playground-pr-preview/refs/heads/main/assets/playground-preview-button.svg)](https://ateeducacion.github.io/moodle-playground/?blueprint-url=https://raw.githubusercontent.com/exelearning/mod_exeweb/refs/heads/main/blueprint.json)

Activity-type module to create and edit web sites with eXeLearning (online).

You need the eXeLearning online version installed (ws28 or higher) and access to its configuration files to run
this module.

## Compatibility

This plugin version is tested for:

* Moodle 4.1.3+ (Build: 20230526)
* Moodle 3.11.10+ (Build: 20221007)
* Moodle 3.9.2+ (Build: 20200929)

## Installation

> **Important:** It is recommended to install from a [release ZIP](https://github.com/exelearning/mod_exeweb/releases), which includes the embedded editor pre-built for optimal performance. If the release ZIP does not include the editor, or if you want to install a newer version, administrators can download it from GitHub Releases via the _Manage embedded editor_ page in the plugin settings.

### Installing via uploaded ZIP file

1. Download the latest ZIP from [Releases](https://github.com/exelearning/mod_exeweb/releases).
2. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
3. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
4. Check the plugin validation report and finish the installation.

### Installing manually

1. Download and extract the latest ZIP from [Releases](https://github.com/exelearning/mod_exeweb/releases).
2. Place the extracted contents in `{your/moodle/dirroot}/mod/exeweb`.
3. Log in to your Moodle site as an admin and go to _Site administration >
   Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## Configuration

Go to the URL:

    {your/moodle/dirroot}/admin/settings.php?section=modsettingexeweb

  * Remote URI: *exeweb  | exeonlinebaseuri*
    * eXeLearning (online) base URI

  * Signing Key: *exeweb | hmackey1*
    * Key used to sign data sent to the eXeLearning server, to check the data origin. Use up to 32 characters.

  * Token expiration: *exeweb | tokenexpiration*
    * Max time (in seconds) to edit the package in eXeLearning and get back to Moodle.

  * New package template: *exeweb | template*
    * Package uploaded there will be used as the default package for new activities.

  * Send template: *exeweb | sendtemplate*
    * Sends uploaded (or default) template to eXeLearning when creating a new activity.

  * Mandatory files RE list: *exeweb | mandatoryfileslist*
    * A mandatory files list can be configurad here. Enter each mandatory file as a PHP regular expression (RE) on a new line.

  * Forbidden files RE list: *exeweb | forbiddenfileslist*
    * A forbidden files list can be configurad here. Enter each forbidden file as a PHP regular expression (RE) on a new line.

## Embedded Editor Management

The plugin supports two editor sources with the following precedence:

1. **Admin-installed** (moodledata): Downloaded from GitHub Releases via the admin management page. Stored under `moodledata/mod_exeweb/embedded_editor/`.
2. **Bundled** (plugin): Included in the plugin release ZIP at `dist/static/`.

An admin-installed version always takes precedence over the bundled version. If neither source is available, the embedded editor cannot be used.

### Managing the editor

1. Go to _Site administration > Plugins > Activity modules > eXeLearning (website)_.
2. The settings page shows the current editor status and active source.
3. Click _Manage embedded editor_ to access the management page.
4. From there you can install, update, repair, or remove the editor.

The management page requires the `moodle/site:config` and `mod/exeweb:manageembeddededitor` capabilities.

## Development

For development setup, build instructions, and contributing guidelines, see [DEVELOPMENT.md](DEVELOPMENT.md).

## About

Copyright 2023:
Centro Nacional de Desarrollo Curricular en Sistemas no Propietarios (CeDeC) /
INTEF (Instituto Nacional de Tecnologías Educativas y de Formación del Profesorado)

### License

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should receive a copy of the GNU General Public License
along with this program.
