<?php

/*
 * This file is part of the smarty-gettext package.
 *
 * @copyright (c) Elan Ruusamäe
 * @license GNU Lesser General Public License, version 2.1
 * @see https://github.com/smarty-gettext/smarty-gettext/
 *
 * For the full copyright and license information,
 * please see the LICENSE and AUTHORS files
 * that were distributed with this source code.
 */

function smarty_function_locale($params, $smarty) {
	static $stack;

	// init stack as array
	if ($stack === null) {
		$stack = array();
	}

	$path = null;
	$template_dirs = method_exists($smarty, 'getTemplateDir') ? $smarty->getTemplateDir() : $smarty->template_dir;
	$path_param = isset($params['path']) ? $params['path'] : '';
	$domain = isset($params['domain']) ? $params['domain'] : 'messages';
	$stack_operation = isset($params['stack']) ? $params['stack'] : 'push';

	foreach ((array)$template_dirs as $template_dir) {
		$path = $template_dir . $path_param;
		if (is_dir($path)) {
			break;
		}
	}

	if (!$path && $stack_operation !== 'pop') {
		trigger_error("Directory for locales not found (path='{$path_param}')", E_USER_ERROR);
	}

	if ($stack_operation === 'push') {
		$stack[] = array($domain, $path);

	} elseif ($stack_operation === 'pop') {
		if (count($stack) > 1) {
			array_pop($stack);
		}
		list($domain, $path) = end($stack);
	} else {
		trigger_error("Unknown stack operation '{$stack_operation}'", E_USER_ERROR);
	}

	bind_textdomain_codeset($domain, 'UTF-8');
	bindtextdomain($domain, $path);
	textdomain($domain);
}
