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
        $this->assertEquals('marcos', $this->word->pluralize('Marco'));
    }

    public function testSEndingWordsAreNotAppendedTheLetterS()
    {
        $this->assertEquals('marcos', $this->word->pluralize('Marcos'));
    }
}
