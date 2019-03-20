<?php

namespace ComprobanteElectronico\Interfaces;

/**
 * Interface for models that append their data to XML strings/objects.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
interface XmlAppendable
{
    /**
     * Validates model for xml.
     * @since 1.0.0
     */
    public function isValid();
    /**
     * Appends their data to an xml structure.
     * @since 1.0.0
     * 
     * @param string            $element Element to append as.
     * @param \SimpleXMLElement &$xml    XML structure to append to.
     */
    public function appendXml($element, &$xml);
}