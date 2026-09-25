<?php
/** Страница /zakazat/: выбор продукта + форма заказа. */
defined('ABSPATH') || exit;
$cat  = kv_catalog();
$opts = [];
foreach (['eva', 'vorsovye-kovriki', 'kovrik-v-bagazhnik', 'organajzer-v-bagazhnik', 'v-lodku', 'dlja-doma'] as $k) {
	$opts[] = kv_direction($k)['short'];
}
?>
<p class="kv-lead">Наша мастерская занимается пошивом ковриков для дома и авто. Используем профессиональное оборудование и только качественные сертифицированные материалы!</p>
<div class="kv-order">
	<div>
		<h2>Выберите продукт</h2>
		<div class="kv-cards kv-cards--sm">
			<?php foreach (['eva', 'vorsovye-kovriki', 'kovrik-v-bagazhnik', 'organajzer-v-bagazhnik', 'v-lodku', 'dlja-doma'] as $k) : [$t, $p, $img, $url] = $cat[$k]; ?>
				<article class="kv-card">
					<a class="kv-card__img" href="<?php echo esc_url($url); ?>" tabindex="-1"><?php echo kv_img($img, $t); ?></a>
					<div class="kv-card__body">
						<h3 class="kv-card__title"><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($t); ?></a></h3>
						<p class="kv-card__price"><?php echo esc_html(kv_price($p)); ?></p>
						<button type="button" class="kv-btn kv-btn--block" data-pick="<?php echo esc_attr(kv_direction($k)['short']); ?>">Выбрать</button>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
	<aside class="kv-order__form" id="order-form">
		<h2>Оформить заявку</h2>
		<?php echo kv_form(['form' => 'Страница «Заказать»', 'products' => $opts, 'full' => true, 'sizes' => true, 'btn' => 'Отправить заявку']); ?>
	</aside>
</div>
