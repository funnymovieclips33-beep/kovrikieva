<?php
/** Характеристики материала + слайдер сравнения структур «Ромбы / Соты» (только ЭВА). */
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['textures'])) {
	return;
}
[$a, $b] = $d['textures'];
?>
<section class="kv-sec kv-tex">
	<div class="kv-wrap kv-tex__grid">
		<div class="kv-specs">
			<p class="kv-specs__title">Материал, который служит годами</p>
			<ul class="kv-specs__grid">
				<li><b>10–11<small> мм</small></b><span>толщина коврика</span></li>
				<li><b>7–8<small> мм</small></b><span>глубина ячеек — вода и грязь остаются внутри</span></li>
				<li><b>−70…+50<small>°C</small></b><span>не трескается и не дубеет</span></li>
				<li><b>300+</b><span>сочетаний цвета материала и окантовки</span></li>
			</ul>
			<button type="button" class="kv-btn kv-btn--light" data-modal="order" data-product="<?php echo esc_attr($d['short']); ?>">Подобрать цвет</button>
		</div>
		<div class="kv-compare" data-compare style="--pos:50%">
			<?php echo kv_img($b[1], 'Структура коврика ЭВА: ' . $b[0], 'kv-compare__img'); ?>
			<div class="kv-compare__top"><?php echo kv_img($a[1], 'Структура коврика ЭВА: ' . $a[0], 'kv-compare__img'); ?></div>
			<span class="kv-compare__label kv-compare__label--l"><?php echo esc_html($a[0]); ?></span>
			<span class="kv-compare__label kv-compare__label--r"><?php echo esc_html($b[0]); ?></span>
			<span class="kv-compare__handle" aria-hidden="true">⟷</span>
			<input type="range" min="0" max="100" value="50" aria-label="Сравнить структуры: <?php echo esc_attr($a[0] . ' и ' . $b[0]); ?>">
		</div>
	</div>
</section>
