<?php

require_once 'PHPUnit/Framework.php';
require_once "antlr.php";
require_once "t022scopesLexer.php";
require_once "t022scopesParser.php";
class ParserTest022 extends PHPUnit_Framework_TestCase{
	protected function setUp(){
	}
	
	protected function tearDown(){
	}
    

	function testa1(){
		$parser = $this->parser('foobar');
		$parser->a();
	}

	function testb1(){
		$parser = $this->parser('foobar');

		try{
			$parser->b(false);
			self::fail();
		}catch (Exception $re){}
	}
	
	function testb2(){
		$parser = $this->parser('foobar');
		$parser->b(true);
	}

	function testc1(){
		$parser = $this->parser('
            {
                int i;
                int j;
                i = 0;
            }
            ');
		$symbols = $parser->c();

		self::assertEquals($symbols, array('i', 'j'));
	}

	function testc2(){
		$parser = $this->parser('
            {
                int i;
                int j;
                i = 0;
                x = 4;
            }
            ');

		try{
			$parser->c();
			self.fail();
		}catch(Exception $exc){
			self::assertEquals($exc->getMessage(), 'x');
		}
	}
	
	function testd1(){
		$parser = $this->parser('
            {
                int i;
                int j;
                i = 0;
                {
                    int i;
                    int x;
                    x = 5;
                }
            }
            ');
		$symbols = $parser->d();

		self::assertEquals($symbols, array('i', 'j'));
	}
	
    function teste1(){
		$parser = $this->parser('
            { { { { 12 } } } }
            ');
		$res = $parser->e();

		self::assertEquals($res, 12);
	}

	function testf1(){
		$parser = $this->parser('
            { { { { 12 } } } }
            ');

		$res = $parser->f();
		self::assertEquals($res, null);
	}
	
    function testf2(){
		$parser = $this->parser('{ { 12 } }');
		$res = $parser->f();

		self::assertEquals($res, null);
	}


	function parser($expr){
		$ass = new ANTLRStringStream($expr);
		$lex = new t022scopesLexer($ass);
		$cts = new CommonTokenStream($lex);
		$tap = new t022scopesParser($cts);
		return $tap;
	}
	
	function readFile($filename){
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		return $contents;
	}
}

?>