# Campaignium Hosting

A lightweight WordPress plugin that hides the WP Engine admin menu from all users **except** those with an email address ending in `@campaignium.com`.

## 🔧 Features

- Removes the WP Engine dashboard menu item (`wpe-common`) for non-Campaignium users
- Adds CSS fallback in case the menu item persists due to JavaScript-rendered elements
- Ensures only authorized users can access hosting-specific controls

## 🚀 Installation

1. Upload the plugin folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the **Plugins** menu in WordPress.

## 🛡️ Permissions Logic

This plugin checks the logged-in user's email. If the email **does not** end with `@campaignium.com`, the `WP Engine` menu item will be hidden.

## 💻 GitHub Updater Support

To enable automatic updates via GitHub, this plugin uses the [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) library.

If you're cloning or downloading this plugin directly from GitHub:

- Make sure to include the `plugin-update-checker/` folder.
- Tag releases properly (e.g. `v1.0.1`) for update detection.

## 🧠 Requirements

- WordPress 5.0+
- PHP 7.4+

## 📦 Composer (Optional)

You can include this plugin as a dependency via [WPackagist](https://wpackagist.org/) or use GitHub directly as a VCS source in your `composer.json`.

## 📬 Support

This plugin is maintained by the Campaignium development team.

For internal use and client hosting management only.

