<?php

$finder = (new PhpCsFixer\Finder())
    ->in('src')
    ->exclude(['vendor'])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_no_alias_tag' => ['replacements' => ['type' => 'var', 'link' => 'see']],
    ])
    ->setFinder($finder)
;
