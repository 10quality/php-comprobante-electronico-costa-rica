<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Interfaces\XmlCastable;

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
     * Pin or password to use encryption key.
     * @since 1.0.0
     * @var string
     */
    protected $encryptionPin = null;
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'key',
        'time',
        'issuer',
        'receiver',
        'document',
        'situation',
        'securityCode',
        'hasEncryption',
    ];
    /**
     * Overrides parent constructor to allow definition of the encryption key.
     * @since 1.0.0
     * 
     * @param string $encryptionKeyPath Path to where the encryption key file (P2) is located.
     * @param string $encryptionPin     Pin or password to use encryption key.
     * @param array  $attributes        Model attributes.
     */
    public function __construct($encryptionKeyFilename = null, $encryptionPin = null, $attributes = [])
    {
        $this->encryptionKeyFilename = $encryptionKeyFilename;
        $this->encryptionPin = $encryptionPin;
        parent::__construct($attributes);
    }
    /**
     * Returns generated key.
     * @since 1.0.0
     * 
     * @return string
     */
    protected function getKeyAlias()
    {
        if (!$this->isValid())
            return null;
        return sprintf(
            '%s%s%s%s%s%s%d%s',
            str_pad($this->countryCode ? $this->countryCode : 506, 3, '0', STR_PAD_LEFT),
            str_pad(date('d'), 2, '0', STR_PAD_LEFT),
            str_pad(date('m'), 2, '0', STR_PAD_LEFT),
            str_pad(date('y'), 2, '0', STR_PAD_LEFT),
            str_pad($this->issuer->id, 12, '0', STR_PAD_LEFT),
            str_pad($this->document->number, 20, '0', STR_PAD_LEFT),
            isset($this->situation) ? $this->situation : 1,
            str_pad(substr($this->securityCode, 0, 8), 8, '0', STR_PAD_LEFT)
        );
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
            && $this->encryptionPin !== null
            && is_file($this->encryptionKeyFilename);
    }
    /**
     * Returns encrypted XML.
     * @since 1.0.0
     * 
     * @link https://gist.github.com/millsy/2237249
     * 
     * @return string
     */
    protected function getEncryptedXmlAlias()
    {
        if ($this->hasEncryption && $this->document) {
            if (!$this->document instanceof XmlCastable)
                throw new Exception(__i18n('Document must implement \'XmlCastable\'.'));
            $p12cert = [];
            $file = file_get_contents($this->encryptionKeyFilename);
            $crypted = null;
            if (openssl_pkcs12_read($file, $p12cert, $this->encryptionPin)
                && openssl_public_encrypt($this->document->toXml()->asXML(), $crypted, $p12cert['cert'])
            ) {
                return $crypted;
            } else {
                throw new Exception(__i18n('Failed to encrypt XML.'));
            }
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
                throw new Exception(sprintf(__i18n('Expecting object parameter to be an instance of \'%s\'.'), Entity::class));
            $this->$entity = $typeOrModel;
        } else {
            if ($typeOrModel === null || strlen($typeOrModel) === 0)
                throw new Exception(__i18n('Entity\'s type is missing.'));
            if ($id === null || strlen($id) === 0)
                throw new Exception(__i18n('Entity\'s ID is missing.'));
            $this->$entity = new Entity;
            $this->$entity->type = $typeOrModel;
            $this->$entity->id = $id;
        }
    }
    /**
     * Checks if model is valid or not.
     * @since 1.0.0
     * 
     * @return bool
     */
    public function isValid()
    {
        if ($this->issuer === null)
            throw new Exception(__i18n('Issuer is missing.'));
        if (!is_a($this->issuer, Entity::class))
            throw new Exception(__i18n('Issuer must be an instance of class Entity.'));
        if ($this->document === null)
            throw new Exception(__i18n('Document is missing.'));
        if (!$this->document instanceof XmlCastable)
            throw new Exception(__i18n('Document must implement \'XmlCastable\'.'));
        return true;
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
        $this->isValid();
        // Prepare output
        if ($this->time === null)
            $this->time = time();
        $this->document->key = $this->key;
        $output = [
            'clave'             => $this->key,
            'fecha'             => __cecrDate($this->time),
            'emisor'            => $this->issuer->toReceptionArray(),
            'comprobanteXml'    => $this->hasEncryption
                                    ? $this->encryptedXml
                                    : $this->document->toXml()->asXML(),
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