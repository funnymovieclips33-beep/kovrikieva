<?php
/**
 * Скорость: чистим <head>, встраиваем CSS, откладываем JS и счётчики.
 */
defined('ABSPATH') || exit;

add_action('init', function () {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('emoji_svg_url', '__return_false');

	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('template_redirect', 'rest_output_link_header', 11);
	remove_action('template_redirect', 'wp_shortlink_header', 11);
});

add_filter('xmlrpc_enabled', '__return_false');

add_action('wp_enqueue_scripts', function () {
	// Стили блоков Gutenberg на фронте не нужны (кроме обычных страниц с контентом).
	if (kv_ctx()) {
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('classic-theme-styles');
		wp_dequeue_style('global-styles');
	}
	wp_deregister_script('wp-embed');
	if (!is_admin() && apply_filters('kv_disable_jquery', true)) {
		wp_deregister_script('jquery'); // тема не использует jQuery; вернуть: add_filter('kv_disable_jquery', '__return_false')
	}
	wp_enqueue_script('kv-main', KV_URI . '/assets/js/main.js', [], KV_VER, ['in_footer' => true, 'strategy' => 'defer']);
	wp_localize_script('kv-main', 'KV', [
		'rest'    => esc_url_raw(rest_url('kv/v1/lead')),
		'metrika' => kv_opt('metrika'),
		'gads'    => kv_opt('gads'),
	]);
}, 100);

add_action('wp_body_open', function () {
	// SVG-спрайт иконок (без запросов).
	$sprite = KV_DIR . '/assets/img/icons.svg';
	if (is_readable($sprite)) {
		echo file_get_contents($sprite); // phpcs:ignore
	}
});

/** Критический CSS целиком в <head> — 0 блокирующих запросов. */
add_action('wp_head', function () {
	$uri = KV_URI . '/assets/fonts/';
	echo '<link rel="preload" href="' . esc_url($uri . 'roboto-cyr.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";
	echo '<link rel="preload" href="' . esc_url($uri . 'robotocond-cyr.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";

	$ctx = kv_ctx();
	if ($ctx) {
		$d = kv_direction($ctx['dir']);
		echo '<link rel="preload" as="image" href="' . esc_url(kv_upload($d['hero_img'])) . '" fetchpriority="high">' . "\n";
	}

	$css = @file_get_contents(KV_DIR . '/assets/css/main.css');
	$css = str_replace('../fonts/', $uri, (string) $css);
	$css = preg_replace(['#/\*.*?\*/#s', '/\s+/', '/\s*([{}:;,>])\s*/', '/;}/'], ['', ' ', '$1', '}'], $css);
	echo '<style id="kv-css">' . $css . "</style>\n"; // phpcs:ignore
}, 2);

/** Favicon со старого сайта. */
add_action('wp_head', function () {
	if (has_site_icon()) {
		return;
	}
	$b = content_url('uploads/fbrfg/');
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url($b . 'favicon-32x32.png') . "\">\n";
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($b . 'apple-touch-icon.png') . "\">\n";
	echo "<meta name=\"theme-color\" content=\"#713939\">\n";
}, 3);

/**
 * Яндекс.Метрика и Google Ads загружаются после первого взаимодействия
 * или через 3.5 с — не мешают скорости (PageSpeed), но собирают данные.
 */
add_action('wp_footer', function () {
	$ym = preg_replace('/\D/', '', kv_opt('metrika'));
	$ga = preg_replace('/[^A-Z0-9-]/', '', kv_opt('gads'));
	if (!$ym && !$ga) {
		return;
	}
	?>
<script>
(function(){var done=false;function load(){if(done)return;done=true;
<?php if ($ym) : ?>
(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})(window,document,"script","https://mc.yandex.ru/metrika/tag.js","ym");
ym(<?php echo (int) $ym; ?>,"init",{clickmap:true,trackLinks:true,accurateTrackBounce:true,webvisor:true});
<?php endif; ?>
<?php if ($ga) : ?>
var s=document.createElement("script");s.async=1;s.src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_js($ga); ?>";document.head.appendChild(s);
window.dataLayer=window.dataLayer||[];window.gtag=function(){dataLayer.push(arguments)};gtag("js",new Date());gtag("config","<?php echo esc_js($ga); ?>");
<?php endif; ?>
}
["scroll","mousemove","touchstart","keydown","click"].forEach(function(e){addEventListener(e,load,{once:true,passive:true})});
setTimeout(load,3500);})();
</script>
<?php if ($ym) : ?><noscript><div><img src="https://mc.yandex.ru/watch/<?php echo (int) $ym; ?>" style="position:absolute;left:-9999px" alt=""></div></noscript><?php endif; ?>
	<?php
}, 99);
