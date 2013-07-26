<?php

namespace Efficio\Utilitatis;

/**
 * words manager
 */
class Word
{
    /**
     * @see http://answers.yahoo.com/question/index?qid=20090416095945AAaMI28
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
        $word = strtolower($word);
        $specials = array_merge(static::$specials, $this->myspecials);

        if (array_key_exists($word, $specials)) {
            $word = $specials[ $word ];
        } else if (substr($word, -1) !== 's') {
            // yup
            $word .= 's';
        }

        return $word;
    }
}
