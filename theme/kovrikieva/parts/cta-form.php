<?php
defined('ABSPATH') || exit;
['key' => $key, 'd' => $d, 'city' => $city] = $args;
?>
<section class="kv-sec kv-ctaform" id="order">
	<div class="kv-wrap kv-ctaform__grid">
		<div class="kv-ctaform__text">
			<h2 class="kv-h2 kv-h2--left kv-h2--light">Рассчитаем стоимость за 5 минут</h2>
			<p>Оставьте телефон — подберём материал и цвет, назовём точную цену <?php echo empty($d['remote']) ? 'для вашего авто' : 'вашего заказа'; ?>. Без предоплаты.</p>
			<ul class="kv-ctaform__list">
				<li><?php echo kv_icon('check'); ?><?php echo empty($d['remote']) ? 'Более 2000 лекал автомобилей в базе' : 'Изготовим по вашим размерам'; ?></li>
				<li><?php echo kv_icon('check'); ?>Более 300 цветовых сочетаний</li>
				<li><?php echo kv_icon('check'); ?>Доставка Европочтой <?php echo $city ? esc_html(kv_city_in($city)) : 'по всей РБ'; ?> — 1–3 дня</li>
			</ul>
		</div>
		<div class="kv-ctaform__box">
			<?php
			echo kv_form([
				'form'     => 'Расчёт стоимости — ' . $d['short'],
				'products' => $d['order_options'] ?? [],
				'full'     => empty($d['remote']),
				'sizes'    => !empty($d['size_fields']),
				'btn'      => 'Рассчитать стоимость',
			]);
			?>
		</div>
	</div>
</section>
