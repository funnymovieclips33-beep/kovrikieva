<?php
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['gallery'])) {
	return;
}
$all = kv_data('gallery');
$g   = $all[$d['gallery']] ?? [];
if (!$g) {
	return;
}
$first = array_key_first($g);
?>
<section class="kv-sec kv-gallery" id="gallery">
	<div class="kv-wrap">
		<h2 class="kv-h2">Фото выполненных работ</h2>
		<p class="kv-muted kv-center">Выберите марку авто, чтобы посмотреть фото</p>
		<div class="kv-tabs" role="tablist">
			<?php foreach ($g as $brand => $imgs) : ?>
				<button type="button" role="tab" class="kv-tab" aria-selected="<?php echo $brand === $first ? 'true' : 'false'; ?>" data-tab="<?php echo esc_attr(sanitize_title($brand)); ?>"><?php echo esc_html($brand); ?></button>
			<?php endforeach; ?>
		</div>
		<?php foreach ($g as $brand => $imgs) : $id = sanitize_title($brand); ?>
			<?php if ($brand === $first) : ?>
				<div class="kv-photos" data-panel="<?php echo esc_attr($id); ?>" data-gallery-group>
					<?php foreach ($imgs as $i => $src) : ?>
						<a href="<?php echo esc_url(kv_upload($src)); ?>" data-lightbox><?php echo kv_img($src, 'Коврики для ' . $brand . ' — фото ' . ($i + 1)); ?></a>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<template data-panel-tpl="<?php echo esc_attr($id); ?>">
					<?php foreach ($imgs as $i => $src) : ?>
						<a href="<?php echo esc_url(kv_upload($src)); ?>" data-lightbox><?php echo kv_img($src, 'Коврики для ' . $brand . ' — фото ' . ($i + 1)); ?></a>
					<?php endforeach; ?>
				</template>
			<?php endif; ?>
		<?php endforeach; ?>
		<div class="kv-center kv-gallery__more">
			<?php if (kv_opt('instagram')) : ?><a class="kv-btn kv-btn--ghost" href="<?php echo esc_url(kv_opt('instagram')); ?>" target="_blank" rel="noopener"><?php echo kv_icon('instagram'); ?>Больше фото в Instagram</a><?php endif; ?>
			<a class="kv-btn kv-btn--ghost" href="<?php echo esc_url(home_url('/fotogalereya/')); ?>">Все фото</a>
		</div>
	</div>
</section>
