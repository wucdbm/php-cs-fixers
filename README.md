# Usage

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

return ConfigFactory::createCopyrightedConfig([
    __DIR__ . '/src',
    __DIR__ . '/tests'
], $copyright)
    ->setUsingCache(false);
```

## wucdbm custom rule set - no copyright

```php
<?php

use Wucdbm\PhpCsFixer\Config\ConfigFactory;

return ConfigFactory::createConfig(__DIR__ . '/src')
    ->setUsingCache(false);
```