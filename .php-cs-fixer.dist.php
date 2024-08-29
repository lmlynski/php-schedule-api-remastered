<?php

declare(strict_types=1);

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'yoda_style' => false,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'cast_spaces' => false,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'single_line_throw' => false,
        'phpdoc_separation' => false,
    ])
    ->setFinder(
        (new PhpCsFixer\Finder())->in([
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ])
    );
