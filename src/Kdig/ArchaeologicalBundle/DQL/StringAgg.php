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
    public $secondExpression = null;
    public $delimiter = null;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        // use second parameter if parsed
        if (null !== $this->secondExpression){
            return 'string_agg(' 
                . $this->expression->dispatch($sqlWalker)
                . ', '
                . $this->secondExpression->dispatch($sqlWalker)
                . ')';
        }

        return 'string_agg(' .
            $this->expression->dispatch($sqlWalker)
            .')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expression = $parser->SingleValuedPathExpression();
        
        // parse second parameter if available
        if(Lexer::T_COMMA === $lexer->lookahead['type']){
            $parser->match(Lexer::T_COMMA);
            $this->secondExpression = $parser->ArithmeticPrimary();
        }
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}