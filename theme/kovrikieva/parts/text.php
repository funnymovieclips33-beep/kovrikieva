<?php
defined('ABSPATH') || exit;
['d' => $d, 'city' => $city] = $args;
if (empty($d['text'])) {
	return;
}
?>
<section class="kv-sec kv-seotext">
	<div class="kv-wrap kv-wrap--narrow kv-content"><?php echo wp_kses_post($d['text']); ?></div>
</section>
