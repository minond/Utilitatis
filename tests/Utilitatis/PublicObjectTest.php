<?php

namespace Efficio\Tests\Utilitatis;

use Efficio\Utilitatis\PublicObject;
use PHPUnit_Framework_TestCase;

class PublicObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PublicObject
     */
    public $obj;

    public function setUp()
    {
        $this->obj = new PublicObject;
    }

    public function testPropertiesSetAreFlaggedAsSetUsingObjectNotation()
    {
        $this->obj->test = 1;
        $this->assertTrue(isset($this->obj->test));
    }

    public function testPropertiesSetAreFlaggedAsSetUsingArrayNotation()
    {
        $this->obj['test'] = 1;
        $this->assertTrue(isset($this->obj['test']));
    }

    public function testPropertiesNotSetAreFlaggedAsNotSetUsingObjectNotation()
    {
        $this->assertFalse(isset($this->obj->test));
    }

    public function testPropertiesNotSetAreFlaggedAsNotSetUsingArrayNotation()
    {
        $this->assertFalse(isset($this->obj['test']));
    }

    public function testPropertiesCanBeRetrivedUsingObjectNotation()
    {
        $this->obj->test = 1;
        $this->assertEquals(1, $this->obj->test);
    }

    public function testPropertiesCanBeRetrivedUsingArrayNotation()
    {
        $this->obj['test'] = 1;
        $this->assertEquals(1, $this->obj['test']);
    }

    public function testDataCanBePassedToConstructor()
    {
        $this->obj = new PublicObject([ 'test' => 0 ]);
        $this->assertTrue(isset($this->obj->test));
    }

    public function testArrayCopyCanBeRetrieved()
    {
        $orig = [ 'test' => 123 ];
        $this->obj = new PublicObject($orig);
        $this->assertEquals($orig, $this->obj->getArrayCopy());
    }

    public function testPropertiesCanBeUnsetUsingObjectNotation()
    {
        $this->obj->test = 1;
        $this->assertEquals(1, $this->obj->test);
        unset($this->obj->test);
        $this->assertFalse(isset($this->obj->test));
    }

    public function testPropertiesCanBeUnsetUsingArrayNotation()
    {
        $this->obj['test'] = 1;
        $this->assertEquals(1, $this->obj['test']);
        unset($this->obj['test']);
        $this->assertFalse(isset($this->obj['test']));
    }
}

