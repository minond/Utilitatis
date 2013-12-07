<?php

namespace Efficio\Utilitatis;

/**
 * easy to work with objects
 */
class PublicObject
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
}

