# Joomla Plugin: System - Media Sanitize (plg_system_mediasanitize)

A lightweight and efficient Joomla 4/5/6 system plugin that automatically sanitizes filenames upon upload. It intercepts both standard uploads and the new Vue.js-based Media Manager API in Joomla 4/5, ensuring all file names are clean, web-safe, and free of special characters before they are saved to the server.

## Features

- **Automatic Transliteration**: Converts Latin characters with accents (e.g., `ç`, `ã`, `é`) into their clean ASCII equivalents (e.g., `c`, `a`, `e`) using Joomla's native `Transliterate` class.
- **Space and Special Character Removal**: Replaces spaces and unsupported characters with underscores (`_`).
- **Prevents Multiple Underscores**: Automatically cleans up multiple consecutive underscores (e.g., `___`) into a single one (`_`).
- **Customizable Case Formatting**: Allows you to choose whether to convert filenames to all lowercase, all uppercase, or keep the original casing.
- **Joomla 4/5 Media Manager Support**: Intercepts the `onContentBeforeSave` event with the `com_media.file` context, which means it fully supports the new Vue.js Media Manager API introduced in Joomla 4.
- **Global Upload Support**: Also intercepts `onAfterInitialise` to catch legacy `$_FILES` uploads from third-party components early in the lifecycle.

## Installation

1. Download the latest release zip file.
2. In your Joomla Administrator panel, go to **System > Install > Extensions**.
3. Upload the zip file.
4. Go to **System > Manage > Plugins**, search for **System - Media Sanitize** (`plg_system_mediasanitize`), configure your preferred case format, and **Enable** the plugin.

## Configuration

In the plugin settings, you can configure the **Letter Case Format**:
- **All Lowercase (Default)**: Converts everything to lowercase (e.g., `Ação.png` -> `acao.png`).
- **All Uppercase**: Converts everything to uppercase (e.g., `Ação.png` -> `ACAO.png`).
- **Keep Original**: Maintains the original letter casing, only removing accents and special characters (e.g., `Ação de Marketing.png` -> `Acao_de_Marketing.png`).

## Requirements
- Joomla 4.x, 5.x or 6.x
- PHP 7.4 or newer

## License

This extension is licensed under the GNU General Public License version 2 or later (GPL v2).

## Credits
Developed by **Ponto Mega** (https://www.pontomega.com.br).
