<?php
declare(strict_types=1);

$customFinder = PhpCsFixer\Finder::create()
	->exclude('vendor')
	->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
		'@PSR12' => true,
		'elseif' => true,
		'indentation_type' => true,
		'no_empty_comment' => true,
		'blank_line_before_statement' => true,
		'no_unused_imports' => true,
		'no_superfluous_phpdoc_tags' => true,
		'no_extra_blank_lines' => true,
		'no_trailing_whitespace' => true,
		'no_whitespace_in_blank_line' => true,
		'no_blank_lines_after_class_opening' => true,
		'no_blank_lines_after_phpdoc' => true
	])
	->setIndent("\t")
	->setFinder($customFinder)
;
