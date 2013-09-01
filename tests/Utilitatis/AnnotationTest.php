<?php

namespace Efficio\Tests\Utilitatis;

use Efficio\Utilitatis\Annotation;
use PHPUnit_Framework_TestCase;

/**
 * Lorem ipsum dolor sit amet
 */
class AnnotationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Annotation
     */
    public $ann;

    /**
     * Lorem ipsum dolor sit amet 3
     */
    public $dummyproperty;

    /**
     * @note hello, world
     *
     * Ut wisi enim ad minim veniam, quis nostrud exerci tation
     * ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
     * consequat. Duis autem vel eum iriure dolor in hendrerit in
     * vulputate velit esse molestie consequat, vel illum dolore
     *
     * Ut wisi enim ad minim veniam, quis nostrud exerci tation
     * ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
     * consequat. Duis autem vel eum iriure dolor in hendrerit in
     * vulputate velit esse molestie consequat, vel illum dolore
     *
     * @todo hello
     *
     * Ut wisi enim ad minim veniam, quis nostrud exerci tation
     * ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
     * consequat. Duis autem vel eum iriure dolor in hendrerit in
     * vulputate velit esse molestie consequat, vel illum dolore
     *
     * @param string $one
     * @param string $two
     * @param string $three
     * @return string three
     */
    public $dummyproperty2;

    public function setUp()
    {
        $this->ann = new Annotation(__CLASS__);
    }

    public function testRawClassCommentsCanBeRetrieved()
    {
        $this->expectOutputString('/**
 * Lorem ipsum dolor sit amet
 */');
        echo $this->ann->raw();
    }

    /**
     * Lorem ipsum dolor sit amet 2
     */
    public function testRawMethodCommentsCanBeRetrieved()
    {
        $this->expectOutputString('/**
     * Lorem ipsum dolor sit amet 2
     */');
        echo $this->ann->raw(__FUNCTION__);
    }

    public function testRawPropertyCommentsCanBeRetrieved()
    {
        $this->expectOutputString('/**
     * Lorem ipsum dolor sit amet 3
     */');
        echo $this->ann->raw('dummyproperty');
    }

    public function testStringsAreCleanedUp()
    {
        $this->assertEquals([
            'Ut wisi enim ad minim veniam, quis nostrud exerci tation',
            'ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo',
            'consequat. Duis autem vel eum iriure dolor in hendrerit in',
            'vulputate velit esse molestie consequat, vel illum dolore',
            '@param string $one',
            '@param string $two',
            '@param string $three',
            '@return string three',
        ], Annotation::clean('
          /**
           * Ut wisi enim ad minim veniam, quis nostrud exerci tation
           * ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
           * consequat. Duis autem vel eum iriure dolor in hendrerit in
           * vulputate velit esse molestie consequat, vel illum dolore
           * @param string $one
           * @param string $two
           * @param string $three
           * @return string three
           */
        '));
    }

    public function testStringsAreParsed()
    {
        $this->assertEquals([
            'Ut wisi enim ad minim veniam, quis nostrud exerci tation ' .
            'ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo ' .
            'consequat. Duis autem vel eum iriure dolor in hendrerit in ' .
            'vulputate velit esse molestie consequat, vel illum dolore ' .
            'Ut wisi enim ad minim veniam, quis nostrud exerci tation ' .
            'ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo ' .
            'consequat. Duis autem vel eum iriure dolor in hendrerit in ' .
            'vulputate velit esse molestie consequat, vel illum dolore ' .
            'Ut wisi enim ad minim veniam, quis nostrud exerci tation ' .
            'ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo ' .
            'consequat. Duis autem vel eum iriure dolor in hendrerit in ' .
            'vulputate velit esse molestie consequat, vel illum dolore',
            'note' => 'hello, world',
            'todo' => 'hello',
            'return' => 'string three',
            'param' => [
                'string $one',
                'string $two',
                'string $three',
            ],
        ], Annotation::parse('
          /**
           * @note hello, world
           *
           * Ut wisi enim ad minim veniam, quis nostrud exerci tation
           * ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
           * consequat. Duis autem vel eum iriure dolor in hendrerit in
           * vulputate velit esse molestie consequat, vel illum dolore
           *
           * Ut wisi enim ad minim veniam, quis nostrud exerci tation
           * ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
           * consequat. Duis autem vel eum iriure dolor in hendrerit in
           * vulputate velit esse molestie consequat, vel illum dolore
           *
           * @todo hello
           *
           * Ut wisi enim ad minim veniam, quis nostrud exerci tation
           * ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
           * consequat. Duis autem vel eum iriure dolor in hendrerit in
           * vulputate velit esse molestie consequat, vel illum dolore
           *
           * @param string $one
           * @param string $two
           * @param string $three
           * @return string three
           */
        '));
    }

    public function testSinglePropertiesCanBeRetrieved()
    {
        $this->expectOutputString('hello, world');
        echo $this->ann->doc('dummyproperty2', 'note');
    }

    public function testWholeDocumentStringCanBeReteived()
    {
        $this->assertEquals([
            'Ut wisi enim ad minim veniam, quis nostrud exerci tation ' .
            'ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo ' .
            'consequat. Duis autem vel eum iriure dolor in hendrerit in ' .
            'vulputate velit esse molestie consequat, vel illum dolore ' .
            'Ut wisi enim ad minim veniam, quis nostrud exerci tation ' .
            'ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo ' .
            'consequat. Duis autem vel eum iriure dolor in hendrerit in ' .
            'vulputate velit esse molestie consequat, vel illum dolore ' .
            'Ut wisi enim ad minim veniam, quis nostrud exerci tation ' .
            'ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo ' .
            'consequat. Duis autem vel eum iriure dolor in hendrerit in ' .
            'vulputate velit esse molestie consequat, vel illum dolore',
            'note' => 'hello, world',
            'todo' => 'hello',
            'return' => 'string three',
            'param' => [
                'string $one',
                'string $two',
                'string $three',
            ],
        ], $this->ann->doc('dummyproperty2'));
    }

    public function testArrayPropertiesCanBeRetrieved()
    {
        $this->assertEquals([
            'string $one',
            'string $two',
            'string $three',
        ], $this->ann->doc('dummyproperty2', 'param'));
    }
}

