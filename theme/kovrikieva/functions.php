<?php
/**
 * KovrikiEVA — функции темы.
 */
defined('ABSPATH') || exit;

define('KV_VER', '1.0.0');
define('KV_DIR', get_template_directory());
define('KV_URI', get_template_directory_uri());

require KV_DIR . '/inc/core.php';
require KV_DIR . '/inc/settings.php';
require KV_DIR . '/inc/routes.php';
require KV_DIR . '/inc/seo.php';
require KV_DIR . '/inc/perf.php';
require KV_DIR . '/inc/forms.php';
require KV_DIR . '/inc/setup.php';
