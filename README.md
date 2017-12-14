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