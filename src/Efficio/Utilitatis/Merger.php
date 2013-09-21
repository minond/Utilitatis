<?php

namespace Efficio\Utilitatis;

/**
 * basic string merging
 */
class Merger
{
    /**
     * get merge fields form a string: the quick brown {animal1} jumped over
     * the lazy {animal2} => [ animal1, animal2 ]
     * @param string $str
     * @return array
     */
    protected static function getMergeFields($str)
    {
        preg_match_all('/\{(.+?)\}/', $str, $matches);
        return is_array($matches) && isset($matches[1]) ?
            array_unique($matches[1]) : [];
    }

    /**
     * convert a field into a merge field
     * @param string $field
     * @return string
     */
    protected static function getMergeField($field)
    {
        return sprintf('{%s}', $field);
    }

    /**
     * @param string $str
     * @param array $data
     * @param boolean $all, replace all merge fields, regardless of it being
     * included in the data array
     * @return array
     */
    public function merge($str, $data, $all = true)
    {
        foreach (self::getMergeFields($str) as $field) {
            if ($all || isset($data[ $field ])) {
                $val = isset($data[ $field ]) ? $data[ $field ] : '';
                $str = str_replace(self::getMergeField($field), $val, $str);
            }
        }

        return $str;
    }
}

