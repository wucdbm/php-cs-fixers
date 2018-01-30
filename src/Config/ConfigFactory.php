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
use Wucdbm\PhpCsFixer\Fixer\EnsureBlankLineAfterClassOpeningFixer;

class ConfigFactory {

    public static function createConfig(): Config {
        return Config::create()
            ->registerCustomFixers([
                new EnsureBlankLineAfterClassOpeningFixer()
            ])
            ->setRules(self::getConfig());
    }

    public static function createCopyrightedConfig(string $copyright): Config {
        $config = self::getConfig();
        $config['header_comment'] = [
            'header' => $copyright
        ];

        return Config::create()
            ->registerCustomFixers([
                new EnsureBlankLineAfterClassOpeningFixer()
            ])
            ->setRules($config);
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
