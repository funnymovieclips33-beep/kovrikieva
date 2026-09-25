<?php
/**
 * Настройки: Внешний вид → Настроить → «KovrikiEVA: контакты и интеграции».
 */
defined('ABSPATH') || exit;

function kv_defaults() {
	return [
		'phone'         => '+375447764764',
		'phone_label'   => '+375 (44) 7-764-764',
		'viber'         => '+375291450133',
		'telegram'      => '+375291450133',
		'instagram'     => 'https://www.instagram.com/kovrikieva.by',
		'email'         => 'kovrikievaby1@gmail.com',
		'address'       => 'г. Минск, ул. Тростенецкая 10',
		'hours'         => 'Пн-Пт: 10.00-19.00, Сб: 10.00-15.00',
		'lead_email'    => 'kovrikievaby1@gmail.com',
		'tg_token'      => '',
		'tg_chat'       => '',
		'metrika'       => '79743688',
		'gads'          => 'AW-720698988',
		'ya_org'        => '213592712545',
		'video'         => '',
		'reviews_sc'    => '',
		'google_review' => '',
		'geo_lat'       => '53.8672',
		'geo_lng'       => '27.6531',
	];
}

function kv_opt($key) {
	$def = kv_defaults();
	$val = get_theme_mod('kv_' . $key, $def[$key] ?? '');
	return $val === '' && in_array($key, ['phone', 'phone_label', 'address'], true) ? $def[$key] : $val;
}

function kv_tel()   { return 'tel:' . preg_replace('/[^\d+]/', '', kv_opt('phone')); }
function kv_viber() { return 'viber://chat?number=' . rawurlencode(preg_replace('/[^\d+]/', '', kv_opt('viber'))); }
function kv_tg()    {
	$t = trim(kv_opt('telegram'));
	return $t === '' ? '' : 'https://t.me/' . ltrim(preg_replace('#^https?://t\.me/#', '', $t), '@');
}

add_action('customize_register', function ($wp) {
	$wp->add_section('kv_main', [
		'title'    => 'KovrikiEVA: контакты и интеграции',
		'priority' => 30,
	]);
	$fields = [
		'phone'       => 'Телефон (для ссылки), напр. +375447764764',
		'phone_label' => 'Телефон (как показывать)',
		'viber'       => 'Viber (номер)',
		'telegram'    => 'Telegram (номер или username)',
		'instagram'   => 'Instagram (ссылка)',
		'email'       => 'E-mail (показывается на сайте)',
		'address'     => 'Адрес',
		'hours'       => 'Время работы (через запятую)',
		'lead_email'  => 'E-mail для заявок',
		'tg_token'    => 'Telegram-бот: токен (заявки в Telegram)',
		'tg_chat'     => 'Telegram-бот: chat_id',
		'metrika'     => 'Яндекс.Метрика: номер счётчика',
		'gads'        => 'Google Ads / GA4 ID (AW-… или G-…)',
		'ya_org'      => 'ID организации в Яндекс.Картах (виджет отзывов)',
		'reviews_sc'    => 'Шорткод виджета отзывов (например [trustindex no-registration=...])',
		'google_review' => 'Ссылка «Оставить отзыв в Google»',
		'video'       => 'Видео 9:16 в первом экране ЭВА (ссылка Vimeo / YouTube / .mp4; пусто = видео из темы)',
		'geo_lat'     => 'Координаты: широта',
		'geo_lng'     => 'Координаты: долгота',
	];
	foreach ($fields as $key => $label) {
		$wp->add_setting('kv_' . $key, [
			'default'           => kv_defaults()[$key],
			'sanitize_callback' => $key === 'reviews_sc' ? 'wp_kses_post' : 'sanitize_text_field',
		]);
		$wp->add_control('kv_' . $key, [
			'label'   => $label,
			'section' => 'kv_main',
			'type'    => 'text',
		]);
	}
});

/** Видео первого экрана: из настроек или встроенное в тему. */
function kv_hero_video() {
	$v = trim(kv_opt('video'));
	return $v !== '' ? $v : KV_URI . '/assets/video/eva-kovriki.mp4';
}
