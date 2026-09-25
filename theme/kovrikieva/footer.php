<?php defined('ABSPATH') || exit;
$ctx = kv_ctx();
$dir = $ctx ? kv_direction($ctx['dir']) : null;
?>
</main>

<footer class="kv-footer">
	<?php kv_part('contacts'); ?>
	<nav class="kv-footer__links kv-wrap" aria-label="Разделы сайта">
		<a href="<?php echo esc_url(kv_url('eva')); ?>">Коврики ЭВА</a>
		<a href="<?php echo esc_url(kv_url('vorsovye-kovriki')); ?>">Ворсовые коврики</a>
		<a href="<?php echo esc_url(kv_url('kovrik-v-bagazhnik')); ?>">Коврик в багажник</a>
		<a href="<?php echo esc_url(kv_url('organajzer-v-bagazhnik')); ?>">Автокейсы</a>
		<a href="<?php echo esc_url(kv_url('v-lodku')); ?>">В лодку</a>
		<a href="<?php echo esc_url(kv_url('dlja-doma')); ?>">Для дома</a>
		<a href="<?php echo esc_url(home_url('/o-nas/')); ?>">О компании</a>
		<a href="<?php echo esc_url(home_url('/otzyvy/')); ?>">Отзывы</a>
	</nav>
	<div class="kv-footer__line"><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Политика конфиденциальности</a></div>
	<div class="kv-footer__line">Copyright © <?php echo esc_html(date('Y')); ?> Коврики EVA для автомобиля и дома в Минске, официальный сайт</div>
</footer>

<!-- Мобильная панель действий -->
<nav class="kv-dock" aria-label="Быстрая связь">
	<a class="kv-dock__call" href="<?php echo esc_attr(kv_tel()); ?>" data-goal="call"><?php echo kv_icon('phone'); ?><span>Позвонить</span></a>
	<a class="kv-dock__msg kv-dock__msg--viber" href="<?php echo esc_attr(kv_viber()); ?>" data-goal="viber" aria-label="Viber"><?php echo kv_icon('viber'); ?></a>
	<?php if (kv_tg()) : ?><a class="kv-dock__msg kv-dock__msg--tg" href="<?php echo esc_url(kv_tg()); ?>" target="_blank" rel="noopener" data-goal="telegram" aria-label="Telegram"><?php echo kv_icon('telegram'); ?></a><?php endif; ?>
</nav>

<!-- Модальные окна -->
<dialog class="kv-modal" id="kv-modal-callback" aria-labelledby="kv-cb-title">
	<button class="kv-modal__close" type="button" data-close aria-label="Закрыть"><?php echo kv_icon('close'); ?></button>
	<p class="kv-modal__title" id="kv-cb-title">Обратный звонок</p>
	<p class="kv-modal__sub">Перезвоним в течение 15 минут в рабочее время</p>
	<?php echo kv_form(['form' => 'Обратный звонок', 'btn' => 'Жду звонка']); ?>
</dialog>

<dialog class="kv-modal" id="kv-modal-order" aria-labelledby="kv-order-title">
	<button class="kv-modal__close" type="button" data-close aria-label="Закрыть"><?php echo kv_icon('close'); ?></button>
	<p class="kv-modal__title" id="kv-order-title">Оформить заказ</p>
	<p class="kv-modal__sub" data-order-product><?php echo $dir ? esc_html($dir['short']) : 'Коврики на заказ'; ?></p>
	<?php
	echo kv_form([
		'form'     => 'Заказ',
		'products' => $dir['order_options'] ?? [],
		'full'     => $dir && empty($dir['remote']),
		'sizes'    => !empty($dir['size_fields']),
		'btn'      => 'Отправить заказ',
	]);
	?>
</dialog>

<dialog class="kv-modal kv-modal--cert" id="kv-modal-cert" aria-labelledby="kv-cert-title">
	<button class="kv-modal__close" type="button" data-close aria-label="Закрыть"><?php echo kv_icon('close'); ?></button>
	<p class="kv-modal__title" id="kv-cert-title">Заказ сертификата</p>
	<?php echo kv_form(['form' => 'Подарочный сертификат', 'btn' => 'Заказать сертификат']); ?>
</dialog>

<?php if ($ctx) : ?>
<dialog class="kv-modal kv-modal--wide" id="kv-modal-cities" aria-labelledby="kv-cities-title">
	<button class="kv-modal__close" type="button" data-close aria-label="Закрыть"><?php echo kv_icon('close'); ?></button>
	<p class="kv-modal__title" id="kv-cities-title">Выберите ваш город</p>
	<input class="kv-cities__search" type="search" placeholder="Начните вводить название…" data-city-filter aria-label="Поиск города">
	<ul class="kv-cities__list" data-city-list>
		<?php $has_city = !empty($dir['cities']); ?>
		<li><a href="<?php echo esc_url(kv_url($ctx['dir'])); ?>">Минск</a></li>
		<?php foreach (kv_cities() as $slug => $c) : ?>
			<li><a href="<?php echo esc_url($has_city ? kv_url($ctx['dir'], $slug) : kv_url('eva', $slug)); ?>"><?php echo esc_html($c[0]); ?></a></li>
		<?php endforeach; ?>
	</ul>
</dialog>
<?php endif; ?>

<dialog class="kv-lightbox" id="kv-lightbox" aria-label="Просмотр фото">
	<button class="kv-modal__close" type="button" data-close aria-label="Закрыть"><?php echo kv_icon('close'); ?></button>
	<button class="kv-lightbox__nav kv-lightbox__prev" type="button" data-lb="-1" aria-label="Предыдущее">‹</button>
	<img alt="" data-lb-img>
	<button class="kv-lightbox__nav kv-lightbox__next" type="button" data-lb="1" aria-label="Следующее">›</button>
</dialog>

<dialog class="kv-stories" id="kv-stories" aria-label="Фото работ">
	<div class="kv-stories__bg" data-st-bg></div>
	<div class="kv-stories__frame">
		<div class="kv-stories__bars" data-st-bars></div>
		<p class="kv-stories__brand" data-st-brand></p>
		<button class="kv-stories__close" type="button" data-close aria-label="Закрыть"><?php echo kv_icon('close'); ?></button>
		<img alt="" data-st-img>
		<button class="kv-stories__nav kv-stories__nav--prev" type="button" data-st="-1" aria-label="Предыдущее фото">‹</button>
		<button class="kv-stories__nav kv-stories__nav--next" type="button" data-st="1" aria-label="Следующее фото">›</button>
	</div>
</dialog>

<?php wp_footer(); ?>
</body>
</html>
