<?php

$finder = PhpCsFixer\Finder::create()
	->exclude('var/cache')
	->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config
	->setRules([
		'@PER' => true,
		'array_syntax' => ['syntax' => 'short'],
		'binary_operator_spaces' => ['default' => 'single_space'],
		'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
		'no_extra_blank_lines' => true,
		'no_singleline_whitespace_before_semicolons' => true,
		'no_trailing_comma_in_singleline_array' => true,
		'trailing_comma_in_multiline' => ['elements' => ['arguments', 'arrays', 'match', 'parameters']],
	])
	->setIndent('	')
	->setFinder($finder)
;
