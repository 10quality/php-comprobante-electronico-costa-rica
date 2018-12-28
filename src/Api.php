<?php

namespace ComprobanteElectronico;

use Curl;
use ComprobanteElectronico\Data\AccessToken;
use ComprobanteElectronico\Data\Settings;
use ComprobanteElectronico\Data\Voucher;

/**
 * Api hacienda.
 *
 * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.1/comprobantes-electronicos-api.html
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Api
{
    /**
     * Constant that indicates when the API is running on sandbox/staging.
     * @since 1.0.0
     *
     * @var string
     */
    const ENV_SANDBOX = 'SANDBOX';
    /**
     * Constant that indicates when the API is running on live/production.
     * @since 1.0.0
     *
     * @var string
     */
    const ENV_LIVE = 'LIVE';
    /**
     * Base uri for sandbox calls.
     * @since 1.0.0
     *
     * @var string
     */
    const URI_SANDBOX = 'https://api.comprobanteselectronicos.go.cr/recepcion-sandbox/v1/';
    /**
     * Base uri for live calls.
     * @since 1.0.0
     *
     * @var string
     */
    const URI_LIVE = 'https://api.comprobanteselectronicos.go.cr/recepcion/v1/';
    /**
     * Api instance.
     * @since 1.0.0
     *
     * @var object|ComprobanteElectronico\Api
     */
    protected static $instance;
    /**
     * Access token.
     * @since 1.0.0
     *
     * @var object|ComprobanteElectronico\Data\AccessToken
     */
    protected $accessToken;
    /**
     * Default constructo.
     * @since 1.0.0
     *
     * @param Settings $settings Api settings (base url, oauth settings and other).
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
        if ($this->settings->env === null)
            $this->settings->env = self::ENV_SANDBOX;
        // Get access token
        $this->requestAccessToken();
    }
    /**
     * Inits api.
     * @since 1.0.0
     *
     * @param Settings $settings Api settings (base url, oauth settings and other).
     *
     * @return object|Api
     */
    public static function init(Settings $settings)
    {
        if (!isset(static::$instance))
            static::$instance = new self($settings);
        return static::$instance;
    }
    /**
     * Returns instance.
     * @since 1.0.0
     *
     * @return object|Api
     */
    public static function instance()
    {
        return isset(static::$instance) ? static::$instance : null;
    }
    /**
     * Validates API.
     * @since 1.0.0
     *
     * @throws Exception
     */
    private function validateSettings()
    {
        if ($this->settings->env !== self::ENV_SANDBOX || $this->settings->env !== self::ENV_LIVE)
            throw new Exception('Invalid environment.');
        if ($this->settings->username === null)
            throw new Exception('Username not found in settings.');
        if ($this->settings->password === null)
            throw new Exception('Password not found in settings.');
        if ($this->settings->cypherKeyPath === null)
            throw new Exception('Cypher key path not found in settings.');
    }
    /**
     * Requests access token to api.
     * @since 1.0.0
     */
    private function requestAccessToken()
    {
        if (isset($this->accessToken) && !$this->accessToken->hasExpired)
            return;
        $this->validateSettings();
        $response = Curl::request(
            // url
            $this->settings->env === self::ENV_LIVE
                ? 'https://idp.comprobanteselectronicos.go.cr/auth/realms/rut/protocol/openid-connect/token'
                : 'https://idp.comprobanteselectronicos.go.cr/auth/realms/rut-stag/protocol/openid-connect/token',
            // method
            'POST',
            // body
            [
                'client_id'     => $this->settings->env === self::ENV_LIVE ? 'api-prod' : 'api-stag',
                'grant_type'    => 'password',
                'username'      => trim($this->settings->username),
                'password'      => trim($this->settings->password),
            ],
            // headers
            [],
            // curl options
            $this->settings->env === self::ENV_LIVE
                ? [
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_SSL_VERIFYPEER => 2,
                ]
                : []
        );
        if ($response) {
            $response = json_decode($response);
            $this->accessToken = new AccessToken;
            $this->accessToken->attributes = (array)$response;
            $this->accessToken->createdAt = time();
        }
        unset($response);
    }
    /**
     * Returns base URI depending on the environment selected.
     * @since 1.0.0
     *
     * @return string
     */
    private function getUri()
    {
        return $this->settings->env === self::ENV_LIVE ? self::URI_LIVE : self::URI_SANDBOX;
    }
    /**
     * Reception POST endpoint.
     * @since 1.0.0
     *
     * @param Voucher $voucher  Voucher data.
     * @param string  $callback Callback URI used by Hacienda to send the response.
     */
    public function send(Voucher $voucher, $callback)
    {
        $this->requestAccessToken();
        $voucher->callback = $callback;
        $response = Curl::request(
            // url
            $this->getUri().'/recepcion',
            // method
            'POST',
            // body
            $voucher->toReceptionArray(),
            // headers
            [sprintf('Authorization: %s %s', $this->accessToken->type, $this->accessToken->token)],
            // curl options
            $this->settings->env === self::ENV_LIVE
                ? [
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_SSL_VERIFYPEER => 2,
                ]
                : []
        );
    }
}