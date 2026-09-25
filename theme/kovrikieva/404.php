<?php
defined('ABSPATH') || exit;
get_header();
?>
<section class="kv-pagehead kv-404">
	<div class="kv-wrap">
		<p class="kv-404__code">404</p>
		<h1>Страница не найдена</h1>
		<p>Возможно, она переехала. Посмотрите наши коврики:</p>
	</div>
</section>
<?php
kv_part('related', ['key' => '', 'd' => ['related' => ['eva', 'vorsovye-kovriki', 'organajzer-v-bagazhnik', 'dlja-doma', 'kovrik-v-bagazhnik', 'v-lodku']], 'city' => null]);
get_footer();
