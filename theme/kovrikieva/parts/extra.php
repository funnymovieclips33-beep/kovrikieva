<?php
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['extra'])) {
	return;
}
$e = $d['extra'];
?>
<section class="kv-sec kv-extra">
	<div class="kv-wrap kv-extra__grid<?php echo !empty($e['img']) ? ' kv-extra__grid--img' : ''; ?>">
		<div class="kv-content">
			<h2 class="kv-h2 kv-h2--left"><?php echo esc_html($e['title']); ?></h2>
			<?php echo wp_kses_post($e['html']); ?>
		</div>
		<?php if (!empty($e['img'])) : ?>
			<div class="kv-extra__img"><?php echo kv_img($e['img'], $e['title']); ?></div>
		<?php endif; ?>
	</div>
</section>
