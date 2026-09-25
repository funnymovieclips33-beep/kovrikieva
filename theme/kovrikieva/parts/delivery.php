<?php
/**
 * Доставка по РБ + ссылки на города. Для направлений с городами — ссылки на страницы этого направления
 * (перелинковка новых городских страниц), для остальных — на города ЭВА (как на старом сайте).
 */
defined('ABSPATH') || exit;
['key' => $key, 'd' => $d, 'city' => $city] = $args;
$link_dir = !empty($d['cities']) ? $key : 'eva';
$c        = $city ? kv_city($city) : null;
$cities   = kv_cities();
// На городской странице первыми показываем города той же области.
if ($c) {
	uksort($cities, function ($a, $b) use ($cities, $c) {
		return ($cities[$b][2] === $c[2]) <=> ($cities[$a][2] === $c[2]);
	});
}
?>
<section class="kv-sec kv-sec--alt kv-delivery" id="delivery">
	<div class="kv-wrap">
		<h2 class="kv-h2"><?php echo esc_html($d['delivery_title'] ?? 'Доставка по РБ'); ?></h2>
		<div class="kv-delivery__grid">
			<div class="kv-content">
				<p>Мы осуществляем доставку по всей территории Республики Беларусь через «Европочту». Это удобно, быстро и надёжно: короткие сроки доставки, отсутствие очередей и всегда вежливый персонал.</p>
				<ul class="kv-checks">
					<li>Срок доставки — от 1 до 3 дней</li>
					<li>Оплата при получении</li>
					<li>Самовывоз: <?php echo esc_html(kv_opt('address')); ?></li>
				</ul>
			</div>
			<div class="kv-delivery__map"><?php echo kv_img('2024/12/karta-belarusi.jpg', 'Карта доставки по Беларуси'); ?></div>
		</div>
		<p class="kv-center"><button type="button" class="kv-btn kv-btn--ghost" data-modal="cities">Выбрать свой город</button></p>
		<ul class="kv-citylinks">
			<?php if ($city) : ?>
				<li><a href="<?php echo esc_url(kv_url($link_dir)); ?>">Минск</a></li>
			<?php endif; ?>
			<?php foreach ($cities as $slug => $ci) : if ($slug === $city) { continue; } ?>
				<li><a href="<?php echo esc_url(kv_url($link_dir, $slug)); ?>"><?php echo esc_html($ci[0]); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
