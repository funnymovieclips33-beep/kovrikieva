<?php
/** Доставка по РБ: текст + карта слева, города справа (перелинковка). */
defined('ABSPATH') || exit;
['key' => $key, 'd' => $d, 'city' => $city] = $args;
$link_dir = !empty($d['cities']) ? $key : 'eva';
$c        = $city ? kv_city($city) : null;
$cities   = kv_cities();
if ($c) {
	uksort($cities, function ($a, $b) use ($cities, $c) {
		return ($cities[$b][2] === $c[2]) <=> ($cities[$a][2] === $c[2]);
	});
}
?>
<section class="kv-sec kv-sota kv-delivery" id="delivery">
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line"><?php echo esc_html($d['delivery_title'] ?? 'Доставка по РБ'); ?></h2>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<div class="kv-delivery__grid">
			<div class="kv-box">
				<p>Мы осуществляем доставку по всей территории Республики Беларусь через <b>«Европочту»</b>. Это удобно, быстро и надёжно: <b>короткие сроки доставки, отсутствие очередей и всегда вежливый персонал.</b></p>
				<div class="kv-delivery__map"><?php echo kv_img('2024/12/karta-belarusi.jpg', 'Карта доставки ковриков по Беларуси'); ?></div>
			</div>
			<div class="kv-box">
				<ul class="kv-citylinks">
					<?php if ($city) : ?><li><a href="<?php echo esc_url(kv_url($link_dir)); ?>">Минск</a></li><?php endif; ?>
					<?php foreach ($cities as $slug => $ci) : if ($slug === $city) { continue; } ?>
						<li><a href="<?php echo esc_url(kv_url($link_dir, $slug)); ?>"><?php echo esc_html($ci[0]); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
