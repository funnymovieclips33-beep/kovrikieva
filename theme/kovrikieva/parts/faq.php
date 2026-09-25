<?php
/** Вопросы-ответы (слева) + SEO-текст в рамке (справа), как на старом сайте. */
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['faq']) && empty($d['text'])) {
	return;
}
?>
<section class="kv-sec kv-faq" id="faq">
	<div class="kv-wrap kv-faq__grid<?php echo empty($d['text']) ? ' kv-faq__grid--one' : ''; ?>">
		<div>
			<h2 class="kv-h2 kv-h2--line">Часто задаваемые вопросы</h2>
			<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
			<?php foreach ($d['faq'] ?? [] as $f) : ?>
				<details class="kv-faq__item" name="kv-faq">
					<summary><?php echo esc_html($f[0]); ?><span class="kv-faq__arr" aria-hidden="true"></span></summary>
					<div class="kv-faq__a kv-content"><?php echo wp_kses_post($f[1]); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
		<?php if (!empty($d['text'])) : ?>
			<div class="kv-box kv-content kv-seotext"><?php echo wp_kses_post($d['text']); ?></div>
		<?php endif; ?>
	</div>
</section>
