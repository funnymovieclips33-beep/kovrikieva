<?php
/**
 * Отзывы: ваш виджет (шорткод из «Настроить → KovrikiEVA») + кнопки.
 * Если шорткод не задан — встроенный виджет отзывов Яндекс.Карт.
 * $args['full'] = true — полная версия для страницы /otzyvy/.
 */
defined('ABSPATH') || exit;
$full   = !empty($args['full']);
$sc     = trim((string) kv_opt('reviews_sc'));
$org    = preg_replace('/\D/', '', kv_opt('ya_org'));
$google = trim((string) kv_opt('google_review'));
?>
<section class="kv-sec kv-reviews-sec<?php echo $full ? ' kv-reviews-sec--full' : ''; ?>" id="reviews">
	<div class="kv-wrap">
		<?php if (!$full) : ?>
			<h2 class="kv-h2 kv-h2--line">Отзывы наших клиентов</h2>
			<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<?php endif; ?>
		<div class="kv-reviews__widget">
			<?php if ($sc) : ?>
				<?php echo do_shortcode($sc); // phpcs:ignore ?>
			<?php elseif ($org) : ?>
				<iframe class="kv-reviews__frame" title="Отзывы о KOVRIKIEVABY на Яндекс Картах" loading="lazy" src="https://yandex.ru/maps-reviews-widget/<?php echo esc_attr($org); ?>?comments"></iframe>
			<?php endif; ?>
		</div>
		<div class="kv-reviews__btns">
			<?php if (!$full) : ?>
				<a class="kv-btn" href="<?php echo esc_url(home_url('/otzyvy/')); ?>">Все отзывы</a>
			<?php endif; ?>
			<?php if ($org) : ?>
				<a class="kv-btn kv-btn--ghost kv-btn--ya" href="https://yandex.by/maps/org/<?php echo esc_attr($org); ?>/reviews/?add-review=true" target="_blank" rel="noopener nofollow" data-goal="review_yandex"><span class="kv-rv-ic kv-rv-ic--ya">Я</span>Оставить отзыв на Яндекс Картах</a>
			<?php endif; ?>
			<?php if ($google) : ?>
				<a class="kv-btn kv-btn--ghost kv-btn--g" href="<?php echo esc_url($google); ?>" target="_blank" rel="noopener nofollow" data-goal="review_google"><span class="kv-rv-ic kv-rv-ic--g">G</span>Оставить отзыв в Google</a>
			<?php endif; ?>
		</div>
	</div>
</section>
