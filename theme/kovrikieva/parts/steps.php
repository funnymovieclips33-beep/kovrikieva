<?php
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['steps'])) {
	return;
}
?>
<section class="kv-sec kv-sec--alt kv-steps">
	<div class="kv-wrap">
		<h2 class="kv-h2">Как мы работаем</h2>
		<ol class="kv-steps__list">
			<?php foreach ($d['steps'] as $s) : ?>
				<li class="kv-step"><p class="kv-step__title"><?php echo esc_html($s[0]); ?></p><p><?php echo esc_html($s[1]); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
