<?php
/** Страница марки: два вида ковриков + популярные модели. */
defined('ABSPATH') || exit;
['b' => $b, 'slug' => $slug] = $args;
$eva  = kv_direction('eva');
$vors = kv_direction('vorsovye-kovriki');
$name = $b[0];
?>
<section class="kv-sec kv-sota kv-btypes">
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line">Какие коврики для <?php echo esc_html($name); ?> мы делаем</h2>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<div class="kv-btypes__grid">
			<?php foreach ([[$eva, 'eva', 'Не боятся воды, снега и грязи — всё остаётся в ячейках. Моются струёй воды за минуту.'], [$vors, 'vorsovye-kovriki', 'Уютные, тихие, премиальный вид. Антискользящая основа, 3 класса материала.']] as [$dd, $k, $txt]) : ?>
				<article class="kv-box kv-btype">
					<div class="kv-btype__img"><?php echo kv_img($dd['hero_img'], $dd['short'] . ' для ' . $name); ?></div>
					<div>
						<h3><?php echo esc_html($dd['short'] . ' для ' . $name); ?></h3>
						<p><?php echo esc_html($txt); ?></p>
						<p class="kv-btype__price">от <?php echo (int) $dd['price_from']; ?> руб.</p>
						<div class="kv-btype__cta">
							<button type="button" class="kv-btn" data-modal="order" data-product="<?php echo esc_attr($dd['short'] . ' для ' . $name); ?>">Заказать</button>
							<a class="kv-link-more" href="<?php echo esc_url(kv_url($k)); ?>">Подробнее →</a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<p class="kv-models__title">Изготавливаем коврики для моделей <?php echo esc_html($name); ?>:</p>
		<ul class="kv-models">
			<?php foreach ($b[2] as $m) : ?>
				<li><button type="button" data-modal="order" data-product="<?php echo esc_attr('Коврики для ' . $name . ' ' . $m); ?>"><?php echo esc_html($name . ' ' . $m); ?></button></li>
			<?php endforeach; ?>
			<li><button type="button" data-modal="order" data-product="<?php echo esc_attr('Коврики для ' . $name . ' (другая модель)'); ?>">Другая модель?</button></li>
		</ul>
	</div>
</section>
