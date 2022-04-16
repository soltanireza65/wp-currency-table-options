<?php if (!defined('ABSPATH')) {
    die;
}
/**
 * Plugin Name: تنظیمات سایت
 * Plugin URI: https://pypracts.ir
 * Author: pypracts
 * Author URI: https://pypracts.ir
 * Version: 1.0.2
 * Description: 
 * Text Domain: pypracts
 * Domain Path: /languages
 */
require_once plugin_dir_path(__FILE__) . 'classes/setup.class.php';
require_once plugin_dir_path(__FILE__) . '/options/admin.php';
require_once plugin_dir_path(__FILE__) . '/inc/rest.php';
require_once plugin_dir_path(__FILE__) . '/inc/cron_schedules.php';
require_once plugin_dir_path(__FILE__) . '/inc/cron.php';
require_once plugin_dir_path(__FILE__) . '/inc/index.php';
