<?php
defined('ABSPATH') || exit;
get_header();
while (have_posts()) : the_post();
	?>
	<section class="kv-pagehead">
		<div class="kv-wrap">
			<?php echo kv_breadcrumbs(); ?>
			<h1><?php the_title(); ?></h1>
		</div>
	</section>
	<div class="kv-wrap kv-page kv-content">
		<?php the_content(); ?>
		<?php get_template_part('parts/page-after', get_post_field('post_name')); ?>
	</div>
	<?php
endwhile;
kv_part('related', ['key' => '', 'd' => ['related' => ['eva', 'vorsovye-kovriki', 'organajzer-v-bagazhnik', 'dlja-doma']], 'city' => null]);
kv_part('contacts', ['key' => '', 'd' => [], 'city' => null]);
get_footer();
