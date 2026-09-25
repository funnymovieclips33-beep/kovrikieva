<?php
defined('ABSPATH') || exit;
['key' => $key, 'd' => $d, 'city' => $city] = $args;
$h1 = $city && !empty($d['h1_city']) ? kv_tpl($d['h1_city'], $city) : $d['h1'];
?>
<section class="kv-hero">
	<div class="kv-wrap kv-hero__grid">
		<div class="kv-hero__text">
			<?php echo kv_breadcrumbs(); ?>
			<button type="button" class="kv-citychip" data-modal="cities" aria-label="Выбрать город">
				<?php echo kv_icon('pin'); ?><span><?php echo esc_html(kv_city_name($city)); ?></span><?php echo kv_icon('chevron'); ?>
			</button>
			<h1 class="kv-hero__title"><?php echo esc_html($h1); ?></h1>
			<p class="kv-hero__lead"><?php echo wp_kses_post(kv_tpl($d['lead'], $city)); ?></p>

			<div class="kv-hero__price">
				<span class="kv-hero__from">от <b><?php echo (int) $d['price_from']; ?></b> руб.</span>
				<span class="kv-hero__note"><?php echo esc_html($d['price_note']); ?></span>
			</div>

			<div class="kv-hero__cta">
				<button type="button" class="kv-btn kv-btn--lg" data-modal="order" data-product="<?php echo esc_attr($d['short']); ?>"><?php echo esc_html($d['cta']); ?></button>
				<a class="kv-btn kv-btn--lg kv-btn--viber" href="<?php echo esc_attr(kv_viber()); ?>" data-goal="viber"><?php echo kv_icon('viber'); ?>Спросить в Viber</a>
			</div>

			<ul class="kv-trust">
				<?php if (empty($d['remote'])) : ?>
					<li><?php echo kv_icon('bolt'); ?>Изготовление за 24 часа</li>
					<li><?php echo kv_icon('gift'); ?>Логотип в подарок</li>
				<?php else : ?>
					<li><?php echo kv_icon('bolt'); ?>Изготовление 1–2 дня</li>
					<li><?php echo kv_icon('palette'); ?>Большой выбор цветов</li>
				<?php endif; ?>
				<li><?php echo kv_icon('truck'); ?><?php echo $city ? 'Доставка ' . esc_html(kv_city_in($city)) . ' 1–3 дня' : 'Доставка по РБ 1–3 дня'; ?></li>
				<li><?php echo kv_icon('shield'); ?>Оплата по факту</li>
			</ul>
		</div>

		<div class="kv-hero__media">
			<div class="kv-hero__img">
				<?php echo kv_img($d['hero_img'], $h1, '', true); ?>
				<?php if ($key === 'eva' && kv_opt('video')) : ?>
					<button type="button" class="kv-play" data-video="<?php echo esc_attr(kv_opt('video')); ?>" aria-label="Смотреть видео"><?php echo kv_icon('play'); ?></button>
				<?php endif; ?>
			</div>
			<?php if (!empty($d['hero_thumbs'])) : ?>
				<div class="kv-hero__thumbs" data-gallery-group>
					<?php foreach ($d['hero_thumbs'] as $i => $t) : ?>
						<a href="<?php echo esc_url(kv_upload($t)); ?>" data-lightbox><?php echo kv_img($t, $d['product'] . ' — фото ' . ($i + 1)); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
