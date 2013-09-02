<?php

namespace Efficio\Tests\Utilitatis;

use Efficio\Utilitatis\Merger;
use Efficio\Tests\Mock\Utilitatis\PublicMerger;
use PHPUnit_Framework_TestCase;

require_once 'tests/mocks/Utilitatis/PublicMerger.php';

class MergerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Merger
     */
    public $merger;

    public function setUp()
    {
        $this->merger = new Merger;
    }

    public function testMergeFieldsCanBeParsed()
    {
        $fields = PublicMerger::callGetMergeFields(
            'the quick brown {animal1} jumped over the lazy {animal2}');
        $this->assertEquals(['animal1', 'animal2'], $fields);
    }

    public function testMergeFieldsAreNotDuplicated()
    {
        $fields = PublicMerger::callGetMergeFields(
            'the quick brown {animal1} jumped over the lazy {animal2}' .
            'the quick brown {animal1} jumped over the lazy {animal2}');
        $this->assertEquals(['animal1', 'animal2'], $fields);
    }

    public function testMergeFieldGenerator()
    {
        $this->assertEquals('{name}', PublicMerger::callGetMergeField('name'));
    }

    public function testMergeFieldsAreMerged()
    {
        $str = $this->merger->merge('the quick brown {animal1} jumped over the lazy {animal2}', [
            'animal1' => 'fox',
            'animal2' => 'dog',
        ]);
        $this->assertEquals('the quick brown fox jumped over the lazy dog', $str);;
    }

    public function testMissingDataFieldsAreRemoved()
    {
        $str = $this->merger->merge('the quick brown {animal1} jumped over the lazy {animal2}', [
            'animal1' => 'fox',
        ]);
        $this->assertEquals('the quick brown fox jumped over the lazy ', $str);;
    }
}

