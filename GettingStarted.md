# Using the php target #


Id.g
```
grammar Id;

options{
    language = Php;
}
ids: (id=Id{echo $id.text."\n";})+;

Id: Letter (Letter | '0'..'9' |'_')*;

fragment
Letter: 'A'..'Z'|'a'..'z';

Ws: ('\n' |'\r'|'\t'|' ')+ {$channel=self::\$HIDDEN;};
```
To generate the php files add the anltr jars to the CLASSPATH and run
```
java org.antlr.Tool Id.g
```
This will generate two Php files `IdLexer.php` and `IdParser.php`. You can build a program that uses the new parser.
```
<?php
require 'antlr/antlr.php'; //Path to the antlr runtime files
require 'IdLexer.php';
require 'IdParser.php';

function parser($expr){
        $ass = new ANTLRStringStream($expr);
        $lex = new IdLexer($ass);
        $cts = new CommonTokenStream($lex);
        $par = new IdParser($cts);
        return $par;
}

$par = parser("hello world");
$par->ids();
?>
```
Prints:
```
hello
world
```
# What to watch out for #

## Parameters and return values for rules ##

Rule paramater declarations are prefixed with a dollar as in Php
```
rule [$param]
```
Return value declarations do not have the dollar symbol
```
rule returns [returned]
```
## Php variable names ##

Antlr uses the $ symbol to indicate special variables. Due to this the $ symbol in the php code needs to be escaped.
```
\$total = \$total+(int)$num.text;
```