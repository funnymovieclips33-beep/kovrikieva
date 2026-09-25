<?php
defined('ABSPATH') || exit;
$lat = kv_opt('geo_lat');
$lng = kv_opt('geo_lng');
$map = 'https://yandex.ru/map-widget/v1/?ll=' . rawurlencode($lng . ',' . $lat) . '&z=16&pt=' . rawurlencode($lng . ',' . $lat) . ',pm2rdm';
?>
<section class="kv-sec kv-contacts" id="contacts">
	<div class="kv-wrap kv-contacts__grid">
		<div>
			<h2 class="kv-h2 kv-h2--left">Контактная информация</h2>
			<ul class="kv-contacts__list">
				<li><?php echo kv_icon('pin'); ?><?php echo esc_html(kv_opt('address')); ?></li>
				<li><?php echo kv_icon('clock'); ?><?php echo esc_html(kv_opt('hours')); ?></li>
				<li><?php echo kv_icon('phone'); ?><a href="<?php echo esc_attr(kv_tel()); ?>" data-goal="call"><?php echo esc_html(kv_opt('phone_label')); ?></a></li>
			</ul>
			<div class="kv-hero__cta">
				<a class="kv-btn kv-btn--viber" href="<?php echo esc_attr(kv_viber()); ?>" data-goal="viber"><?php echo kv_icon('viber'); ?>Viber</a>
				<?php if (kv_tg()) : ?><a class="kv-btn kv-btn--tg" href="<?php echo esc_url(kv_tg()); ?>" target="_blank" rel="noopener" data-goal="telegram"><?php echo kv_icon('telegram'); ?>Telegram</a><?php endif; ?>
				<button type="button" class="kv-btn kv-btn--ghost" data-modal="callback">Обратный звонок</button>
			</div>
		</div>
		<div class="kv-map" data-map-src="<?php echo esc_url($map); ?>">
			<button type="button" class="kv-map__btn" data-map-load><?php echo kv_icon('pin'); ?>Показать на карте</button>
		</div>
	</div>
</section>
