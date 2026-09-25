<?php
/**
 * Фото выполненных работ: плитки с логотипами марок, по клику — просмотр фото в формате «сторис».
 */
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['gallery'])) {
	return;
}
$all = kv_data('gallery');
$g   = $all[$d['gallery']] ?? [];
if (!empty($d['gallery_only'])) {
	$g = array_intersect_key($g, [$d['gallery_only'] => 1]);
}
if (!$g) {
	return;
}
$logos = [
	'BMW' => 'cropped-bmw.webp', 'Maserati' => 'cropped-maserati-1.jpg', 'Mercedes-Benz' => 'cropped-mercedes-benz.jpg',
	'Acura' => 'acura.jpg', 'Renault' => 'Renault.jpg', 'Toyota' => 'toyota.jpg', 'Ford' => 'ford.jpg',
	'Chevrolet' => 'Chevrolet.jpg', 'Volkswagen' => 'Volkswagen-logo.jpg', 'Audi' => 'audi.jpg', 'Chrysler' => 'chrysler.jpg',
	'Honda' => 'honda.jpg', 'Peugeot' => 'peugeot.jpg', 'BYD' => 'byd.jpg', 'Zeekr' => 'zeekr.jpg', 'Geely' => 'geely.jpg',
	'Opel' => 'opel.jpg', 'Buick' => 'buick.jpg', 'Zotye' => 'zotye.jpg',
];
?>
<section class="kv-sec kv-gallery" id="gallery">
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line">Фото выполненных работ</h2>
		<p class="kv-gallery__sub">* Выберите марку авто, чтобы посмотреть фото</p>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<ul class="kv-brands">
			<?php foreach ($g as $brand => $imgs) : ?>
				<li>
					<button type="button" class="kv-brand" data-stories="<?php echo esc_attr(wp_json_encode(array_map('kv_upload', $imgs))); ?>" data-brand="<?php echo esc_attr($brand); ?>">
						<span class="kv-brand__logo" data-name="<?php echo esc_attr($brand); ?>"><img src="<?php echo esc_url(kv_upload('2024/02/' . ($logos[$brand] ?? sanitize_title($brand) . '.jpg'))); ?>" alt="<?php echo esc_attr($brand); ?>" loading="lazy" decoding="async"></span>
						<span class="kv-brand__name"><?php echo esc_html($brand); ?></span>
					</button>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="kv-gallery__more">
			<?php if (kv_opt('instagram')) : ?><a class="kv-btn" href="<?php echo esc_url(kv_opt('instagram')); ?>" target="_blank" rel="noopener">Больше фото в Instagram<?php echo kv_icon('instagram'); ?></a><?php endif; ?>
			<a class="kv-btn" href="<?php echo esc_url(home_url('/fotogalereya/')); ?>">Все фото</a>
		</div>
	</div>
</section>
