<?php
defined('ABSPATH') || exit;
['key' => $key, 'd' => $d, 'city' => $city] = $args;
$h1 = $city && !empty($d['h1_city']) ? kv_tpl($d['h1_city'], $city) : $d['h1'];
?>
<section class="kv-hero">
	<div class="kv-wrap kv-hero__grid">
		<div class="kv-hero__text">
			<?php echo kv_breadcrumbs(); ?>
			<h1 class="kv-hero__title"><?php echo esc_html($h1); ?></h1>
			<p class="kv-hero__lead"><?php echo wp_kses_post(kv_tpl($d['lead'], $city)); ?></p>

			<div class="kv-hero__price">
				<span class="kv-hero__from">от <?php echo (int) $d['price_from']; ?> руб.</span>
				<span class="kv-hero__note"><?php echo esc_html($d['price_note']); ?></span>
			</div>

			<?php if (!empty($d['gift_note'])) : ?>
				<p class="kv-gift"><span class="kv-gift__ic"><?php echo kv_icon('gift'); ?></span><span><b>Логотип в подарок</b><?php echo esc_html($d['gift_note']); ?></span></p>
			<?php endif; ?>

			<div class="kv-hero__cta">
				<button type="button" class="kv-btn kv-btn--lg" data-modal="order" data-product="<?php echo esc_attr($d['short']); ?>"><?php echo esc_html($d['cta']); ?><?php echo kv_icon('gift'); ?></button>
			</div>

		</div>

		<div class="kv-hero__media">
			<div class="kv-hero__img">
				<?php echo kv_img($d['hero_img'], $h1, '', true); ?>
				<?php if ($key === 'eva' && kv_opt('video')) : ?>
					<button type="button" class="kv-play" data-video="<?php echo esc_attr(kv_opt('video')); ?>" aria-label="Смотреть видео"><?php echo kv_icon('play'); ?></button>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>
			<?php if (!empty($d['hero_thumbs'])) : ?>
				<div class="kv-wrap kv-thumbs" data-gallery-group>
					<?php foreach ($d['hero_thumbs'] as $i => $t) : ?>
						<a href="<?php echo esc_url(kv_upload($t)); ?>" data-lightbox><?php echo kv_img($t, $d['product'] . ' — фото ' . ($i + 1)); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

