<?php

namespace ComprobanteElectronico\Data;

use TenQuality\Data\Model;

/**
 * Settings data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Settings extends Model
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'env',
        'username',
        'password',
        'cypherKeyPath',
        'isCypherKeyValid',
    ];
    /**
     * Returns value for isCypherKeyValid property.
     * Returns flag indicating if path is valid.
     * @since 1.0.0
     *
     * @var bool 
     */
    protected function getIsCypherKeyValidAlias()
    {
        return $this->cypherKeyPath && file_exists($this->cypherKeyPath);
    }
}