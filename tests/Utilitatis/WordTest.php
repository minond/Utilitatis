<?php

namespace Efficio\Tests\Utilitatis;

use Efficio\Utilitatis\Word;
use PHPUnit_Framework_TestCase;

class WordTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Word
     */
    public $word;

    public function setUp()
    {
        $this->word = new Word;
    }

    public function dataProviderStrings()
    {
        return [
            [ 'property name' ],
            [ 'property_name' ],
            [ 'PropertyName' ],
            [ 'propertyName' ],
        ];
    }

    public function dataForPluralizing()
    {
        // [ sigle, expected ]
        return [
            [ 'company', 'companies' ],
            [ 'person', 'people' ],
            [ 'cat', 'cats' ],
            [ 'single', 'singles' ],
            [ 'canoe', 'canoes' ],
            [ 'moose', 'moose' ],
        ];
    }

    public function testNewWordsCanBeCreated()
    {
        $this->assertTrue($this->word instanceof Word);
    }

    public function testNewSpecialPluralFormsCanBeAdded()
    {
        $this->assertTrue($this->word->pluralForm('special', 'specials~~'));
    }

    public function testNewSpecialPluralFormsCannotBeOverwrittenByDefault()
    {
        $this->assertTrue($this->word->pluralForm('special', 'specials~~'));
        $this->assertFalse($this->word->pluralForm('special', 'specials2~~'));
    }

    public function testNewSpecialPluralFormsCanByOverwrittenWhenSpecifiedTo()
    {
        $this->assertTrue($this->word->pluralForm('special', 'specials~~'));
        $this->assertTrue($this->word->pluralForm('special', 'specials2~~', true));
    }

    public function testSpecialWordsCanBePluralized()
    {
        $this->assertEquals('oxen', $this->word->pluralize('ox'));
    }

    public function testNewSpecialWordsCanBeAddedAndAreUsed()
    {
        $this->word->pluralForm('special', 'specials~~');
        $this->assertEquals('specials~~', $this->word->pluralize('special'));
    }

    public function testExistingSpecialPluralFormsCanBeOverwritten()
    {
        $this->word->pluralForm('ox', 'oxen~~');
        $this->assertEquals('oxen~~', $this->word->pluralize('ox'));
    }

    public function testNonSEndingWordsAreAppendedTheLetterSByDefault()
    {
        $this->assertEquals('Marcos', $this->word->pluralize('Marco'));
    }

    public function testSEndingWordsAreNotAppendedTheLetterS()
    {
        $this->assertEquals('Marcos', $this->word->pluralize('Marcos'));
    }

    /**
     * @dataProvider dataForPluralizing
     */
    public function testPluralizeWords($single, $expected)
    {
        $this->assertEquals($expected, $this->word->pluralize($single));
    }

    public function testWordsWithIdenticalSingluarAndPluralForm()
    {
        $this->assertEquals('bison', $this->word->pluralize('bison'));
    }

    /**
     * @dataProvider dataProviderStrings
     */
    public function testConvertingToHumanCase($str)
    {
        $this->assertEquals('property name', $this->word->humanCase($str));
    }

    /**
     * @dataProvider dataProviderStrings
     */
    public function testConvertingToClassicalCase($str)
    {
        $this->assertEquals('PropertyName', $this->word->classicalCase($str));
    }

    /**
     * @dataProvider dataProviderStrings
     */
    public function testConvertingToCamelCase($str)
    {
        $this->assertEquals('propertyName', $this->word->camelCase($str));
    }

    /**
     * @dataProvider dataProviderStrings
     */
    public function testConvertingToPropertyCase($str)
    {
        $this->assertEquals('property_name', $this->word->propertyCase($str));
    }
}

