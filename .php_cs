<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
	->in(__DIR__)
	->exclude('vendor')
;

return Symfony\CS\Config\Config::create()
	->setUsingCache(true)
	->level(Symfony\CS\FixerInterface::NONE_LEVEL)
	->fixers(array(
		'linefeed', 'trailing_spaces', 'unused_use', 'short_tag',
		'return', 'visibility', 'php_closing_tag', 'extra_empty_lines',
		'function_declaration', 'include', 'controls_spaces', 'elseif',
		'-eof_ending',
	))
	->finder($finder)
;
