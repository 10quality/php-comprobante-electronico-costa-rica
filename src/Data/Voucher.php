<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;

/**
 * AccessToken data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Voucher extends Model
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'time',
        'issuer',
        'receiver',
    ];
    /**
     * Adds a new entity.
     * @since 1.0.0
     *
     * @param string $entity      Entity property name.
     * @param string $typeOrModel Entity type or entity model.
     * @param string $id          Entity id.
     */
    public function addEntity($entity, $typeOrModel, $id = null)
    {
        // Spanish translation allowed
        if ($entity === 'emisor')
            $entity = 'issuer';
        if ($entity === 'receptor')
            $entity = 'receiver';
        // Add entity
        if (is_object($typeOrModel)) {
            if (!is_a($typeOrModel, Entity::class))
                throw new Exception(sprintf('Expecting object parameter to be an instance of \'%s\'.', Entity::class));
            $this->$entity = $typeOrModel;
        } else {
            if ($typeOrModel === null || strlen($typeOrModel) === 0)
                throw new Exception('Entity\'s type is missing.');
            if ($id === null || strlen($id) === 0)
                throw new Exception('Entity\'s ID is missing.');
            $this->$entity = new Entity;
            $this->$entity->type = $typeOrModel;
            $this->$entity->id = $id;
        }
    }
}