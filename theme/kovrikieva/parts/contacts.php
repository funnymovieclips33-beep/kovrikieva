<?php
/** Бордовый блок контактов с картой (выводится в подвале на всех страницах). */
defined('ABSPATH') || exit;
$org = preg_replace('/\D/', '', kv_opt('ya_org'));
$lat = kv_opt('geo_lat');
$lng = kv_opt('geo_lng');
$map = 'https://yandex.by/map-widget/v1/?ll=' . rawurlencode($lng . ',' . $lat) . '&z=15' . ($org ? '&oid=' . $org . '&ol=biz' : '&pt=' . rawurlencode($lng . ',' . $lat) . ',pm2rdm');
?>
<section class="kv-contacts" id="contacts">
	<div class="kv-wrap">
		<p class="kv-contacts__note">Информация на сайте носит ознакомительный характер, цены и наличие уточняйте по телефону</p>
		<div class="kv-contacts__grid">
			<div class="kv-contacts__box">
				<h2 class="kv-contacts__title">Контактная информация</h2>
				<ul class="kv-contacts__list">
					<li><?php echo kv_icon('pin'); ?><span><?php echo esc_html(kv_opt('address')); ?></span></li>
					<li><?php echo kv_icon('clock'); ?><span><?php echo str_replace(', ', '<br>', esc_html(kv_opt('hours'))); ?></span></li>
					<li><?php echo kv_icon('phone'); ?><a href="<?php echo esc_attr(kv_tel()); ?>" data-goal="call"><?php echo esc_html(kv_opt('phone_label')); ?></a></li>
					<li><?php echo kv_icon('mail'); ?><a href="mailto:<?php echo esc_attr(kv_opt('email')); ?>"><?php echo esc_html(kv_opt('email')); ?></a></li>
				</ul>
				<button type="button" class="kv-btn kv-btn--white" data-modal="callback">Заказать звонок<?php echo kv_icon('phone'); ?></button>
				<div class="kv-contacts__soc">
					<a href="<?php echo esc_attr(kv_viber()); ?>" aria-label="Viber" data-goal="viber"><?php echo kv_icon('viber'); ?></a>
					<?php if (kv_tg()) : ?><a href="<?php echo esc_url(kv_tg()); ?>" target="_blank" rel="noopener" aria-label="Telegram" data-goal="telegram"><?php echo kv_icon('telegram'); ?></a><?php endif; ?>
					<?php if (kv_opt('instagram')) : ?><a href="<?php echo esc_url(kv_opt('instagram')); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo kv_icon('instagram'); ?></a><?php endif; ?>
				</div>
			</div>
			<div class="kv-map"><iframe src="<?php echo esc_url($map); ?>" title="KOVRIKIEVABY на карте Минска" loading="lazy" allowfullscreen></iframe></div>
		</div>
	</div>
</section>
