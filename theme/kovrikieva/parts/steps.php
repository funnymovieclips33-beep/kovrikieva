<?php
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['steps'])) {
	return;
}
$icons = ['cart', 'car', 'gears', 'flag'];
?>
<section class="kv-sec kv-sota kv-steps">
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line">Как мы работаем</h2>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<ol class="kv-steps__list">
			<?php foreach ($d['steps'] as $i => $s) : ?>
				<li class="kv-step">
					<span class="kv-step__num"><?php echo $i + 1; ?></span>
					<span class="kv-step__ic"><?php echo kv_icon($icons[$i % 4]); ?></span>
					<p class="kv-step__title"><?php echo esc_html($s[0]); ?></p>
					<p class="kv-step__text"><?php echo esc_html($s[1]); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
