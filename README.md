# Usage

## wucdbm custom rule set with copyright - as per this project's `.php_cs` file

```php
<?php

use Wucdbm\PhpCsFixer\Config\ConfigFactory;

$copyright = <<<COMMENT
This file is part of the Wucdbm PhpCSFixers package.

(c) Martin Kirilov <wucdbm@gmail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
COMMENT;

$finder = PhpCsFixer\Finder::create()->in([
    __DIR__ . '/src',
    __DIR__ . '/tests'
]);

return ConfigFactory::createCopyrightedConfig($copyright)
    ->setUsingCache(false)
    ->setFinder($finder);
```

## wucdbm custom rule set - no copyright

```php
<?php

use Wucdbm\PhpCsFixer\Config\ConfigFactory;

$finder = PhpCsFixer\Finder::create()->in(__DIR__ . '/src');

return ConfigFactory::createConfig()
    ->setUsingCache(false)
    ->setFinder($finder);
```

## In your .php_cs file

```php
<?php 

return PhpCsFixer\Config::create()
    ->registerCustomFixers([
        // Register the Custom Fixer
        new \Wucdbm\PhpCsFixer\Fixer\EnsureBlankLineAfterClassOpeningFixer()
    ])
    ->setRules([
        '@Symfony'                                     => true,
        // And add it to your list of rules
        'Wucdbm/ensure_blank_line_after_class_opening' => true
    ]);
```