<?php

$headerComment = <<<COMMENT
This file is part of the Wucdbm PhpCSFixers package.

(c) Martin Kirilov <wucdbm@gmail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
COMMENT;

$finder = PhpCsFixer\Finder::create()->in([
    __DIR__ . '/src',
    __DIR__ . '/tests'
]);

return PhpCsFixer\Config::create()
    ->registerCustomFixers([
        new \Wucdbm\PhpCsFixer\Fixer\EnsureBlankLineAfterClassOpeningFixer()
    ])
    ->setRules([
        '@Symfony'                                     => true,
        'no_blank_lines_after_class_opening'           => false,
        'Wucdbm/ensure_blank_line_after_class_opening' => true,
        'array_syntax'                                 => [
            'syntax' => 'short'
        ],
        'braces'                                       => [
            'position_after_functions_and_oop_constructs' => 'same'
        ],
        'trailing_comma_in_multiline_array'            => false,
        'header_comment'                               => [
            'header' => $headerComment
        ]
    ])
    ->setUsingCache(false)
    ->setFinder($finder);