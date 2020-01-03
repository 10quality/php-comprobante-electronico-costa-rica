<?php

namespace ComprobanteElectronico\Traits;

use Exception;

/**
 * Trait used for XML models with items.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
trait DocTrait
{
    /**
     * Returns the document type or code used to generate the sequential number.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $doctype;
    /**
     * Sets document type.
     * @since 1.0.0
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->doctype = $type;
    }
    /**
     * Returns document type.
     * @since 1.0.0
     *
     * @return string
     */
    public function getType()
    {
        if (!isset($this->doctype) || !empty($this->doctype))
            throw new Exception('No doc type set.');
        return $this->doctype;
    }
}