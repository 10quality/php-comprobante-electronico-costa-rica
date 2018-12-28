<?php

namespace ComprobanteElectronico\Interfaces;

/**
 * Interface for models casting to XML string.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
interface XmlCastable
{
    /**
     * Returns flag indicating if model is valid for casting.
     * @since 1.0.0
     *
     * @return bool
     */
    public function isValid();
    /**
     * Returns model as its expected XML string.
     * @since 1.0.0
     *
     * @return string
     */
    public function toXml();
}