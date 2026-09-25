<?php
/** Страница /fotogalereya/: все фото работ по маркам. */
defined('ABSPATH') || exit;
$all = kv_data('gallery');
?>
<?php foreach (['eva' => 'Коврики ЭВА', 'vors' => 'Ворсовые коврики'] as $k => $title) : ?>
	<h2><?php echo esc_html($title); ?></h2>
	<?php foreach ($all[$k] as $brand => $imgs) : ?>
		<h3><?php echo esc_html($brand); ?></h3>
		<div class="kv-photos" data-gallery-group>
			<?php foreach ($imgs as $i => $src) : ?>
				<a href="<?php echo esc_url(kv_upload($src)); ?>" data-lightbox><?php echo kv_img($src, $title . ' для ' . $brand . ' — фото ' . ($i + 1)); ?></a>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
<?php endforeach; ?>
