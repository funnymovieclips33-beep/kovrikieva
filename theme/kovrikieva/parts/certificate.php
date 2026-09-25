<?php
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['certificate'])) {
	return;
}
?>
<section class="kv-sec kv-sota kv-cert">
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line">Подарочный сертификат на изготовление ковриков</h2>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<div class="kv-cert__grid">
			<div class="kv-box kv-cert__text">
				<p>Идеальный подарок для любого автолюбителя — подарочный сертификат <b>С ОТКРЫТОЙ ДАТОЙ</b> на изготовление EVA ковриков!</p>
				<button type="button" class="kv-btn" data-modal="cert">Заказать сертификат<?php echo kv_icon('gift'); ?></button>
			</div>
			<div class="kv-cert__img"><?php echo kv_img('2024/02/gift-certificate.jpg', 'Подарочный сертификат на коврики ЭВА'); ?></div>
		</div>
	</div>
</section>
