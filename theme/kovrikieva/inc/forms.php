<?php
/**
 * Заявки: REST-эндпоинт /wp-json/kv/v1/lead
 *  - сохраняются в админке (раздел «Заявки») — ни одна заявка не потеряется, даже если почта не дошла;
 *  - отправляются на e-mail и (опционально) в Telegram-бот;
 *  - защита от спама: honeypot + минимальное время заполнения, без капчи (не мешает конверсии).
 */
defined('ABSPATH') || exit;

add_action('init', function () {
	register_post_type('kv_lead', [
		'labels'          => [
			'name'          => 'Заявки',
			'singular_name' => 'Заявка',
			'menu_name'     => 'Заявки',
		],
		'public'          => false,
		'show_ui'         => true,
		'menu_icon'       => 'dashicons-phone',
		'menu_position'   => 3,
		'supports'        => ['title', 'editor'],
		'capability_type' => 'post',
		'capabilities'    => ['create_posts' => 'do_not_allow'],
		'map_meta_cap'    => true,
	]);
});

add_action('rest_api_init', function () {
	register_rest_route('kv/v1', '/lead', [
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => 'kv_handle_lead',
	]);
});

function kv_handle_lead(WP_REST_Request $r) {
	$p = $r->get_params();

	// Антиспам.
	if (!empty($p['website']) || (isset($p['t']) && (time() - (int) $p['t'] / 1000) < 3)) {
		return new WP_REST_Response(['ok' => true], 200); // тихо игнорируем бота
	}

	$fields = [
		'name'    => 'Имя',
		'phone'   => 'Телефон',
		'city'    => 'Город',
		'form'    => 'Форма',
		'product' => 'Товар',
		'car'     => 'Авто',
		'material'=> 'Материал',
		'color'   => 'Цвет материала',
		'edge'    => 'Цвет окантовки',
		'heel'    => 'Подпятник',
		'size'    => 'Размеры',
		'comment' => 'Комментарий',
		'page'    => 'Страница',
		'utm'     => 'UTM',
	];
	$data = [];
	foreach ($fields as $k => $label) {
		if (isset($p[$k]) && trim((string) $p[$k]) !== '') {
			$data[$k] = sanitize_textarea_field(wp_unslash((string) $p[$k]));
		}
	}

	$digits = preg_replace('/\D/', '', $data['phone'] ?? '');
	if (strlen($digits) < 9) {
		return new WP_REST_Response(['ok' => false, 'error' => 'Укажите корректный номер телефона'], 422);
	}

	// Ограничение частоты: не больше 5 заявок в 10 минут с одного IP.
	$ip  = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
	$key = 'kv_rl_' . md5($ip);
	$cnt = (int) get_transient($key);
	if ($cnt >= 5) {
		return new WP_REST_Response(['ok' => false, 'error' => 'Слишком много заявок. Позвоните нам, пожалуйста.'], 429);
	}
	set_transient($key, $cnt + 1, 10 * MINUTE_IN_SECONDS);

	$lines = [];
	foreach ($data as $k => $v) {
		$lines[] = $fields[$k] . ': ' . $v;
	}
	$body  = implode("\n", $lines);
	$title = 'Заявка: ' . ($data['product'] ?? $data['form'] ?? 'сайт') . ' — ' . ($data['phone'] ?? '');

	wp_insert_post([
		'post_type'    => 'kv_lead',
		'post_status'  => 'private',
		'post_title'   => $title,
		'post_content' => $body,
	]);

	$to = kv_opt('lead_email');
	if ($to) {
		wp_mail($to, '[kovrikieva.by] ' . $title, $body);
	}

	$token = trim(kv_opt('tg_token'));
	$chat  = trim(kv_opt('tg_chat'));
	if ($token && $chat) {
		wp_remote_post('https://api.telegram.org/bot' . $token . '/sendMessage', [
			'timeout'  => 5,
			'blocking' => false,
			'body'     => ['chat_id' => $chat, 'text' => "🟢 " . $title . "\n\n" . $body],
		]);
	}

	return new WP_REST_Response(['ok' => true], 200);
}

/**
 * Универсальная форма заявки.
 * $o: form (название формы), products (варианты), dir (ключ направления), full (расширенная форма), btn.
 */
function kv_form($o = []) {
	$o = wp_parse_args($o, [
		'form'     => 'Заявка',
		'products' => [],
		'full'     => false,
		'btn'      => 'Отправить заявку',
		'dir'      => '',
		'sizes'    => false,
		'city'     => kv_ctx() && kv_ctx()['city'] ? kv_city_name(kv_ctx()['city']) : '',
	]);
	ob_start();
	?>
	<form class="kv-form" data-kv-form novalidate>
		<input type="hidden" name="form" value="<?php echo esc_attr($o['form']); ?>">
		<input type="hidden" name="t" value="">
		<div class="kv-hp" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
		<?php if ($o['products']) : ?>
			<label class="kv-field"><span>Что заказать</span>
				<select name="product">
					<?php foreach ($o['products'] as $p) : ?>
						<option><?php echo esc_html($p); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		<?php endif; ?>
		<?php if ($o['full']) : ?>
			<label class="kv-field"><span>Марка, модель, год авто</span><input type="text" name="car" placeholder="Например, Toyota Camry 2020"></label>
		<?php endif; ?>
		<?php if ($o['sizes']) : ?>
			<label class="kv-field"><span>Размеры / пожелания</span><input type="text" name="size" placeholder="Длина × ширина, см"></label>
		<?php endif; ?>
		<label class="kv-field"><span>Ваше имя</span><input type="text" name="name" autocomplete="given-name" placeholder="Имя"></label>
		<label class="kv-field"><span>Телефон *</span><input type="tel" name="phone" autocomplete="tel" inputmode="tel" placeholder="+375 (__) ___-__-__" required></label>
		<?php if ($o['full']) : ?>
			<label class="kv-field"><span>Ваш город</span><input type="text" name="city" value="<?php echo esc_attr($o['city']); ?>" placeholder="Город"></label>
		<?php endif; ?>
		<button class="kv-btn kv-btn--block" type="submit"><?php echo esc_html($o['btn']); ?></button>
		<p class="kv-form__note">Нажимая на кнопку, я даю согласие на обработку <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">персональных данных</a></p>
		<div class="kv-form__msg" role="status" aria-live="polite"></div>
	</form>
	<?php
	return ob_get_clean();
}
