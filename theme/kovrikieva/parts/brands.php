<?php
/** Плитки марок со ссылками на страницы /kovriki/{марка}/ (перелинковка). */
defined('ABSPATH') || exit;
$title   = $args['title'] ?? 'Коврики по маркам автомобилей';
$current = $args['current'] ?? '';
?>
<section class="kv-sec kv-brandlinks">
	<div class="kv-wrap">
		<?php if ($title) : ?>
			<h2 class="kv-h2 kv-h2--line"><?php echo esc_html($title); ?></h2>
			<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<?php endif; ?>
		<ul class="kv-blinks">
			<?php foreach (kv_brands() as $slug => $b) : if ($slug === $current) { continue; } ?>
				<li><a href="<?php echo esc_url(kv_brand_url($slug)); ?>">
					<span class="kv-blinks__logo" data-name="<?php echo esc_attr(mb_substr($b[0], 0, 1)); ?>"><?php if ($b[3]) : ?><img src="<?php echo esc_url(kv_upload('2024/02/' . $b[3])); ?>" alt="" loading="lazy" decoding="async"><?php endif; ?></span>
					<span>Коврики для <b><?php echo esc_html($b[0]); ?></b></span>
				</a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
