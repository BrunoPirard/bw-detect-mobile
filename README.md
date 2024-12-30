# BW Detect Mobile

### Description

BW Detect Mobile is a WordPress plugin that easily detects mobile devices, tablets, and desktop computers. It integrates seamlessly with Bricks Builder and offers advanced detection features for a better adaptive user experience.

### Features

Accurate detection of mobile devices and tablets
Native integration with Bricks Builder
Easy-to-use helper functions
Custom conditions for Bricks Builder
Multilingual support

### Requirements

WordPress 5.0 or higher
PHP 8.0 or higher
Bricks Builder (recommended but not required)
Installation
Download the plugin
Upload it to the /wp-content/plugins/ directory
Activate the plugin through the 'Plugins' menu in WordPress

### Usage

PHP Helper Functions
// Check if device is mobile (excluding tablets)
if (bw_is_mobile()) {
// Mobile code
}

// Check if device is a tablet
if (bw_is_tablet()) {
// Tablet code
}

// Check if device is a desktop computer
if (bw_is_desktop()) {
// Desktop code
}

// Advanced usage
$detector = bw_detect();
if ($detector->is('iPhone')) {
// iPhone specific code
}

### Bricks Builder Integration

The plugin automatically adds a new condition group in Bricks Builder:

### Device Detection

Is Mobile
Is Tablet
Is Desktop
Contributing
Contributions are welcome! Feel free to:

Fork the project
Create your feature branch
Commit your changes
Push to the branch
Create a Pull Request
License
This plugin is licensed under GPL-2.0 or later. See the LICENSE file for more details.

### Author

BulgaWeb - https://bulgaweb.com

### Changelog

0.4.0
Updating code comments and the README file

0.3.0
Added translation support

0.2.0
Added global helper functions
Improved Bricks Builder integration
Fixed minor bugs

0.1.0
Initial release
Basic mobile device detection
Bricks Builder integration

### Acknowledgments

This plugin uses the Mobile-Detect library for device detection.
