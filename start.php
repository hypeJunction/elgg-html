<?php

require_once __DIR__ . '/autoloader.php';


if (!function_exists('elgg_format_html')) {
	function elgg_format_html($html, array $options = []) {
		if (!is_string($html)) {
			return '';
		}

		$options = array_merge([
			'parse_urls' => true,
			'parse_emails' => true,
			'sanitize' => true,
			'autop' => true,
		], $options);

		if (elgg_extract('sanitize', $options)) {
			$html = filter_tags($html);
		}

		$params = [
			'options' => $options,
			'html' => $html,
		];

		$params = elgg_trigger_plugin_hook('prepare', 'html', null, $params);

		$html = elgg_extract('html', $params);
		$options = elgg_extract('options', $params);

		if (elgg_extract('parse_urls', $options)) {
			$html = parse_urls($html);
		}

		if (elgg_extract('parse_emails', $options)) {
			$html = elgg_parse_emails($html);
		}

		if (elgg_extract('autop', $options)) {
			$html = elgg_autop($html);
		}

		return $html;
	}
}