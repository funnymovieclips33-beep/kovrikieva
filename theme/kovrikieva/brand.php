<?php
/**
 * Страницы марок: /kovriki/ (каталог) и /kovriki/{марка}/ — «Коврики для Mercedes-Benz».
 * На одной странице — ЭВА и ворсовые коврики, модели, фото работ этой марки, конструктор.
 */
defined('ABSPATH') || exit;

$ctx   = kv_ctx();
$slug  = $ctx['brand'];
$eva   = kv_direction('eva');
$vors  = kv_direction('vorsovye-kovriki');

get_header();

if ($slug === '_hub') :
	?>
	<section class="kv-pagehead">
		<div class="kv-wrap">
			<?php echo kv_breadcrumbs(); ?>
			<h1>Коврики для авто по маркам</h1>
			<p class="kv-lead">Изготавливаем коврики ЭВА и ворсовые коврики по заводским лекалам — в базе более 2000 моделей. Выберите марку автомобиля:</p>
		</div>
	</section>
	<?php
	kv_part('brands', ['title' => '', 'current' => '']);
	kv_part('compare', []);
	kv_part('steps', ['d' => $eva]);
	kv_part('delivery', ['key' => 'eva', 'd' => $eva, 'city' => null]);
else :
	$b      = kv_brand($slug);
	$name   = $b[0];
	$photos = kv_data('gallery')['eva'][$name] ?? [];
	$d      = $eva;
	$d['h1']          = 'Коврики для ' . $name;
	$d['lead']        = 'ЭВА и ворсовые коврики для ' . $name . ' в салон и багажник. Изготовим по лекалам вашей модели за 24 часа и подарим <b>логотип ' . esc_html($name) . '</b> при заказе комплекта!';
	$d['hero_thumbs'] = $photos ? array_slice($photos, 0, 4) : $eva['hero_thumbs'];
	$d['gallery']     = $photos ? 'eva' : '';
	$d['gallery_only'] = $name;
	$d['faq'] = array_merge([
		['Есть ли у вас лекала для моего ' . $name . '?', '<p>Да, в нашей базе более 2000 лекал, включая ' . esc_html(implode(', ', array_slice($b[2], 0, 6))) . ' и другие модели ' . esc_html($name) . ' разных поколений. Если модели нет в базе — снимем лекала с вашего автомобиля за 25 минут.</p>'],
		['Что лучше для ' . $name . ' — ЭВА или ворсовые коврики?', '<p>ЭВА-коврики удерживают воду и грязь в ячейках и моются водой — идеальны для зимы и межсезонья. Ворсовые коврики уютнее, тише и выглядят премиально. Многие владельцы ' . esc_html($name) . ' берут оба комплекта: ЭВА на зиму, ворс на лето.</p>'],
	], $eva['faq']);
	$d['text'] = '<p>Коврики для ' . esc_html($name) . ' (' . esc_html($b[1]) . ') мы изготавливаем по заводским лекалам конкретной модели и года выпуска, поэтому они максимально закрывают пол салона и багажника и надёжно фиксируются на штатных креплениях.</p><p>На выбор — <b>коврики ЭВА</b> (соты или ромбы, 14 цветов материала и 17 цветов канта) и <b>ворсовые коврики</b> (Standard, Premium, Luxury). Дополнительно — подпятник и металлический логотип ' . esc_html($name) . '.</p>';
	$args = ['key' => 'eva', 'd' => $d, 'city' => null];

	kv_part('hero', $args);
	kv_part('brand-types', ['b' => $b, 'slug' => $slug]);
	kv_part('constructor', $args);
	kv_part('gallery', $args);
	kv_part('compare', []);
	kv_part('steps', $args);
	kv_part('faq', $args);
	kv_part('brands', ['title' => 'Коврики для других марок', 'current' => $slug]);
	kv_part('delivery', $args);
endif;

get_footer();
