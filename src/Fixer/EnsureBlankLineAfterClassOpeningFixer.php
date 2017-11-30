<?php

namespace Wucdbm\PhpCsFixer\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Utils;

/**
 * @author Ceeram <ceeram@cakephp.org>
 */
final class EnsureBlankLineAfterClassOpeningFixer extends AbstractFixer implements WhitespacesAwareFixerInterface {

    /**
     * {@inheritdoc}
     */
    public function isCandidate(Tokens $tokens) {
        return $tokens->isAnyTokenKindsFound(Token::getClassyTokenKinds());
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition() {
        return new FixerDefinition(
            'There should be one empty line after class opening brace.',
            [
                new CodeSample(
                    '<?php
final class Sample {
    protected function foo()
    {
    }
}
'
                ),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function applyFix(\SplFileInfo $file, Tokens $tokens) {
        foreach ($tokens as $index => $token) {
            if (!$token->isClassy()) {
                continue;
            }

            $startBraceIndex = $tokens->getNextTokenOfKind($index, ['{']);
            if (!$tokens[$startBraceIndex + 1]->isWhitespace()) {
                continue;
            }

            $this->fixWhitespace($tokens, $startBraceIndex + 1);
        }
    }

    /**
     * Replace any white space with a single blank line.
     *
     * @param Tokens $tokens
     * @param int    $index
     */
    private function fixWhitespace(Tokens $tokens, $index) {
        $content = $tokens[$index]->getContent();
        $lines = Utils::splitLines($content);
        // the final bit of the whitespace must be the next statement's indentation
        $tokens[$index] = new Token([T_WHITESPACE, $this->whitespacesConfig->getLineEnding() . $this->whitespacesConfig->getLineEnding() . end($lines)]);
    }

    public function getPriority() {
        // This should run before NoExtraConsecutiveBlankLinesFixer because of curly_brace_block
        return -25;
    }

    public function getName() {
        return 'Wucdbm/' . parent::getName();
    }
}
