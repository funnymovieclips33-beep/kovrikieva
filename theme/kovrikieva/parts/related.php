<?php
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['related'])) {
	return;
}
$cat = kv_catalog();
?>
<section class="kv-sec kv-related">
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line">Сопутствующие товары</h2>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<p class="kvp-hint"><span>i</span>Нажмите или наведите на карточку товара, чтобы узнать стоимость и сделать заказ</p>
		<div class="kvp-grid">
			<?php foreach ($d['related'] as $k) : if (empty($cat[$k])) { continue; } [$t, $p, $img, $url] = $cat[$k]; ?>
				<article class="kvp kvp--photo" tabindex="0">
					<?php echo kv_img($img, $t); ?>
					<div class="kvp__ov">
						<h3 class="kvp__title"><?php echo esc_html($t); ?></h3>
						<p class="kvp__price"><?php echo esc_html(kv_price($p)); ?></p>
						<button type="button" class="kvp__btn" data-modal="order" data-product="<?php echo esc_attr($t); ?>">Заказать</button>
						<a class="kvp__more" href="<?php echo esc_url($url); ?>">Подробнее →</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
