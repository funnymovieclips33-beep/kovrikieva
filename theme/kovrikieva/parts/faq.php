<?php
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['faq'])) {
	return;
}
?>
<section class="kv-sec kv-faq" id="faq">
	<div class="kv-wrap kv-wrap--narrow">
		<h2 class="kv-h2">Часто задаваемые вопросы</h2>
		<?php foreach ($d['faq'] as $i => $f) : ?>
			<details class="kv-faq__item"<?php echo $i === 0 ? ' open' : ''; ?>>
				<summary><?php echo esc_html($f[0]); ?><?php echo kv_icon('chevron'); ?></summary>
				<div class="kv-faq__a kv-content"><?php echo wp_kses_post($f[1]); ?></div>
			</details>
		<?php endforeach; ?>
	</div>
</section>
