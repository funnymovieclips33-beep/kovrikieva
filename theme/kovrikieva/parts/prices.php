<?php
defined('ABSPATH') || exit;
['key' => $key, 'd' => $d, 'city' => $city] = $args;
$p = $d['prices'] ?? null;
if (!$p || (!empty($d['constructor']) && $p['type'] === 'cards')) {
	return; // цены ЭВА показаны в конструкторе
}
$title = $p['title'] . ($city ? ' ' . kv_city_in($city) : '');
?>
<section class="kv-sec kv-sota kv-prices" id="prices">
	<div class="kv-wrap">
		<h2 class="kv-h2 kv-h2--line"><?php echo esc_html($title); ?></h2>
		<div class="kv-divider" aria-hidden="true"><?php echo kv_icon('target'); ?></div>

		<?php if ($p['type'] === 'cards') : ?>
			<p class="kvp-hint"><span>i</span>Нажмите или наведите на карточку комплекта, чтобы узнать стоимость и сделать заказ</p>
			<div class="kvp-grid">
				<?php foreach ($p['items'] as $it) : ?>
					<article class="kvp" tabindex="0">
						<?php if (!empty($it[3])) : ?><span class="kv-ribbon"><?php echo kv_icon('gift'); ?>Логотип в подарок</span><?php endif; ?>
						<?php echo kv_img($it[2], $it[0]); ?>
						<div class="kvp__ov">
							<h3 class="kvp__title"><?php echo esc_html($it[0]); ?></h3>
							<p class="kvp__price"><?php echo esc_html(kv_price($it[1])); ?></p>
							<button type="button" class="kvp__btn" data-modal="order" data-product="<?php echo esc_attr($it[0]); ?>">Заказать</button>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

		<?php else : ?>
			<div class="kv-table-wrap">
				<table class="kv-table">
					<thead><tr><?php foreach ($p['head'] as $h) : ?><th scope="col"><?php echo esc_html($h); ?></th><?php endforeach; ?></tr></thead>
					<tbody>
						<?php foreach ($p['rows'] as $row) : ?>
							<tr>
								<?php foreach ($row as $i => $cell) : ?>
									<?php if ($i === 0 && empty($p['plain_head'])) : ?>
										<th scope="row"><?php echo esc_html($cell); ?></th>
									<?php else : ?>
										<td data-label="<?php echo esc_attr($p['head'][$i]); ?>"><?php echo is_int($cell) ? '<b>' . esc_html(kv_price($cell)) . '</b>' : esc_html($cell); ?></td>
									<?php endif; ?>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="kv-center">
				<button type="button" class="kv-btn kv-btn--lg" data-modal="order" data-product="<?php echo esc_attr($d['short']); ?>">Рассчитать стоимость</button>
			</div>
		<?php endif; ?>
		<p class="kv-muted kv-center">Точная стоимость зависит от модели авто и выбранных опций — рассчитаем за 5 минут.</p>
	</div>
</section>
