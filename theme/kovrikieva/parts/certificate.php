<?php
defined('ABSPATH') || exit;
['d' => $d] = $args;
if (empty($d['certificate'])) {
	return;
}
?>
<section class="kv-sec kv-cert">
	<div class="kv-wrap kv-cert__grid">
		<div class="kv-cert__img"><?php echo kv_img('2024/02/gift-certificate.jpg', 'Подарочный сертификат на коврики ЭВА'); ?></div>
		<div>
			<h2 class="kv-h2 kv-h2--left">Подарочный сертификат на изготовление ковриков</h2>
			<p>Идеальный подарок для любого автолюбителя — подарочный сертификат <b>с открытой датой</b> на изготовление EVA ковриков!</p>
			<button type="button" class="kv-btn kv-btn--lg" data-modal="cert"><?php echo kv_icon('gift'); ?>Заказать сертификат</button>
		</div>
	</div>
</section>
