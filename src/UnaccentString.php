<?php

namespace App;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;


/**
 * Chaîne sans accent utilisant l'extension PostgreSQL :
 * http://www.postgresql.org/docs/current/static/unaccent.html
 * 
 * Usage : StringFunction UNACCENT(string)
 */
class Unaccent extends FunctionNode
{
    private $string;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'UNACCENT(' . $this->string->dispatch($sqlWalker) . ")";
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->string = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
