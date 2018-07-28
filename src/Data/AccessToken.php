<?php

namespace ComprobanteElectronico\Data;

use TenQuality\Data\Model;

/**
 * AccessToken data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class AccessToken extends Model
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'token',
        'type',
        'createdAt',
        'expiresIn',
        'sessionState',
        'hasExpired',
    ];
    /**
     * Returns value for token property.
     * @since 1.0.0
     *
     * @var string 
     */
    protected function getTokenAlias()
    {
        return $this->access_token ? $this->access_token : null;
    }
    /**
     * Returns value for type property.
     * @since 1.0.0
     *
     * @var string 
     */
    protected function getTypeAlias()
    {
        return $this->token_type ? $this->token_type : null;
    }
    /**
     * Returns value for expiresIn property.
     * @since 1.0.0
     *
     * @var string 
     */
    protected function getExpiresInAlias()
    {
        return $this->expires_in ? $this->expires_in : null;
    }
    /**
     * Returns value for sessionState property.
     * @since 1.0.0
     *
     * @var string 
     */
    protected function getSessionStateAlias()
    {
        return $this->session_state ? $this->session_state : null;
    }
    /**
     * Returns value for hasExpired property.
     * @since 1.0.0
     *
     * @var bool 
     */
    protected function getHasExpiredAlias()
    {
        return $this->expiresIn ? $this->createdAt + $this->expiresIn > time() : true;
    }
}