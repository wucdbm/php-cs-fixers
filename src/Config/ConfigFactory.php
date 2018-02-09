<?php

/*
 * This file is part of the Wucdbm PhpCSFixers package.
 *
 * (c) Martin Kirilov <wucdbm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wucdbm\PhpCsFixer\Config;

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use Wucdbm\PhpCsFixer\Fixer\EnsureBlankLineAfterClassOpeningFixer;

class ConfigFactory {

    public static function createConfig($dirs): Config {
        $finder = Finder::create()->in($dirs);

        return Config::create()
            ->registerCustomFixers([
                new EnsureBlankLineAfterClassOpeningFixer()
            ])
            ->setRules(self::getConfig())
            ->setFinder($finder);
    }

    public static function createCopyrightedConfig($dirs, string $copyright): Config {
        $finder = Finder::create()->in($dirs);

        $config = self::getConfig();
        $config['header_comment'] = [
            'header' => $copyright
        ];

        return Config::create()
            ->registerCustomFixers([
                new EnsureBlankLineAfterClassOpeningFixer()
            ])
            ->setRules($config)
            ->setFinder($finder);
    }

    protected static function getConfig(): array {
        return [
            '@Symfony' => true,
            'no_blank_lines_after_class_opening' => false,
            'Wucdbm/ensure_blank_line_after_class_opening' => true,
            'array_syntax' => [
                'syntax' => 'short'
            ],
            'braces' => [
                'position_after_functions_and_oop_constructs' => 'same'
            ],
            'trailing_comma_in_multiline_array' => false
        ];
    }
}
