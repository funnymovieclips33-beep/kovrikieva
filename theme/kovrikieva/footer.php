<?php defined('ABSPATH') || exit;
$ctx = kv_ctx();
$dir = $ctx ? kv_direction($ctx['dir']) : null;
?>
</main>

<footer class="kv-footer">
	<div class="kv-wrap kv-footer__grid">
		<div>
			<img class="kv-footer__logo" src="<?php echo esc_url(kv_upload('2021/05/logo.png')); ?>" alt="KOVRIKIEVABY" width="160" height="48" loading="lazy" decoding="async">
			<p>Производство ковриков ЭВА и ворсовых ковриков для авто, дома и лодок, органайзеров в багажник. Изготовление за 24 часа, доставка по всей Беларуси.</p>
			<div class="kv-msgs">
				<a class="kv-msg kv-msg--viber" href="<?php echo esc_attr(kv_viber()); ?>" aria-label="Viber" data-goal="viber"><?php echo kv_icon('viber'); ?></a>
				<?php if (kv_tg()) : ?><a class="kv-msg kv-msg--tg" href="<?php echo esc_url(kv_tg()); ?>" target="_blank" rel="noopener" aria-label="Telegram" data-goal="telegram"><?php echo kv_icon('telegram'); ?></a><?php endif; ?>
				<?php if (kv_opt('instagram')) : ?><a class="kv-msg kv-msg--ig" href="<?php echo esc_url(kv_opt('instagram')); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo kv_icon('instagram'); ?></a><?php endif; ?>
			</div>
		</div>
		<div>
			<p class="kv-footer__title">Для авто</p>
			<ul>
				<li><a href="<?php echo esc_url(kv_url('eva')); ?>">Коврики ЭВА</a></li>
				<li><a href="<?php echo esc_url(kv_url('vorsovye-kovriki')); ?>">Ворсовые коврики</a></li>
				<li><a href="<?php echo esc_url(kv_url('kovrik-v-bagazhnik')); ?>">Коврик в багажник</a></li>
				<li><a href="<?php echo esc_url(kv_url('organajzer-v-bagazhnik')); ?>">Органайзеры (автокейсы)</a></li>
				<li><a href="<?php echo esc_url(kv_url('v-lodku')); ?>">Коврик в лодку</a></li>
				<li><a href="<?php echo esc_url(kv_url('dlja-doma')); ?>">Коврики для дома</a></li>
			</ul>
		</div>
		<div>
			<p class="kv-footer__title">Компания</p>
			<ul>
				<li><a href="<?php echo esc_url(home_url('/o-nas/')); ?>">О компании</a></li>
				<li><a href="<?php echo esc_url(home_url('/fotogalereya/')); ?>">Фотогалерея</a></li>
				<li><a href="<?php echo esc_url(home_url('/otzyvy/')); ?>">Отзывы</a></li>
				<li><a href="<?php echo esc_url(home_url('/zakazat/')); ?>">Заказать</a></li>
				<li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Политика конфиденциальности</a></li>
			</ul>
		</div>
		<div>
			<p class="kv-footer__title">Контакты</p>
			<p><a class="kv-footer__phone" href="<?php echo esc_attr(kv_tel()); ?>" data-goal="call"><?php echo esc_html(kv_opt('phone_label')); ?></a></p>
			<p><?php echo esc_html(kv_opt('address')); ?><br><?php echo esc_html(kv_opt('hours')); ?></p>
			<p><a href="mailto:<?php echo esc_attr(kv_opt('email')); ?>"><?php echo esc_html(kv_opt('email')); ?></a></p>
			<button type="button" class="kv-btn kv-btn--ghost" data-modal="callback">Обратный звонок</button>
		</div>
	</div>
	<div class="kv-wrap kv-footer__bottom">
		<p>© <?php echo esc_html(date('Y')); ?> KOVRIKIEVABY. Информация на сайте носит ознакомительный характер, цены и наличие уточняйте по телефону.</p>
	</div>
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

<?php wp_footer(); ?>
</body>
</html>
