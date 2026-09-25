<?php
/** Страница /otzyvy/: виджет отзывов Яндекс.Карт (грузится при прокрутке). */
defined('ABSPATH') || exit;
$org = preg_replace('/\D/', '', kv_opt('ya_org'));
if (!$org) {
	return;
}
?>
<div class="kv-reviews">
	<iframe class="kv-reviews__frame" title="Отзывы о KOVRIKIEVABY на Яндекс Картах" loading="lazy" src="https://yandex.ru/maps-reviews-widget/<?php echo esc_attr($org); ?>?comments"></iframe>
	<p><a href="https://yandex.by/maps/org/<?php echo esc_attr($org); ?>/reviews/" target="_blank" rel="noopener">Eva Коврики на карте Минска — Яндекс Карты</a></p>
	<button type="button" class="kv-btn kv-btn--lg" data-modal="order">Заказать коврики</button>
</div>
