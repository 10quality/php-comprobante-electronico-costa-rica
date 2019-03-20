<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Data\Address;
use ComprobanteElectronico\Data\Phone;
use ComprobanteElectronico\Enums\EntityType;
use ComprobanteElectronico\Interfaces\XmlAppendable;
/**
 * Holds an entity data.
 * An entity may represent a person or a organization with a valid goverment issued ID.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Entity extends Model implements XmlAppendable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'id',
        'type',
        'name',
        'foreignerId',
        'businessName',
        'email',
        'address',
        'phone',
        'fax',
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
            throw new Exception(__i18n('ID is missing.'));
        if ($this->type === null || strlen($this->type) === 0)
            throw new Exception(__i18n('Type is missing.'));
        if (strlen($this->id) > 12)
            throw new Exception(__i18n('ID is greater than 12 digits.'));
        if (!EntityType::exists($this->type))
            throw new Exception(sprintf(__i18n('Unknown entity type \'%s\'.'), $this->type));
        return [
            'tipoIdentificacion'    => $this->type,
            'numeroIdentificacion'  => $this->id,
        ];
    }
    /**
     * Validates model for xml.
     * @since 1.0.0
     */
    public function isValid()
    {
        if ($this->name === null || strlen($this->name) === 0)
            throw new Exception(__i18n('Name is missing.'));
        if ($this->rawId === null || strlen($this->rawId) === 0)
            throw new Exception(__i18n('ID is missing.'));
        if ($this->type === null || strlen($this->type) === 0)
            throw new Exception(__i18n('Type is missing.'));
        if (strlen($this->id) > 12)
            throw new Exception(__i18n('ID is greater than 12 digits.'));
        if (!EntityType::exists($this->type))
            throw new Exception(sprintf(__i18n('Unknown entity type \'%s\'.'), $this->type));
        if ($this->address !== null && !is_a($this->address, Address::class))
            throw new Exception(__i18n('Address must be an instance of class \'Address\'.'));
        if ($this->phone !== null && !is_a($this->phone, Phone::class))
            throw new Exception(__i18n('Phone must be an instance of class \'Phone\'.'));
        if ($this->fax !== null && !is_a($this->fax, Phone::class))
            throw new Exception(__i18n('Fax must be an instance of class \'Phone\'.'));
        return true;
    }
    /**
     * Appends their data to an xml structure.
     * @since 1.0.0
     * 
     * @param string            $element Element to append as.
     * @param \SimpleXMLElement &$xml    XML structure to append to.
     */
    public function appendXml($element, &$xml)
    {
        $this->isValid();
        $xmlEntity = $xml->addChild($element);
        // Name
        $xmlEntity->addChild('Nombre', strlen($this->name) > 80 ? substr($this->name, 0, 80) : $this->name);
        // Id
        $xmlId = $xmlEntity->addChild('Identificacion');
        $xmlId->addChild('Tipo', $this->type);
        $xmlId->addChild('Numero', $this->id);
        // Foreigner
        if ($this->foreignerId)
            $xmlEntity->addChild(
                'IdentificacionExtranjero',
                strlen($this->foreignerId) > 20 ? substr($this->foreignerId, 0, 20) : $this->foreignerId
            );
        // Business name
        if ($this->businessName)
            $xmlEntity->addChild(
                'NombreComercial',
                strlen($this->businessName) > 80 ? substr($this->businessName, 0, 80) : $this->businessName
            );
        // Email
        if ($this->email)
            $xmlEntity->addChild('CorreoElectronico', $this->email);
        // Address
        if ($this->address)
            $this->address->appendXml('Ubicacion', $xmlEntity);
        // Phone
        if ($this->phone)
            $this->phone->appendXml('Telefono', $xmlEntity);
        // Fax
        if ($this->fax)
            $this->fax->appendXml('Fax', $xmlEntity);
    }
}