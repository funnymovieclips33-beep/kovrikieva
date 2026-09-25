<?php
/**
 * Преимущества — как на старом сайте: фон «соты», по центру фото в пунктирной рамке,
 * слева и справа пункты с иконками в кругах.
 */
defined('ABSPATH') || exit;
['key' => $key, 'd' => $d, 'city' => $city] = $args;
if (empty($d['advantages'])) {
	return;
}
$icons = $d['adv_icons'] ?? ['thermo', 'flask', 'trophy', 'drop', 'gears', 'puzzle'];
$items = $d['advantages'];
$half  = (int) ceil(count($items) / 2);
$cols  = [array_slice($items, 0, $half, true), array_slice($items, $half, null, true)];
?>
<section class="kv-sec kv-adv" id="advantages">
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line"><?php echo esc_html($d['adv_title']); ?></h2>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<div class="kv-adv__grid<?php echo empty($d['adv_img']) ? ' kv-adv__grid--noimg' : ''; ?>">
			<?php foreach ($cols as $ci => $col) : ?>
				<ul class="kv-adv__col kv-adv__col--<?php echo $ci ? 'right' : 'left'; ?>">
					<?php foreach ($col as $i => $a) : ?>
						<li class="kv-adv__item">
							<div class="kv-adv__head">
								<span class="kv-adv__icon"><?php echo kv_icon($icons[$i % count($icons)]); ?></span>
								<h3><?php echo esc_html($a[0]); ?></h3>
							</div>
							<p><?php echo esc_html($a[1]); ?></p>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php if ($ci === 0 && !empty($d['adv_img'])) : ?>
					<div class="kv-adv__img"><?php echo kv_img($d['adv_img'], $d['adv_title']); ?></div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php if (!empty($d['textures'])) : ?>
			<div class="kv-textures">
				<?php foreach ($d['textures'] as $t) : ?>
					<figure class="kv-texture"><?php echo kv_img($t[1], 'Структура коврика ЭВА: ' . $t[0]); ?><figcaption><?php echo esc_html($t[0]); ?></figcaption></figure>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
