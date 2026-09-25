<?php
/**
 * Конструктор коврика ЭВА: фактура, цвет материала, цвет канта, подпятник.
 * Живое SVG-превью, выбор передаётся в форму заказа.
 */
defined('ABSPATH') || exit;
['d' => $d] = $args;
$city = $args['city'] ?? null;
if (empty($d['constructor'])) {
	return;
}
$mat = [
	'Черный' => '#1d1d1f', 'Серый' => '#6f7174', 'Белый' => '#e8e8e4', 'Бежевый' => '#cdb892', 'Коричневый' => '#5c3b25',
	'Красный' => '#b3212b', 'Бордовый' => '#6e2030', 'Синий' => '#2256a8', 'Темно-синий' => '#1c2b4c', 'Фиолетовый' => '#5d3189',
	'Темно-зеленый' => '#1f4a34', 'Салатовый' => '#80bf3b', 'Желтый' => '#e7bb1f', 'Оранжевый' => '#e3701f',
];
$kant = [
	'Черный' => '#161616', 'Серый' => '#8a8c8f', 'Темно-серый' => '#3b3c3f', 'Белый' => '#f4f4f2', 'Бежевый' => '#d2bd98',
	'Коричневый' => '#5c3b25', 'Розовый' => '#e583a9', 'Красный' => '#c8232d', 'Бордовый' => '#74202f', 'Синий' => '#2459b0',
	'Темно-синий' => '#1c2b4c', 'Фиолетовый' => '#63358f', 'Темно-зеленый' => '#1f4a34', 'Салатовый' => '#86c43e',
	'Желтый' => '#ecc022', 'Оранжевый' => '#e8741f', 'Изумрудный' => '#0f8b6b',
];
$heels = ['none' => 'Без подпятника', 'poly' => 'Полимерный (+15 р.)', 'metal' => 'Металлический (+20 р.)'];
$swatches = function ($set, $type, $sel) {
	foreach ($set as $name => $hex) {
		printf(
			'<button type="button" class="kvc-sw%s" data-kvc="%s" data-name="%s" data-hex="%s" style="--c:%s" aria-label="%s" aria-pressed="%s"><span></span></button>',
			$name === $sel ? ' is-on' : '', $type, esc_attr($name), esc_attr($hex), esc_attr($hex), esc_attr($name), $name === $sel ? 'true' : 'false'
		);
	}
};
?>
<section class="kv-sec kv-sec--alt kvc" id="constructor" data-kvc-root>
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line"><?php echo esc_html($d['prices']['title'] . ($city ? ' ' . kv_city_in($city) : '')); ?></h2>
		<p class="kv-gallery__sub">Соберите свой коврик: выберите комплект, фактуру и цвета — цена посчитается сразу</p>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>

		<div class="kvc__grid">
			<div class="kvc__stage">
				<svg class="kvc__svg" viewBox="0 0 320 400" role="img" aria-label="Предпросмотр коврика ЭВА" style="--mat:#1d1d1f;--kant:#c8232d">
					<defs>
						<pattern id="kvc-honey" width="10.74" height="18.60" patternUnits="userSpaceOnUse"><polygon points="9.61,3.75 9.61,8.65 5.37,11.10 1.13,8.65 1.13,3.75 5.37,1.30" class="kvc-cell"/><polygon points="8.66,5.20 8.66,9.00 5.37,10.90 2.08,9.00 2.08,5.20 5.37,3.30" class="kvc-cell-in"/><polygon points="4.24,13.05 4.24,17.95 0.00,20.40 -4.24,17.95 -4.24,13.05 -0.00,10.60" class="kvc-cell"/><polygon points="3.29,14.50 3.29,18.30 0.00,20.20 -3.29,18.30 -3.29,14.50 -0.00,12.60" class="kvc-cell-in"/><polygon points="14.98,13.05 14.98,17.95 10.74,20.40 6.50,17.95 6.50,13.05 10.74,10.60" class="kvc-cell"/><polygon points="14.03,14.50 14.03,18.30 10.74,20.20 7.45,18.30 7.45,14.50 10.74,12.60" class="kvc-cell-in"/></pattern> <pattern id="kvc-dia" width="13" height="13" patternUnits="userSpaceOnUse"><polygon points="6.5,1.3 11.7,6.5 6.5,11.7 1.3,6.5" class="kvc-cell"/><polygon points="6.5,3 10,7.1 6.5,10.6 3,7.1" class="kvc-cell-in"/></pattern>
						<clipPath id="kvc-clip"><path id="kvc-shape" d="M58 22 L238 14 Q274 12 282 46 L300 318 Q304 372 258 380 L74 388 Q30 390 26 346 L20 132 Q18 102 36 82 L46 40 Q50 24 58 22 Z"/></clipPath>
						<linearGradient id="kvc-light" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#fff" stop-opacity=".22"/><stop offset=".45" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#000" stop-opacity=".28"/></linearGradient>
						<linearGradient id="kvc-metal" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#f2f2f2"/><stop offset=".5" stop-color="#a9adb2"/><stop offset="1" stop-color="#e3e5e8"/></linearGradient>
						<filter id="kvc-shadow" x="-20%" y="-20%" width="140%" height="140%"><feDropShadow dx="0" dy="14" stdDeviation="12" flood-opacity=".35"/></filter>
					</defs>
					<g filter="url(#kvc-shadow)">
						<use href="#kvc-shape" class="kvc-base"/>
					</g>
					<g clip-path="url(#kvc-clip)">
						<rect width="320" height="400" class="kvc-base"/>
						<rect width="320" height="400" fill="url(#kvc-honey)" class="kvc-tex kvc-tex--honey"/>
						<rect width="320" height="400" fill="url(#kvc-dia)" class="kvc-tex kvc-tex--dia"/>
						<rect width="320" height="400" fill="url(#kvc-light)"/>
					</g>
					<use href="#kvc-shape" class="kvc-kant"/>
					<use href="#kvc-shape" class="kvc-stitch"/>
					<g class="kvc-heel kvc-heel--poly"><rect x="186" y="262" width="78" height="92" rx="10" fill="#141414"/><g fill="#2a2a2a"><?php for ($y = 272; $y < 346; $y += 12) { for ($x = 196; $x < 258; $x += 12) { echo '<rect x="' . $x . '" y="' . $y . '" width="7" height="7" rx="1.5"/>'; } } ?></g></g>
					<g class="kvc-heel kvc-heel--metal"><rect x="186" y="262" width="78" height="92" rx="6" fill="url(#kvc-metal)" stroke="#8d9196"/><g fill="#7c8086"><?php for ($y = 274; $y < 348; $y += 11) { for ($x = 196; $x < 258; $x += 11) { echo '<circle cx="' . $x . '" cy="' . $y . '" r="2.2"/>'; } } ?></g></g>
					<g class="kvc-logo"><rect x="60" y="322" width="64" height="30" rx="5" fill="url(#kvc-metal)" stroke="#8d9196"/><text x="92" y="342" text-anchor="middle" font-size="12" font-weight="800" fill="#555" font-family="Arial">LOGO</text></g>
				</svg>
				<p class="kvc__note">Изображение условное: реальные оттенки могут немного отличаться. Логотип марки авто — в подарок при заказе комплекта.</p>
			</div>

			<div class="kvc__panel">
				<div class="kvc__step">
					<p class="kvc__label"><span>1</span>Что изготовить</p>
					<div class="kvc__sets">
						<?php foreach ($d['prices']['items'] as $i => $it) : ?>
							<button type="button" class="kvc-set<?php echo $i === 4 ? ' is-on' : ''; ?>" data-kvc="set" data-name="<?php echo esc_attr($it[0]); ?>" data-price="<?php echo (int) $it[1]; ?>" data-gift="<?php echo empty($it[3]) ? '0' : '1'; ?>" aria-pressed="<?php echo $i === 4 ? 'true' : 'false'; ?>">
								<?php echo kv_img($it[2], $it[0], 'kvc-set__img'); ?>
								<span class="kvc-set__name"><?php echo esc_html($it[0]); ?></span>
								<span class="kvc-set__price">от <?php echo (int) $it[1]; ?> р.</span>
								<?php if (!empty($it[3])) : ?><span class="kvc-set__gift"><?php echo kv_icon('gift'); ?>логотип в подарок</span><?php endif; ?>
							</button>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="kvc__step">
					<p class="kvc__label"><span>2</span>Фактура</p>
					<div class="kvc__tex">
						<button type="button" class="kvc-texbtn is-on" data-kvc="tex" data-name="Соты" data-val="honey" aria-pressed="true"><svg viewBox="0 0 150 40"><rect width="150" height="40" fill="#6f7174"/><rect width="150" height="40" fill="url(#kvc-honey)"/></svg>Соты</button>
						<button type="button" class="kvc-texbtn" data-kvc="tex" data-name="Ромбы" data-val="dia" aria-pressed="false"><svg viewBox="0 0 150 40"><rect width="150" height="40" fill="#6f7174"/><rect width="150" height="40" fill="url(#kvc-dia)"/></svg>Ромбы</button>
					</div>
				</div>
				<div class="kvc__step">
					<p class="kvc__label"><span>3</span>Цвет материала: <b data-kvc-out="mat">Черный</b></p>
					<div class="kvc__sws"><?php $swatches($mat, 'mat', 'Черный'); ?></div>
				</div>
				<div class="kvc__step">
					<p class="kvc__label"><span>4</span>Цвет канта: <b data-kvc-out="kant">Красный</b></p>
					<div class="kvc__sws"><?php $swatches($kant, 'kant', 'Красный'); ?></div>
				</div>
				<div class="kvc__step">
					<p class="kvc__label"><span>5</span>Подпятник</p>
					<div class="kvc__chips">
						<?php $i = 0; foreach ($heels as $k => [$label, $add]) : ?>
							<button type="button" class="kvc-chip<?php echo $i === 1 ? ' is-on' : ''; ?>" data-kvc="heel" data-val="<?php echo esc_attr($k); ?>" data-name="<?php echo esc_attr($label); ?>" data-price="<?php echo (int) $add; ?>" aria-pressed="<?php echo $i++ === 1 ? 'true' : 'false'; ?>"><?php echo esc_html($label); ?></button>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="kvc__total">
					<span>Итого:</span>
					<b>от <span data-kvc-total>155</span> руб.</b>
					<em data-kvc-gift>+ логотип марки авто в подарок</em>
				</div>
				<button type="button" class="kv-btn kv-btn--lg kv-btn--block kvc__cta" data-modal="order" data-kvc-cta data-product="Коврики ЭВА">Заказать в этих цветах</button>
			</div>
		</div>
	</div>
</section>
