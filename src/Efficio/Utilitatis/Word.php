<?php

namespace Efficio\Utilitatis;

/**
 * words manager
 * http://en.wikipedia.org/wiki/English_plurals
 */
class Word
{
    /**
     * words that have an indentical single and plural form
     * http://en.wikipedia.org/wiki/English_plurals#Nouns_with_identical_singular_and_plural
     * @var array
     */
    protected static $identical = [
        'bison',
        'buffalo',
        'deer',
        'fish',
        'moose',
        'pike',
        'sheep',
        'salmon',
        'trout',
        'swine',
        'plankton',
        'squid',
    ];

    /**
     * http://answers.yahoo.com/question/index?qid=20090416095945AAaMI28
     * @var array
     */
    protected static $specials = [
        'alumna' => 'alumnae',
        'alumnus' => 'alumni',
        'appendix' => 'appendices',
        'bracket' => 'braces*',
        'bureau' => 'bureaux',
        'cactus' => 'cacti',
        'cherub' => 'cherubim',
        'child' => 'children',
        'cow' => 'kine',
        'criterion' => 'criteria',
        'curriculum' => 'curricula',
        'datum' => 'data',
        'dice' => 'die',
        'focus' => 'foci',
        'foot' => 'feet',
        'formula' => 'formulae',
        'forum' => 'fora',
        'fungus' => 'fungi',
        'goose' => 'geese',
        'hippopotamus' => 'hippopotami',
        'index' => 'indices',
        'louse' => 'lice',
        'man' => 'men',
        'medium' => 'media',
        'mouse' => 'mice',
        'nautilus' => 'nautili',
        'nucleus' => 'nuclei',
        'octopus' => 'octopi',
        'ox' => 'oxen',
        'person' => 'people',
        'phenomenon' => 'phenomena',
        'stadium' => 'stadia',
        'stimulus' => 'stimuli',
        'supernova' => 'supernovae',
        'syllabus' => 'syllabi',
        'woman' => 'women',

        'cherry' => 'cherries',
        'lady' => 'ladies',
        'sky' => 'skies',

        'calf' => 'calves',
        'leaf' => 'leaves',
        'knife' => 'knives',
        'life' => 'lives',

        'kiss' => 'kisses',
        'dish' => 'dishes',
        'witch' => 'witches',
        'hero' => 'heroes',
        'potato' => 'potatoes',
        'volcano' => 'volcanoes',
    ];

    /**
     * just like the 'specials' array, but specific to this instance
     * @see Word::specials
     */
    protected $myspecials = [];

    /**
     * add/overwrite a special plural form
     * @param string $singular
     * @param string $plural
     * @param boolean $allowoverwrite
     * @return boolean
     */
    public function pluralForm($singular, $plural, $allowoverwrite = false)
    {
        $added = false;
        $singular = strtolower($singular);
        $plural = strtolower($plural);

        if (!array_key_exists($singular, $this->myspecials) || $allowoverwrite) {
            $this->myspecials[ $singular ] = $plural;
            $added = true;
        }

        return $added;
    }

    /**
     * pluralize a word
     * @param string $word
     * @return string
     */
    public function pluralize($word)
    {
        $sword = strtolower($word);
        $specials = array_merge(static::$specials, $this->myspecials);

        if (!in_array($word, static::$identical)) {
            if (array_key_exists($sword, $specials)) {
                $word = $specials[ $sword ];
            } else if (substr($word, -1) === 'y') {
                $word = substr($word, 0, -1) . 'ies';
            } else if (substr($word, -1) !== 's') {
                $word .= 's';
            }
        }

        return $word;
    }

    /**
     * property name = property name
     * property_name = property name
     * PropertyName = property name
     * propertyName = property name
     * @param string $word
     * @return string
     */
    public function humanCase($word)
    {
        return trim(strtolower(str_replace('_', ' ',
            preg_replace('/([A-Z])/', ' $1', $word))));
    }

    /**
     * property name = PropertyName
     * @param string $word
     * @return string
     */
    public function classicalCase($word)
    {
        return str_replace(' ', '', ucwords($this->humanCase($word)));
    }

    /**
     * property name = propertyName
     * @param string $word
     * @return string
     */
    public function camelCase($word)
    {
        return lcfirst($this->classicalCase($word));
    }

    /**
     * property name = property_name
     * @param string $word
     * @return string
     */
    public function propertyCase($word)
    {
        return str_replace(' ', '_', $this->humanCase($word));
    }
}

