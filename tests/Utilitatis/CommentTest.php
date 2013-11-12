<?php

namespace Efficio\Tests\Utilitatis;

use Efficio\Utilitatis\Comment;
use PHPUnit_Framework_TestCase;

/**
 * Lorem ipsum dolor sit amet
 */
class CommentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Comment
     */
    public $comment;

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
        $this->comment = new Comment(__CLASS__);
    }

    public function testRawClassCommentsCanBeRetrieved()
    {
        $this->expectOutputString('/**
 * Lorem ipsum dolor sit amet
 */');
        echo $this->comment->raw();
    }

    /**
     * Lorem ipsum dolor sit amet 2
     */
    public function testRawMethodCommentsCanBeRetrieved()
    {
        $this->expectOutputString('/**
     * Lorem ipsum dolor sit amet 2
     */');
        echo $this->comment->raw(__FUNCTION__);
    }

    public function testRawPropertyCommentsCanBeRetrieved()
    {
        $this->expectOutputString('/**
     * Lorem ipsum dolor sit amet 3
     */');
        echo $this->comment->raw('dummyproperty');
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
        ], Comment::clean('
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
        ], Comment::parse('
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
        echo $this->comment->doc('dummyproperty2', 'note');
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
        ], $this->comment->doc('dummyproperty2'));
    }

    public function testArrayPropertiesCanBeRetrieved()
    {
        $this->assertEquals([
            'string $one',
            'string $two',
            'string $three',
        ], $this->comment->doc('dummyproperty2', 'param'));
    }
}

