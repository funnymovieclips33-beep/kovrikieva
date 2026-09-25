<?php defined('ABSPATH') || exit; ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="kv-skip" href="#main">Перейти к содержимому</a>

<div class="kv-topbar">
	<div class="kv-wrap kv-topbar__in">
		<span class="kv-topbar__item"><?php echo kv_icon('pin'); ?><?php echo esc_html(kv_opt('address')); ?></span>
		<span class="kv-topbar__item"><?php echo kv_icon('clock'); ?><?php echo esc_html(kv_opt('hours')); ?></span>
		<span class="kv-topbar__item kv-topbar__item--accent"><?php echo kv_icon('truck'); ?>Доставка по всей Беларуси 1–3 дня</span>
	</div>
</div>

<header class="kv-header" data-kv-header>
	<div class="kv-wrap kv-header__in">
		<a class="kv-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="KOVRIKIEVABY — на главную">
			<img src="<?php echo esc_url(kv_upload('2021/05/logo.png')); ?>" alt="KOVRIKIEVABY" width="160" height="48" decoding="async">
		</a>

		<nav class="kv-nav" id="kv-nav" aria-label="Главное меню">
			<?php if (has_nav_menu('primary')) : ?>
				<?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'menu_class' => 'kv-nav__list', 'depth' => 2]); ?>
			<?php else : ?>
				<ul class="kv-nav__list">
					<?php foreach (kv_menu_items() as $item) : ?>
						<li class="<?php echo !empty($item[2]) ? 'has-sub' : ''; ?>">
							<a href="<?php echo esc_url($item[1]); ?>"><?php echo esc_html($item[0]); ?><?php echo !empty($item[2]) ? kv_icon('chevron', 'kv-nav__chev') : ''; ?></a>
							<?php if (!empty($item[2])) : ?>
								<ul class="kv-nav__sub">
									<?php foreach ($item[2] as $sub) : ?>
										<li><a href="<?php echo esc_url($sub[1]); ?>"><?php echo esc_html($sub[0]); ?></a></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<div class="kv-nav__mobile-contacts">
				<a class="kv-btn kv-btn--block" href="<?php echo esc_attr(kv_tel()); ?>" data-goal="call"><?php echo kv_icon('phone'); ?><?php echo esc_html(kv_opt('phone_label')); ?></a>
				<p><?php echo esc_html(kv_opt('hours')); ?><br><?php echo esc_html(kv_opt('address')); ?></p>
			</div>
		</nav>

		<div class="kv-header__contacts">
			<div class="kv-msgs">
				<a class="kv-msg kv-msg--viber" href="<?php echo esc_attr(kv_viber()); ?>" aria-label="Написать в Viber" data-goal="viber"><?php echo kv_icon('viber'); ?></a>
				<?php if (kv_tg()) : ?><a class="kv-msg kv-msg--tg" href="<?php echo esc_url(kv_tg()); ?>" target="_blank" rel="noopener" aria-label="Написать в Telegram" data-goal="telegram"><?php echo kv_icon('telegram'); ?></a><?php endif; ?>
			</div>
			<div class="kv-header__phone">
				<a href="<?php echo esc_attr(kv_tel()); ?>" data-goal="call"><?php echo esc_html(kv_opt('phone_label')); ?></a>
				<button type="button" class="kv-link" data-modal="callback">Обратный звонок</button>
			</div>
		</div>

		<a class="kv-header__call" href="<?php echo esc_attr(kv_tel()); ?>" aria-label="Позвонить" data-goal="call"><?php echo kv_icon('phone'); ?></a>
		<button class="kv-burger" type="button" aria-controls="kv-nav" aria-expanded="false" aria-label="Меню" data-kv-burger><?php echo kv_icon('menu', 'kv-burger__open'); ?><?php echo kv_icon('close', 'kv-burger__close'); ?></button>
	</div>
</header>

<main id="main" class="kv-main">
