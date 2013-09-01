<?php

namespace Efficio\Utilitatis;

use ReflectionClass;

/**
 * annotation reader
 */
class Annotation
{
    /**
     * param character
     */
    const JDOC_CHAR = '@';

    /**
     * reflection of class
     * @var ReflectionClass
     */
    protected $rclass;

    /**
     * name of class
     * @var string
     */
    protected $sclass;

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->sclass = $class;
        $this->rclass = new ReflectionClass($class);
    }

    /**
     * returns comments for a class, a method, or a property
     * @param string $sub, default = null
     * @return string
     */
    public function raw($sub = null)
    {
        $obj = $this->rclass;

        if (method_exists($this->sclass, $sub)) {
            $obj = $obj->getMethod($sub);
        } else if (property_exists($this->sclass, $sub)) {
            $obj = $obj->getProperty($sub);
        }

        return $obj->getDocComment();
    }

    /**
     * returns parsed comments/comment for a class, a method, or a property
     * @param string $sub, default = null
     * @param string $key, default = null
     * @return array
     */
    public function doc($sub = null, $key = null)
    {
        $comment = $this->raw($sub);
        $comment = $comment ? self::parse($comment) : [];

        if (!is_null($key)) {
            $comment = isset($comment[ $key ]) ? $comment[ $key ] : null;
        }

        return $comment;
    }

    /**
     * cleans up a doc comment
     * @param string $raw
     * @return array
     */
    public static function clean($raw)
    {
        $raw = trim($raw);
        $lines = explode(PHP_EOL, $raw);
        array_pop($lines);
        array_shift($lines);

        return array_map(function ($line) {
            return preg_replace('/^\*\s{0,}/', '', trim($line));
        }, $lines);
    }

    /**
     * parse a doc comment
     * @param string|array $lines
     * @return array
     */
    public static function parse($lines)
    {
        $parse = [];
        $lines = is_array($lines) ? $lines : self::clean($lines);

        foreach ($lines as $line) {
            if (substr($line, 0, 1) === self::JDOC_CHAR) {
                $key = substr($line, 1, strpos($line, ' ') - 1);
                $str = substr($line, strpos($line, ' ') + 1);
                $str = trim($str);

                if (isset($parse[ $key ])) {
                    if (!is_array($parse[ $key ])) {
                        $parse[ $key ] = [ $parse[ $key ] ];
                    }

                    $parse[ $key ][] = $str;
                } else {
                    $parse[ $key ] = $str;
                }
            } else {
                $orig = isset($parse[ 0 ]) ? $parse[ 0 ] : '';
                $parse[ 0 ] = trim($orig . ' ' . $line);
            }
        }

        return $parse;
    }
}

