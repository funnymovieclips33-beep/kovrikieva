<?php
/** Сравнение: ЭВА vs резиновые vs ворсовые коврики. */
defined('ABSPATH') || exit;
$rows = [
	['Вода и грязь', 'Остаются в ячейках, не растекаются', 'Образуется лужа, при снятии выливается', 'Впитываются, коврик долго сохнет'],
	['Фиксация в салоне', 'Штатные клипсы + липучки', 'Часто без креплений, скользят', 'Сползают под педали'],
	['Мороз и жара', 'От −70 до +50 °C без трещин', 'Дубеют на морозе, трескаются', 'Намокают и замерзают'],
	['Уход', 'Струя воды — и чисто', 'Мыть и сушить', 'Пылесос, химчистка'],
	['Запах', 'Без запаха', 'Резиновый запах в жару', 'Сырость при намокании'],
	['Выбор цвета', '14 цветов × 17 цветов канта', '1–2 цвета', 'Ограничен'],
];
?>
<section class="kv-sec kv-compare-sec">
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line">Коврики ЭВА в сравнении с резиновыми и ворсовыми</h2>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>
		<div class="kv-cmp">
			<div class="kv-cmp__head"><span></span><b class="is-eva">Коврики ЭВА</b><b>Резиновые</b><b>Ворсовые</b></div>
			<?php foreach ($rows as $r) : ?>
				<div class="kv-cmp__row">
					<span class="kv-cmp__k"><?php echo esc_html($r[0]); ?></span>
					<span class="is-eva" data-l="Коврики ЭВА"><?php echo kv_icon('check'); ?><?php echo esc_html($r[1]); ?></span>
					<span data-l="Резиновые"><?php echo esc_html($r[2]); ?></span>
					<span data-l="Ворсовые"><?php echo esc_html($r[3]); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
