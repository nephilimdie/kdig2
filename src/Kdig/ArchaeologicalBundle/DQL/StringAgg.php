<?php

namespace Kdig\ArchaeologicalBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * Usage: STRING_AGG(expr, delimiter)
 * Input values are concatenated into a string, separated by delimiter.
 *
 * string_agg(expr, delimiter) is evaluated.
 *
 * @author Yoann PETIT <abhroyo@free.fr>
 * @version 2013.07.03
 */
class StringAgg extends FunctionNode
{
    public $expression = null;
    public $delimiter = null;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'string_agg(' .
            $this->expression->dispatch($sqlWalker) . ', ' .
            $this->delimiter->dispatch($sqlWalker) .
        ')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expression = $parser->SingleValuedPathExpression();
        if($parser->match(Lexer::T_COMMA))
            $this->delimiter = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}