<?php

namespace ComprobanteElectronico\Core;

use Exception;
use ReflectionClass;
use TenQuality\Data\Contracts\Arrayable;
use TenQuality\Data\Contracts\Stringable;

/**
 * AccessToken data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
abstract class Enum implements Arrayable, Stringable
{
    /**
     * List of constant code and is description.
     * @since 1.0.0
     *
     * @var array 
     */
    protected $constants = [];
    /**
     * Returns all constants available in class.
     * @since 1.0.0
     * 
     * @link http://php.net/manual/en/reflectionclass.getconstants.php
     * 
     * @param string $class Name of the class from which to get the constants.
     * 
     * @return array
     */
    protected static function __getConstants($class = null)
    {
        $class = new ReflectionClass($class === null ? __CLASS__ : $class);
        return $class->getConstants();
    }
    /**
     * Indicates if a given value exists as a constant in the enum list.
     * @since 1.0.0
     * 
     * @param mixed $value Enum value to check.
     * 
     * @return bool
     */
    public static function exists($value)
    {
        $constants = static::__getConstants();
        return in_array($value, $constants);
    }
    /**
     * Returns constants array.
     * @since 1.0.0
     * 
     * @return array
     */
    public function getConstants()
    {
        return $this->constants;
    }
    /**
     * Returns object as string.
     * @since 1.0.0
     * 
     * @return array
     */
    public function __toArray()
    {
        $output = [];
        foreach (static::__getConstants() as $key => $value) {
            $output[$value] = isset($this->constants[$value]) ? $this->constants[$value] : $key;
        }
        return $output;
    }
    /**
     * Returns object as string.
     * @since 1.0.0
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->__toArray();
    }
    /**
     * Returns object as string.
     * @since 1.0.0
     * 
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->__toArray());
    }
}