<?php
/**
 * Поддержка темы и первичная настройка при активации.
 */
defined('ABSPATH') || exit;

add_action('after_setup_theme', function () {
	add_theme_support('title-tag');
	add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
	add_theme_support('responsive-embeds');
	register_nav_menus(['primary' => 'Главное меню (если не задано — используется встроенное)']);
});

/** Обычные страницы (не лендинги), которые тема создаёт при активации. */
function kv_default_pages() {
	return [
		'o-nas'          => ['О компании «KOVRIKIEVABY»', 'o-nas.html'],
		'fotogalereya'   => ['Фотогалерея', ''],
		'otzyvy'         => ['Отзывы', ''],
		'zakazat'        => ['Изготовление и пошив ковриков на заказ', ''],
		'privacy-policy' => ['Политика конфиденциальности', 'privacy-policy.html'],
	];
}

add_action('after_switch_theme', function () {
	// ЧПУ как на старом сайте: /slug/
	if (get_option('permalink_structure') !== '/%postname%/') {
		update_option('permalink_structure', '/%postname%/');
	}

	foreach (kv_default_pages() as $slug => [$title, $file]) {
		$content = '';
		if ($file && is_readable(KV_DIR . '/inc/content/' . $file)) {
			$content = file_get_contents(KV_DIR . '/inc/content/' . $file);
		}
		$existing = get_page_by_path($slug, OBJECT, 'page');
		if ($existing) {
			// Черновик «Политики конфиденциальности», который создаёт сам WordPress, заменяем нашим текстом.
			if ($existing->post_status !== 'publish') {
				wp_update_post([
					'ID'           => $existing->ID,
					'post_status'  => 'publish',
					'post_title'   => $title,
					'post_content' => $content ?: $existing->post_content,
				]);
			}
			continue;
		}
		wp_insert_post([
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $content,
		]);
	}

	// Политика конфиденциальности WP → наша страница.
	$pp = get_page_by_path('privacy-policy');
	if ($pp) {
		update_option('wp_page_for_privacy_policy', $pp->ID);
	}

	update_option('show_on_front', 'posts');
	delete_option('kv_rules_hash');
	flush_rewrite_rules();
});

/** Главное меню (встроенное). */
function kv_menu_items() {
	return [
		['Для авто', kv_url('eva'), [
			['Коврики Эва', kv_url('eva')],
			['Ворсовые коврики', kv_url('vorsovye-kovriki')],
			['Коврик в багажник', kv_url('kovrik-v-bagazhnik')],
			['Автокейсы', kv_url('organajzer-v-bagazhnik')],
		]],
		['В лодку', kv_url('v-lodku')],
		['Для дома', kv_url('dlja-doma')],
		['Заказать', home_url('/zakazat/')],
		['О нас', home_url('/o-nas/'), [
			['О компании', home_url('/o-nas/')],
			['Фотогалерея', home_url('/fotogalereya/')],
			['Отзывы', home_url('/otzyvy/')],
		]],
	];
}
