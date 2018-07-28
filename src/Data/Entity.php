<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;

/**
 * Holds an entity data.
 * An entity may represent a person or a organization with a valid goverment issued ID.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Entity extends Model
{
    /**
     * Type that identifies an individual person.
     * @since 1.0.0
     *
     * @var string
     */
    const TYPE_INDIVIDUAL = '01';
    /**
     * Type that identifies a foreginer.
     * @since 1.0.0
     *
     * @var string
     */
    const TYPE_FOREIGNER = '02';
    /**
     * Type that identifies a business.
     * @since 1.0.0
     *
     * @var string
     */
    const TYPE_BUSINESS = '03';
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'id',
        'type',
    ];
    /**
     * Returns the ID value based on the rawId property.
     * @since 1.0.0
     *
     * @return int
     */
    protected function getIdAlias()
    {
        return $this->rawId ? intval(preg_replace('/\-|\_|\./', '', $this->rawId)) : null;
    }
    /**
     * Sets the ID alias property.
     * @since 1.0.0
     *
     * @param mixed|int|string $value Value to set to ID property.
     */
    protected function setIdAlias($value)
    {
        $this->rawId = $value;
    }
    /**
     * Returns a valid entity for voucher reception.
     * @since 1.0.0
     *
     * @return array
     */
    public function toReceptionArray()
    {
        if ($this->rawId === null || strlen($this->rawId) === 0)
            throw new Exception('Entity\'s ID is missing.');
        if ($this->type === null || strlen($this->type) === 0)
            throw new Exception('Entity\'s type is missing.');
        if (strlen($this->id) > 12)
            throw new Exception('Entity\'s ID is greater than 12 digits.');
        if (!in_array($this->type, [self::TYPE_INDIVIDUAL, self::TYPE_FOREIGNER, self::TYPE_BUSINESS]))
            throw new Exception(sprintf('Unknown entity type \'%s\'.', $this->type));
        return [
            'tipoIdentificacion'    => $this->type,
            'numeroIdentificacion'  => $this->id,
        ];
    }
}