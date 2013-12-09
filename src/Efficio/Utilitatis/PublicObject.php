<?php

namespace Efficio\Utilitatis;

use ArrayAccess;

/**
 * easy to work with objects
 */
class PublicObject implements ArrayAccess
{
    /**
     * internal storage
     * @var array
     */
    protected $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (count($data)) {
            $this->data = $data;
        }
    }

    /**
     * @param string $var
     * @param mixed $val
     */
    public function __set($var, $val)
    {
        $this->data[ $var ] = $val;
    }

    /**
     * @param string $var
     */
    public function __get($var)
    {
        return $this->data[ $var ];
    }

    /**
     * @param string $var
     */
    public function __isset($var)
    {
        return isset($this->data[ $var ]);
    }

    /**
     * @param string $var
     */
    public function __unset($var)
    {
        unset($this->data[ $var ]);
        return true;
    }

    /**
     * @param string $var
     * @param mixed $val
     */
    public function offsetSet($var, $val)
    {
        return $this->__set($var, $val);
    }

    /**
     * @param string $var
     */
    public function offsetGet($var)
    {
        return $this->__get($var);
    }

    /**
     * @param string $var
     */
    public function offsetExists($var)
    {
        return $this->__isset($var);
    }

    /**
     * @param string $var
     */
    public function offsetUnset($var)
    {
        return $this->__unset($var);
    }
}

