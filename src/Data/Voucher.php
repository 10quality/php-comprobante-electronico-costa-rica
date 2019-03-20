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
     * Path to where the encryption key file (p12) is located.
     * @since 1.0.0
     * @var string
     */
    protected $encryptionKeyFilename = null;
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
        'hasEncryption',
    ];
    /**
     * Overrides parent constructor to allow definition of the encryption key.
     * @since 1.0.0
     * 
     * @param string $encryptionKeyPath Path to where the encryption key file (P2) is located.
     * @param array  $attributes        Model attributes.
     */
    public function __construct($encryptionKeyFilename = null, $attributes = [])
    {
        $this->encryptionKeyFilename = $encryptionKeyFilename;
        parent::__construct($attributes);
    }
    /**
     * Returns flag indicating if model has encryption enabled or not.
     * @since 1.0.0
     * 
     * @return bool
     */
    protected function getHasEncryptionAlias()
    {
        return $this->encryptionKeyFilename !== null
            && is_file($this->encryptionKeyFilename);
    }
    /**
     * Returns XML encrypted.
     * @since 1.0.0
     * 
     * @return string
     */
    protected function getEncryptedXmlAlias()
    {
        if ($this->hasEncryption && $this->xml) {

        }
        return null;
    }
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
    /**
     * Returns a valid array for reception.
     * @since 1.0.0
     *
     * @return array
     */
    public function toReceptionArray()
    {
        // Validations
        if ($this->issuer === null)
            throw new Exception('Issuer is missing.');
        if (!is_a(Entity::class, $this->issuer))
            throw new Exception('Issuer must be an instance of class Entity.');
        if ($this->xml === null)
            throw new Exception('XML string is missing.');
        if ($this->key === null)
            throw new Exception('Key is missing.');
        if (strlen($this->key) > 50)
            throw new Exception('Key is greater than 50 characters.');
        // Prepare output
        if ($this->time === null)
            $this->time = time();
        $output = [
            'clave'             => $this->key,
            'fecha'             => __cecrDate($this->time),
            'emisor'            => $this->issuer->toReceptionArray(),
            'comprobanteXml'    => $this->hasEncryption ? $this->encryptedXml : $this->xml,
        ];
        // Add optional properties
        if ($this->receiver !== null && is_a($this->receiver, Entity::class))
            $output['receptor'] = $this->receiver->toReceptionArray();
        if ($this->callback !== null)
            $output['callbackUrl'] = $this->callback;
        if ($this->receiverSerial !== null)
            $output['consecutivoReceptor'] = $this->receiverSerial;
        return $output;
    }
}