<?php
/**
 * Данные, контекст страницы, хелперы вывода.
 */
defined('ABSPATH') || exit;

/** Загрузка файла данных inc/data-{name}.php (с кэшем в памяти). */
function kv_data($name) {
	static $cache = [];
	if (!isset($cache[$name])) {
		$cache[$name] = apply_filters('kv_data_' . $name, require KV_DIR . '/inc/data-' . $name . '.php');
	}
	return $cache[$name];
}

function kv_directions() { return kv_data('directions'); }
function kv_cities()     { return kv_data('cities'); }

function kv_direction($key) {
	$d = kv_directions();
	return $d[$key] ?? null;
}

function kv_city($slug) {
	$c = kv_cities();
	return $slug && isset($c[$slug]) ? $c[$slug] : null;
}

const KV_REGIONS = [
	'brest'   => 'Брестская область',
	'vitebsk' => 'Витебская область',
	'gomel'   => 'Гомельская область',
	'grodno'  => 'Гродненская область',
	'minsk'   => 'Минская область',
	'mogilev' => 'Могилёвская область',
];

/**
 * Текущий контекст лендинга: ['dir' => ключ направления, 'city' => slug|null] или null.
 */
function kv_ctx() {
	global $kv_ctx;
	return $kv_ctx ?? null;
}

function kv_set_ctx($dir, $city = null) {
	global $kv_ctx;
	$kv_ctx = ['dir' => $dir, 'city' => $city ?: null];
}

/** URL лендинга направления (с городом или без). Всегда со слешем на конце, как на старом сайте. */
function kv_url($dir, $city = null) {
	$d = kv_direction($dir);
	$base = $d ? $d['base'] : '';
	$path = trim($base . ($city ? '/' . $city : ''), '/');
	return home_url($path ? '/' . $path . '/' : '/');
}

/** «в Бресте» / «в Минске». */
function kv_city_in($city = null) {
	$c = kv_city($city);
	return $c ? $c[1] : 'в Минске';
}

function kv_city_name($city = null) {
	$c = kv_city($city);
	return $c ? $c[0] : 'Минск';
}

/** Подстановка {city} и {city_name}. */
function kv_tpl($str, $city = null) {
	return strtr((string) $str, [
		'{city}'      => kv_city_in($city),
		'{city_name}' => kv_city_name($city),
	]);
}

/** URL файла из /wp-content/uploads/ — пути как на старом сайте. */
function kv_upload($path) {
	if (preg_match('#^(https?:)?//#', $path)) {
		return $path;
	}
	return content_url('uploads/' . ltrim($path, '/'));
}

/**
 * <img> с ленивой загрузкой. $eager = true для первого экрана (LCP).
 */
function kv_img($path, $alt = '', $class = '', $eager = false, $w = 0, $h = 0) {
	$attrs = [
		'src'      => kv_upload($path),
		'alt'      => $alt,
		'class'    => $class,
		'decoding' => 'async',
	];
	if ($eager) {
		$attrs['fetchpriority'] = 'high';
	} else {
		$attrs['loading'] = 'lazy';
	}
	if ($w && $h) {
		$attrs['width']  = $w;
		$attrs['height'] = $h;
	}
	$html = '<img';
	foreach ($attrs as $k => $v) {
		if ($v === '' && $k !== 'alt') {
			continue;
		}
		$html .= ' ' . $k . '="' . esc_attr($v) . '"';
	}
	return $html . '>';
}

function kv_price($n) {
	return is_numeric($n) ? 'от ' . $n . ' руб.' : esc_html($n);
}

/** Карточки «сопутствующих товаров». */
function kv_catalog() {
	return [
		'eva'                    => ['Коврики ЭВА в салон', 30, '2021/05/dlyasalona.jpg', kv_url('eva')],
		'vorsovye-kovriki'       => ['Ворсовые коврики', 25, '2023/08/vorsovye-kovriki-v-salon-minsk-1.jpg', kv_url('vorsovye-kovriki')],
		'organajzer-v-bagazhnik' => ['Органайзер в авто', 85, '2024/02/organaizer-dlya-auto.jpg', kv_url('organajzer-v-bagazhnik')],
		'v-lodku'                => ['Коврик в лодку', 110, '2021/06/boat-product.jpg', kv_url('v-lodku')],
		'dlja-doma'              => ['Коврики для дома', 20, '2024/02/pridvernij-kovrik.jpg', kv_url('dlja-doma')],
		'kovrik-v-bagazhnik'     => ['Коврик в багажник', 50, '2021/05/five.jpg', kv_url('kovrik-v-bagazhnik')],
		'home-bath'              => ['Коврик в ванную', 20, '2024/02/kovrik-v-vannyy.jpg', kv_url('dlja-doma')],
		'home-balcony'           => ['Коврик на балкон', 20, '2024/02/kovrik-v-koridor.jpg', kv_url('dlja-doma')],
		'home-kitchen'           => ['Коврик на кухню', 10, '2024/02/kovrik-pod-posudu.jpg', kv_url('dlja-doma')],
		'home-pets'              => ['Коврик для питомцев', 20, '2024/02/kovrik-dlya-sobak.jpg', kv_url('dlja-doma')],
		'home-hall'              => ['Коврик в прихожую', 20, '2024/02/pridvernij-kovrik.jpg', kv_url('dlja-doma')],
		'home-flowers'           => ['Коврик для цветов', 10, '2024/02/kovrik-dlya-cvetov.jpg', kv_url('dlja-doma')],
	];
}

/** Подключение секции из parts/. */
function kv_part($name, $args = []) {
	get_template_part('parts/' . $name, null, $args);
}

/** Детерминированный выбор варианта текста по городу (уникализация городских страниц). */
function kv_pick(array $variants, $seed) {
	return $variants[abs(crc32((string) $seed)) % count($variants)];
}

/** Иконка из спрайта. */
function kv_icon($name, $class = '') {
	return '<svg class="kv-i ' . esc_attr($class) . '" aria-hidden="true"><use href="#i-' . esc_attr($name) . '"/></svg>';
}
