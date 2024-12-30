<?php if (!defined('ABSPATH')) { exit; }
 /**
 * @author  BulgaWeb
 * @package BW
 * @since   1.0.0
 * @version 1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:     BW Detect Mobile
 * Description:     Detect Mobile, Tablet or Desktop
 * Version:         0.4.0
 * Plugin URI:      https://bulgaweb.com/plugins
 * Author:          BulgaWeb
 * Author URI:      https://bulgaweb.com/
 * Text Domain:     bw-detect-mobile
 * Domain Path:     /languages/
 * Requires PHP:    8.0
 * License:         GPL-2.0 or later
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @copyright 2017-2025 BulgaWeb
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * ( at your option ) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

define('BW_Detect_Mobile_VERSION', '0.4.0');
define('BW_Detect_Mobile_FILE', __FILE__);
define('BW_Detect_Mobile_DIR', plugin_dir_path(__FILE__));
define('BW_Detect_Mobile_URL', plugin_dir_url(__FILE__));

require_once BW_Detect_Mobile_DIR . 'includes/class-bw-detect-mobile-main.php';

\BW_Detect_Mobile\Main::get_instance();
