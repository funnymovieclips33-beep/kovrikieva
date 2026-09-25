<?php
/**
 * SEO без плагинов: title, description, canonical, Open Graph, Schema.org.
 * Если установлен Yoast / Rank Math — мета выводит плагин, тема выводит только Schema лендингов.
 *
 * Правило сохранения позиций: для всех URL старого сайта title/description берутся
 * ДОСЛОВНО из inc/data-seo-legacy.php.
 */
defined('ABSPATH') || exit;

function kv_seo_plugin_active() {
	return defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || defined('AIOSEO_VERSION');
}

/** Текущий путь без слешей: '', 'brest', 'vorsovye-kovriki/brest', 'o-nas'. */
function kv_current_path() {
	$ctx = kv_ctx();
	if ($ctx) {
		$d = kv_direction($ctx['dir']);
		return trim($d['base'] . ($ctx['city'] ? '/' . $ctx['city'] : ''), '/');
	}
	if (is_singular()) {
		return trim(wp_parse_url(get_permalink(), PHP_URL_PATH), '/');
	}
	return null;
}

/** [title, description] для текущей страницы. */
function kv_meta() {
	static $meta = null;
	if ($meta !== null) {
		return $meta;
	}
	$legacy = kv_data('seo-legacy');
	$path   = kv_current_path();
	if ($path !== null && isset($legacy[$path])) {
		return $meta = $legacy[$path];
	}
	$ctx = kv_ctx();
	if ($ctx) {
		$d = kv_direction($ctx['dir']);
		$t = !empty($d['city_title']) ? kv_tpl($d['city_title'], $ctx['city']) : $d['h1'];
		$s = !empty($d['city_desc']) ? kv_tpl($d['city_desc'], $ctx['city']) : wp_strip_all_tags($d['lead']);
		return $meta = [$t, $s];
	}
	if (is_singular()) {
		$p = get_queried_object();
		$desc = has_excerpt($p) ? get_the_excerpt($p) : wp_trim_words(wp_strip_all_tags(strip_shortcodes($p->post_content)), 28, '…');
		return $meta = [get_the_title($p) . ' — ' . get_bloginfo('name'), $desc];
	}
	return $meta = [null, get_bloginfo('description')];
}

function kv_canonical() {
	$path = kv_current_path();
	if ($path === null) {
		return null;
	}
	return home_url($path === '' ? '/' : '/' . $path . '/');
}

add_filter('pre_get_document_title', function ($title) {
	if (kv_seo_plugin_active() && !kv_ctx()) {
		return $title;
	}
	$m = kv_meta();
	return $m[0] ?: $title;
}, 20);

// Canonical выводим сами (в т.ч. для виртуальных страниц).
remove_action('wp_head', 'rel_canonical');

add_action('wp_head', function () {
	$ctx = kv_ctx();
	if (kv_seo_plugin_active() && !$ctx) {
		return;
	}
	[$title, $desc] = kv_meta();
	$canon = kv_canonical();
	$img   = kv_upload($ctx ? kv_direction($ctx['dir'])['hero_img'] : '2021/05/banner-home.png');

	echo "\n";
	if ($desc) {
		echo '<meta name="description" content="' . esc_attr($desc) . "\">\n";
	}
	if (is_404() || is_search()) {
		echo "<meta name=\"robots\" content=\"noindex, follow\">\n";
	} else {
		echo "<meta name=\"robots\" content=\"index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1\">\n";
	}
	if ($canon) {
		echo '<link rel="canonical" href="' . esc_url($canon) . "\">\n";
	}
	$og = [
		'og:locale'      => 'ru_RU',
		'og:type'        => 'website',
		'og:site_name'   => 'Купить коврики Эва в Минске официальный сайт',
		'og:title'       => $title ?: wp_get_document_title(),
		'og:description' => $desc,
		'og:url'         => $canon,
		'og:image'       => $img,
	];
	foreach ($og as $k => $v) {
		if ($v) {
			echo '<meta property="' . $k . '" content="' . esc_attr($v) . "\">\n";
		}
	}
	echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
}, 1);

