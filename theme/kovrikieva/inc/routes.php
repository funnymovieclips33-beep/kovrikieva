<?php
/**
 * Маршруты лендингов.
 *
 *  /                          → ЭВА (главная, Минск)
 *  /{город}/                  → ЭВА в городе               (старые URL — сохранены)
 *  /{направление}/            → лендинг направления          (старые URL — сохранены)
 *  /{направление}/{город}/    → направление в городе         (НОВЫЕ страницы)
 *
 * Страницы в админке для этих адресов создавать не нужно — всё генерируется из inc/data-*.php.
 */
defined('ABSPATH') || exit;

add_filter('query_vars', function ($vars) {
	$vars[] = 'kv_dir';
	$vars[] = 'kv_city';
	$vars[] = 'kv_brand';
	return $vars;
});

function kv_rewrite_rules() {
	$cities = implode('|', array_map('preg_quote', array_keys(kv_cities())));
	foreach (kv_directions() as $key => $d) {
		if ($d['base'] === '') {
			if (!empty($d['cities'])) {
				add_rewrite_rule('^(' . $cities . ')/?$', 'index.php?kv_dir=' . $key . '&kv_city=$matches[1]', 'top');
			}
			continue;
		}
		$base = preg_quote($d['base']);
		add_rewrite_rule('^' . $base . '/?$', 'index.php?kv_dir=' . $key, 'top');
		if (!empty($d['cities'])) {
			add_rewrite_rule('^' . $base . '/(' . $cities . ')/?$', 'index.php?kv_dir=' . $key . '&kv_city=$matches[1]', 'top');
		}
	}
	// Страницы марок: /kovriki/ и /kovriki/{марка}/
	$brands = implode('|', array_map('preg_quote', array_keys(kv_brands())));
	add_rewrite_rule('^kovriki/?$', 'index.php?kv_dir=eva&kv_brand=_hub', 'top');
	add_rewrite_rule('^kovriki/(' . $brands . ')/?$', 'index.php?kv_dir=eva&kv_brand=$matches[1]', 'top');
	// Старая карта сайта Yoast → карта сайта WordPress.
	add_rewrite_rule('^sitemap_index\.xml$', 'index.php?kv_legacy_sitemap=1', 'top');
}
add_action('init', 'kv_rewrite_rules');

add_filter('query_vars', function ($vars) {
	$vars[] = 'kv_legacy_sitemap';
	return $vars;
});

/** Автоматический сброс правил при изменении списка городов/направлений. */
add_action('init', function () {
	$hash = md5(wp_json_encode([array_keys(kv_brands()), array_keys(kv_cities()), array_map(function ($d) {
		return [$d['base'], !empty($d['cities'])];
	}, kv_directions())]));
	if (get_option('kv_rules_hash') !== $hash) {
		flush_rewrite_rules(false);
		update_option('kv_rules_hash', $hash, true);
	}
}, 99);

/** Для лендингов не выполняем лишний SQL-запрос постов. */
add_filter('posts_pre_query', function ($posts, $q) {
	if ($q->is_main_query() && $q->get('kv_dir')) {
		$q->found_posts = 0;
		return [];
	}
	return $posts;
}, 10, 2);

add_action('parse_query', function ($q) {
	if (!$q->is_main_query()) {
		return;
	}
	$dir = $q->get('kv_dir');
	if ($dir && kv_direction($dir)) {
		$city = $q->get('kv_city');
		if ($city && !kv_city($city)) {
			$q->set_404();
			return;
		}
		$brand = $q->get('kv_brand');
		if ($brand && $brand !== '_hub' && !kv_brand($brand)) {
			$q->set_404();
			return;
		}
		kv_set_ctx($dir, $city, $brand);
		$q->is_home = false;
		$q->is_404  = false;
	}
});

add_action('template_redirect', function () {
	if (get_query_var('kv_legacy_sitemap')) {
		wp_safe_redirect(home_url('/wp-sitemap.xml'), 301);
		exit;
	}
	// Главная — это лендинг ЭВА.
	if (is_front_page() && !kv_ctx()) {
		kv_set_ctx('eva');
	}
	if (kv_ctx()) {
		status_header(200);
		// Приводим URL к виду со слешем (как на старом сайте).
		$path = wp_parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
		if ($path && substr($path, -1) !== '/') {
			$qs = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
			wp_safe_redirect(home_url($path . '/') . $qs, 301);
			exit;
		}
	}
}, 1);

add_filter('template_include', function ($tpl) {
	if (kv_ctx()) {
		return KV_DIR . (kv_ctx()['brand'] ? '/brand.php' : '/landing.php');
	}
	return $tpl;
});

add_filter('body_class', function ($c) {
	$ctx = kv_ctx();
	if ($ctx) {
		$c[] = 'kv-landing';
		$c[] = 'kv-dir-' . sanitize_html_class($ctx['dir']);
		if ($ctx['city']) {
			$c[] = 'kv-has-city';
		}
	}
	return $c;
});

/** Список всех URL лендингов (для карты сайта). */
function kv_all_landing_urls() {
	$urls = [];
	foreach (kv_directions() as $key => $d) {
		if ($d['base'] !== '') {
			$urls[] = kv_url($key);
		}
		if (!empty($d['cities'])) {
			foreach (array_keys(kv_cities()) as $slug) {
				$urls[] = kv_url($key, $slug);
			}
		}
	}
	$urls[] = kv_brand_url();
	foreach (array_keys(kv_brands()) as $b) {
		$urls[] = kv_brand_url($b);
	}
	return $urls;
}

/** Провайдер карты сайта WordPress для виртуальных страниц. */
add_action('init', function () {
	if (!class_exists('WP_Sitemaps_Provider')) {
		return;
	}
	require_once KV_DIR . '/inc/sitemap-provider.php';
	wp_register_sitemap_provider('landings', new KV_Sitemap_Provider());
});

add_filter('wp_sitemaps_add_provider', function ($provider, $name) {
	return $name === 'users' ? false : $provider;
}, 10, 2);

add_filter('wp_sitemaps_taxonomies', function ($t) {
	unset($t['post_format'], $t['post_tag']);
	return $t;
});
