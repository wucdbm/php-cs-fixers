<?php

/*
 * This file is part of the Wucdbm PhpCSFixers package.
 *
 * (c) Martin Kirilov <wucdbm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wucdbm\PhpCsFixer\Tests\Fixer;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;

/**
 * @author Martin Kirilov <wucdbm@gmail.com>
 *
 * @internal
 *
 * @covers \Wucdbm\PhpCsFixer\Fixer\EnsureBlankLineAfterClassOpeningFixer
 */
class EnsureBlankLineAfterClassOpeningFixerTest extends AbstractFixerTestCase {

    /**
     * @param string      $expected
     * @param null|string $input
     *
     * @dataProvider provideFixCases
     */
    public function testFix($expected, $input = null) {
        $this->doTest($expected, $input);
    }

    protected function createFixerFactory() {
        $factory = parent::createFixerFactory();

        $factory->registerCustomFixers([
            new \Wucdbm\PhpCsFixer\Fixer\EnsureBlankLineAfterClassOpeningFixer()
        ]);

        return $factory;
    }

    protected function getFixerName() {
        return (new \Wucdbm\PhpCsFixer\Fixer\EnsureBlankLineAfterClassOpeningFixer())->getName();
    }

    public function provideFixCases() {
        return [
            'Empty Class Same Line' => [
                '<?php

class Test {

}',
                '<?php

class Test {}'
            ],
            'Empty Class Two Lines' => [
                '<?php

class Test {

}',
                '<?php

class Test {
}'
            ],
            'Empty Class Same Line Indented' => [
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {

    }
}',
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {}
}'
            ],
            'Empty Class Two Lines Indented' => [
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {

    }
}',
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {
    }
}'
            ],
            'Non-WS Token Immediately After Class Declaration' => [
                '<?php

class Test {

    /** @var EntityReferenceHelper */
    private $referenceHelper;
}',
                '<?php

class Test {/** @var EntityReferenceHelper */
    private $referenceHelper;
}'
            ],
            'Non-WS Token Immediately After Class Declaration Indented' => [
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {

        /** @var EntityReferenceHelper */
        private $referenceHelper;
}
}',
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {/** @var EntityReferenceHelper */
        private $referenceHelper;
}
}'
            ],
            'WS Token After Class Opening' => [
                '<?php

class Test {

    /** @var EntityReferenceHelper */
    private $referenceHelper;
}',
                '<?php

class Test {     /** @var EntityReferenceHelper */
    private $referenceHelper;
}'
            ],
            'WS Token After Class Opening Indented' => [
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {

        /** @var EntityReferenceHelper */
        private $referenceHelper;
    }
}',
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {     /** @var EntityReferenceHelper */
        private $referenceHelper;
    }
}'
            ],
            'Lots Of WS After Class Opening' => [
                '<?php

class Test {

    /** @var EntityReferenceHelper */
    private $referenceHelper;
}',
                '<?php

class Test {



    /** @var EntityReferenceHelper */
    private $referenceHelper;
}'
            ],
            'Lots Of WS After Class Opening Indented' => [
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {

        /** @var EntityReferenceHelper */
        private $referenceHelper;
    }
}',
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {



        /** @var EntityReferenceHelper */
        private $referenceHelper;
    }
}'
            ],
            'Lots Of WS And Wrog Indentation of Next NON-WS Token' => [
                '<?php

class Test {

    /** @var EntityReferenceHelper */
    private $referenceHelper;



}',
                '<?php

class Test {



        /** @var EntityReferenceHelper */
    private $referenceHelper;



}'
            ],
            'Lots Of WS And Wrog Indentation of Next NON-WS Token Indented' => [
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {

        /** @var EntityReferenceHelper */
        private $referenceHelper;



    }
}',
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    class Test {



            /** @var EntityReferenceHelper */
        private $referenceHelper;



    }
}'
            ],
            'More Than One Indentation Extra Lines' => [
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    if (!class_exists(\'Some\Name\Space\')) {
        class Test {

            /** @var EntityReferenceHelper */
            private $referenceHelper;
        }
    }
}',
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    if (!class_exists(\'Some\Name\Space\')) {
        class Test {


            /** @var EntityReferenceHelper */
            private $referenceHelper;
        }
    }
}'
            ],
            'More Than One Indentation No WS' => [
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    if (!class_exists(\'Some\Name\Space\')) {
        class Test {

            /** @var EntityReferenceHelper */
            private $referenceHelper;
        }
    }
}',
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    if (!class_exists(\'Some\Name\Space\')) {
        class Test {/** @var EntityReferenceHelper */
            private $referenceHelper;
        }
    }
}'
            ],
            'More Than One Indentation No Lines With WS' => [
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    if (!class_exists(\'Some\Name\Space\')) {
        class Test {

            /** @var EntityReferenceHelper */
            private $referenceHelper;
        }
    }
}',
                '<?php

if (!class_exists(\'Some\Name\Space\')) {
    if (!class_exists(\'Some\Name\Space\')) {
        class Test {/** @var EntityReferenceHelper */
            private $referenceHelper;
        }
    }
}'
            ]
        ];
    }
}