/** Schema.org JSON-LD. */
add_action('wp_head', function () {
	$site  = home_url('/');
	$graph = [];

	$org = [
		'@type'        => ['LocalBusiness', 'Store'],
		'@id'          => $site . '#org',
		'name'         => 'KOVRIKIEVABY',
		'url'          => $site,
		'logo'         => kv_upload('2021/05/logo.png'),
		'image'        => kv_upload('2021/05/banner-home.png'),
		'telephone'    => kv_opt('phone'),
		'email'        => kv_opt('email'),
		'priceRange'   => 'BYN 10–300',
		'address'      => [
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'ул. Тростенецкая 10',
			'addressLocality' => 'Минск',
			'addressCountry'  => 'BY',
		],
		'geo'          => ['@type' => 'GeoCoordinates', 'latitude' => kv_opt('geo_lat'), 'longitude' => kv_opt('geo_lng')],
		'openingHoursSpecification' => [
			['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'], 'opens' => '10:00', 'closes' => '19:00'],
			['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Saturday', 'opens' => '10:00', 'closes' => '15:00'],
		],
		'areaServed'   => ['@type' => 'Country', 'name' => 'Беларусь'],
		'sameAs'       => array_values(array_filter([kv_opt('instagram')])),
	];
	$graph[] = $org;
	$graph[] = ['@type' => 'WebSite', '@id' => $site . '#website', 'url' => $site, 'name' => 'KOVRIKIEVABY', 'inLanguage' => 'ru-RU', 'publisher' => ['@id' => $site . '#org']];

	$ctx = kv_ctx();
	if ($ctx) {
		$d     = kv_direction($ctx['dir']);
		$canon = kv_canonical();
		$city  = $ctx['city'];

		$prices = [];
		if (!empty($d['prices']['items'])) {
			foreach ($d['prices']['items'] as $it) { $prices[] = $it[1]; }
		}
		if (!empty($d['prices']['rows'])) {
			foreach ($d['prices']['rows'] as $row) {
				foreach ($row as $cell) { if (is_int($cell)) { $prices[] = $cell; } }
			}
		}
		$prices = $prices ?: [$d['price_from']];

		$graph[] = [
			'@type'       => 'Product',
			'@id'         => $canon . '#product',
			'name'        => kv_tpl(!empty($city) && !empty($d['h1_city']) ? $d['h1_city'] : $d['h1'], $city),
			'description' => wp_strip_all_tags(kv_tpl($d['lead'], $city)),
			'image'       => array_values(array_map('kv_upload', array_filter(array_merge([$d['hero_img']], $d['hero_thumbs'] ?? [])))),
			'brand'       => ['@type' => 'Brand', 'name' => 'KOVRIKIEVABY'],
			'offers'      => [
				'@type'         => 'AggregateOffer',
				'priceCurrency' => 'BYN',
				'lowPrice'      => min($prices),
				'highPrice'     => max($prices),
				'offerCount'    => count($prices),
				'availability'  => 'https://schema.org/InStock',
				'seller'        => ['@id' => $site . '#org'],
				'areaServed'    => $city ? ['@type' => 'City', 'name' => kv_city_name($city)] : ['@type' => 'Country', 'name' => 'Беларусь'],
			],
		];

		if (!empty($d['faq'])) {
			$faq = [];
			foreach ($d['faq'] as $f) {
				$faq[] = ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => wp_strip_all_tags($f[1])]];
			}
			$graph[] = ['@type' => 'FAQPage', '@id' => $canon . '#faq', 'mainEntity' => $faq];
		}

		$crumbs = [['Главная', $site]];
		if ($d['base'] !== '') {
			$crumbs[] = [$d['menu'], kv_url($ctx['dir'])];
		}
		if ($city) {
			$crumbs[] = [kv_city_name($city), $canon];
		}
		if (count($crumbs) > 1) {
			$items = [];
			foreach ($crumbs as $i => $c) {
				$items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $c[0], 'item' => $c[1]];
			}
			$graph[] = ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
		}
	}

	echo '<script type="application/ld+json">' . wp_json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}, 5);

/** Хлебные крошки (HTML). */
function kv_breadcrumbs() {
	$ctx = kv_ctx();
	$items = [['Главная', home_url('/')]];
	if ($ctx) {
		$d = kv_direction($ctx['dir']);
		if ($d['base'] !== '') {
			$items[] = [$d['menu'], $ctx['city'] ? kv_url($ctx['dir']) : null];
		}
		if ($ctx['city']) {
			$items[] = [kv_city_name($ctx['city']), null];
		}
	} elseif (is_singular()) {
		$items[] = [get_the_title(), null];
	}
	if (count($items) < 2) {
		return '';
	}
	$html = '<nav class="kv-crumbs" aria-label="Навигация"><ol>';
	foreach ($items as $it) {
		$html .= '<li>' . ($it[1] ? '<a href="' . esc_url($it[1]) . '">' . esc_html($it[0]) . '</a>' : '<span aria-current="page">' . esc_html($it[0]) . '</span>') . '</li>';
	}
	return $html . '</ol></nav>';
}
