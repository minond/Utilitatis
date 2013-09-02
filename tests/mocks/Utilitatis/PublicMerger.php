<?php

namespace Efficio\Tests\Mock\Utilitatis;

use Efficio\Utilitatis\Merger;

class PublicMerger extends Merger
{
    public static function callGetMergeFields($str)
    {
        return self::getMergeFields($str);
    }

    public static function callGetMergeField($field)
    {
        return self::getMergeField($field);
    }
}

