<?php
/**
 * Шаблон лендинга направления (главная, разделы, городские страницы).
 * Содержимое — inc/data-directions.php. Секции — parts/.
 */
defined('ABSPATH') || exit;

$ctx  = kv_ctx();
$key  = $ctx['dir'];
$d    = kv_direction($key);
$city = $ctx['city'];
$args = ['key' => $key, 'd' => $d, 'city' => $city];

get_header();

$sections = [
	'hero',
	'advantages',
	'constructor',
	'prices',
	'extra',
	'gallery',
	'certificate',
	'related',
	'steps',
	'city',
	'faq',
	'delivery',
];
foreach (apply_filters('kv_sections', $sections, $key, $city) as $s) {
	kv_part($s, $args);
}

get_footer();
