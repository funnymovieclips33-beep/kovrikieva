<?php
defined('ABSPATH') || exit;
['key' => $key, 'd' => $d, 'city' => $city] = $args;
if (empty($d['advantages'])) {
	return;
}
$icons = ['shield', 'bolt', 'star', 'check', 'palette', 'truck'];
?>
<section class="kv-sec kv-adv" id="advantages">
	<div class="kv-wrap">
		<h2 class="kv-h2"><?php echo esc_html($d['adv_title']); ?></h2>
		<div class="kv-adv__grid<?php echo !empty($d['adv_img']) ? ' kv-adv__grid--img' : ''; ?>">
			<ul class="kv-adv__list">
				<?php foreach ($d['advantages'] as $i => $a) : ?>
					<li class="kv-adv__item">
						<span class="kv-adv__icon"><?php echo kv_icon($icons[$i % count($icons)]); ?></span>
						<h3><?php echo esc_html($a[0]); ?></h3>
						<p><?php echo esc_html($a[1]); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php if (!empty($d['adv_img'])) : ?>
				<div class="kv-adv__img"><?php echo kv_img($d['adv_img'], $d['adv_title']); ?></div>
			<?php endif; ?>
		</div>
		<?php if (!empty($d['textures'])) : ?>
			<div class="kv-textures">
				<p class="kv-textures__title">Две структуры материала на выбор:</p>
				<?php foreach ($d['textures'] as $t) : ?>
					<figure class="kv-texture"><?php echo kv_img($t[1], 'Структура коврика ЭВА: ' . $t[0]); ?><figcaption><?php echo esc_html($t[0]); ?></figcaption></figure>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
