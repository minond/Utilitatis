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

    public function testPropertiesSetAreFlaggedAsSet()
    {
        $this->obj->test = 1;
        $this->assertTrue(isset($this->obj->test));
    }

    public function testPropertiesNotSetAreFlaggedAsNotSet()
    {
        $this->assertFalse(isset($this->obj->test));
    }

    public function testPropertiesCanBeRetrived()
    {
        $this->obj->test = 1;
        $this->assertEquals(1, $this->obj->test);
    }

    public function testDataCanBePassedToConstructor()
    {
        $this->obj = new PublicObject([ 'test' => 0 ]);
        $this->assertTrue(isset($this->obj->test));
    }

    public function testPropertiesCanBeUnset()
    {
        $this->obj->test = 1;
        $this->assertEquals(1, $this->obj->test);
        unset($this->obj->test);
        $this->assertFalse(isset($this->obj->test));
    }
}

