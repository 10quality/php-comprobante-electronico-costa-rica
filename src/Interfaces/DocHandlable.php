<?php

namespace ComprobanteElectronico\Interfaces;

/**
 * Interface for models that are considered documents, which can be used to generate
 * document numbers.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
interface DocHandlable
{
    /**
     * Sets document type.
     * @since 1.0.0
     *
     * @param string $type
     */
    public function setType($type);
    /**
     * Returns document type.
     * @since 1.0.0
     *
     * @return string
     */
    public function getType();
}