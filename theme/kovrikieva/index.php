<?php
defined('ABSPATH') || exit;
get_header();
?>
<div class="kv-wrap kv-page">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<article class="kv-post">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<h1>Ничего не найдено</h1>
	<?php endif; ?>
</div>
<?php
get_footer();
