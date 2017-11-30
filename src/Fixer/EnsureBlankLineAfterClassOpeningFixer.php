<?php

namespace Wucdbm\PhpCsFixer\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

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

            $whitespace = $this->createBlankLine($tokens, $startBraceIndex);
            $nextTokenIndex = $startBraceIndex + 1;

            if (!$tokens[$nextTokenIndex]->isWhitespace()) {
                // If there is no white space at all, we need two lines and a single indentation
                // But in case the declaration is wrapped in an if statement,
                // Then we need the current indentation plus one additional
                $tokens->insertAt($nextTokenIndex, new Token([T_WHITESPACE, $whitespace]));
            } else {
                // If there is any white space, then we can just replace it
                // What we need is two line endings, the class declaration indentation
                // And another indent for any following token (property, constant, method, etc)
                $tokens[$nextTokenIndex] = new Token([T_WHITESPACE, $whitespace]);
            }
        }
    }

    private function createBlankLine(Tokens $tokens, $startBraceIndex) {
        $classDeclarationIndent = $this->detectIndent($tokens, $startBraceIndex);

        return $this->whitespacesConfig->getLineEnding() . $this->whitespacesConfig->getLineEnding() . $classDeclarationIndent . $this->whitespacesConfig->getIndent();
    }

    public function getPriority() {
        // This should run before NoExtraConsecutiveBlankLinesFixer because of curly_brace_block
        return -25;
    }

    public function getName() {
        return 'Wucdbm/' . parent::getName();
    }

    /**
     * This has been blatantly stolen from BracesFixer and does an excellent job
     *
     * @param Tokens $tokens
     * @param int    $index
     *
     * @return string
     */
    private function detectIndent(Tokens $tokens, $index) {
        while (true) {
            $whitespaceIndex = $tokens->getPrevTokenOfKind($index, [[T_WHITESPACE]]);

            if (null === $whitespaceIndex) {
                return '';
            }

            $whitespaceToken = $tokens[$whitespaceIndex];

            if (false !== strpos($whitespaceToken->getContent(), "\n")) {
                break;
            }

            $prevToken = $tokens[$whitespaceIndex - 1];

            if ($prevToken->isGivenKind([T_OPEN_TAG, T_COMMENT]) && "\n" === substr($prevToken->getContent(), -1)) {
                break;
            }

            $index = $whitespaceIndex;
        }

        if (!isset($whitespaceToken)) {
            return '';
        }

        $explodedContent = explode("\n", $whitespaceToken->getContent());

        return end($explodedContent);
    }
}
