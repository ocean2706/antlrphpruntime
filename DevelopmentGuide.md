# What the ANTLR Php Runtime is all about? #

[ANTLR Tool](http://www.antlr.org) is a well known library that has been around for more then a decade. It allows to generate grammatical parsers facilitating in language recognition tasks.
This project concentrates on providing the PHP implementation of the ANTLR runtime.

# ROADMAP #

The idea behind the code placement in the project is to maintain close ressembleness
to the existing structure of the original ANTLR code as well as to introduce a nice modern way of PHP packaging (for example, like it is done in Zend Framework). The main elements are:

  * **runtime**
  * **tool**
  * **examples**

# Codestyle #

In order to produce effective, readable and synchronized code the use of code styles is required. Please, use such PHP tools as [codesniffer](http://pear.php.net/package/PHP_CodeSniffer) to do automated code checks before committing new code. In case of uncertainty or doubt developer is highly encouraged to follow this list of coding standards, sorted according to their descending weight:

  * [Zend coding standard](http://framework.zend.com/manual/en/coding-standard.html)
  * Pear coding standard
  * PHP coding standard

Please, pay attention to the possibility of using codereview requests.

# ANTLR Tool Integration #

To integrate into the org.antlr.Tool (which is written in Java) one has to create
at minimum two files:
  * Java class for implementation of org.antlr.codegen.Target
> > _tool/src/main/java/org/antlr/codegen/PhpTarget.java_
  * Language StringTemplate group file , used for code generation
> > _tool/src/main/resources/org/antlr/codegen/templates/Php/Php.stg_

Now, a very convenient way for frequent introduction of changes into the .stg file
is to pack PHP ANTLR Target into a separate Jar file. After that, one also needs to append this new extension .jar file to the classpath when calling `org.antlr.Tool`. This works perfectly fine, because it is actually a very good example of exploiting the idea of Java packaging for maintaining code extensibility.

## Compiling antlr-php.jar ##

Ant is used to help with the compilation of the PHP target jar. Please see _build.xml_ for technical details. Just invoke `ant` in your project root to recompile and repack the Jar.

## Using org.antlr.Tool ##

The project root contains `antlr-tool.sh` scipt that wraps around org.antlr.Tool, setting up the classpath and passing the arguments. Here goes the usage example:

```
./antlr-tool.sh -make -fo examples/trivialXMLLexer/ examples/trivialXMLLexer/XMLLexer.g
```