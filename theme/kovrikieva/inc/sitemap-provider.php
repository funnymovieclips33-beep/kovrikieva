<?php
/**
 * Карта сайта для лендингов и городских страниц: /wp-sitemap-landings-1.xml
 */
defined('ABSPATH') || exit;

class KV_Sitemap_Provider extends WP_Sitemaps_Provider {
	public function __construct() {
		$this->name        = 'landings';
		$this->object_type = 'landings';
	}

	public function get_url_list($page_num, $object_subtype = '') {
		$urls = []; // Главная уже есть в wp-sitemap-posts-page-1.xml
		foreach (kv_all_landing_urls() as $u) {
			$urls[] = ['loc' => $u];
		}
		return array_slice($urls, ($page_num - 1) * 2000, 2000);
	}

	public function get_max_num_pages($object_subtype = '') {
		return (int) ceil(count(kv_all_landing_urls()) / 2000);
	}
}
