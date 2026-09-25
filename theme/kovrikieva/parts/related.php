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
		<h2 class="kv-h2">Сопутствующие товары</h2>
		<div class="kv-cards kv-cards--sm">
			<?php foreach ($d['related'] as $k) : if (empty($cat[$k])) { continue; } [$t, $p, $img, $url] = $cat[$k]; ?>
				<article class="kv-card">
					<a class="kv-card__img" href="<?php echo esc_url($url); ?>" tabindex="-1"><?php echo kv_img($img, $t); ?></a>
					<div class="kv-card__body">
						<h3 class="kv-card__title"><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($t); ?></a></h3>
						<p class="kv-card__price"><?php echo esc_html(kv_price($p)); ?></p>
						<a class="kv-card__more" href="<?php echo esc_url($url); ?>">Подробнее <?php echo kv_icon('arrow'); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
