<?php
/** Видео + слайдер сравнения структур «Ромбы / Соты» (только ЭВА). */
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['textures'])) {
	return;
}
[$a, $b] = $d['textures'];
$video  = trim(kv_opt('video2'));
$poster = $video ? kv_video_poster($video) : '';
?>
<section class="kv-sec kv-tex">
	<div class="kv-wrap kv-tex__grid">
		<?php if ($video) : ?>
			<button type="button" class="kv-tex__video" data-video="<?php echo esc_attr($video); ?>" aria-label="Смотреть видео о ковриках ЭВА">
				<?php if ($poster) : ?><img src="<?php echo esc_url($poster); ?>" alt="Видео о ковриках ЭВА" loading="lazy" decoding="async" width="640" height="360"><?php endif; ?>
				<span class="kv-tex__play"><?php echo kv_icon('play'); ?></span>
			</button>
		<?php endif; ?>
		<div class="kv-compare" data-compare style="--pos:50%">
			<?php echo kv_img($b[1], 'Структура коврика ЭВА: ' . $b[0], 'kv-compare__img'); ?>
			<div class="kv-compare__top"><?php echo kv_img($a[1], 'Структура коврика ЭВА: ' . $a[0], 'kv-compare__img'); ?></div>
			<span class="kv-compare__label kv-compare__label--l"><?php echo esc_html($a[0]); ?></span>
			<span class="kv-compare__label kv-compare__label--r"><?php echo esc_html($b[0]); ?></span>
			<span class="kv-compare__handle" aria-hidden="true">⟷</span>
			<input type="range" min="0" max="100" value="50" aria-label="Сравнить структуры: <?php echo esc_attr($a[0] . ' и ' . $b[0]); ?>">
		</div>
	</div>
</section>
