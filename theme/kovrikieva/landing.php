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
	'hero',          // оффер
	'advantages',    // почему ЭВА
	'constructor',   // цены + сборка (для ЭВА)
	'prices',        // цены (для остальных направлений)
	'extra',
	'gallery',       // доказательства: фото работ
	'reviews',       // доказательства: отзывы
	'compare',       // сравнение с альтернативами
	'steps',         // как мы работаем
	'certificate',   // подарок
	'related',       // допродажа
	'city',          // условия для города
	'faq',           // снятие возражений + SEO-текст
	'brands',        // перелинковка по маркам
	'delivery',      // доставка + города
];
if ($key !== 'eva') {
	$sections = array_values(array_diff($sections, ['compare', 'brands']));
}
foreach (apply_filters('kv_sections', $sections, $key, $city) as $s) {
	kv_part($s, $args);
}

get_footer();
