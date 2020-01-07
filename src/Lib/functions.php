<?php
/**
 * Global functions.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */

if (!function_exists('__i18nInit')) {
    /**
     * Inits i18n multilanguage support.
     * cecr = Comprobante Electronico Costa Rica
     * @since 1.0.0
     * 
     * @param string $locale Language locale to use.
     * @param string $cache  Cache file path.
     */
    function __i18nInit($locale = 'es', $cache = null)
    {
        $load = defined('CECR_I18N') ? CECR_I18N : true;
        if ($load) {
            $i18n = new i18n(
                __DIR__.'/../../i18n/'.$locale.'.ini',
                $cache === null ? __DIR__.'/../../tests/cache/' : $cache,
                'en'
            );
            $i18n->setForcedLang($locale);
            $i18n->init();
        }
    }
}

if (! function_exists('__i18n')) {
    /**
     * Returns a translation found in language files.
     * cecr = Comprobante Electronico Costa Rica
     * @since 1.0.0
     * 
     * @param string $string String or key to use to find translation.
     * @param array  $args   Translation args.
     * 
     * @return string
     */
    function __i18n($string, $args = [])
    {
        return function_exists('L')
            ? L(mb_strtolower(trim(preg_replace(['/\s/', '/[\.\,\'\"\?\!\:\%\(\)\\\/]/'], ['_',''], $string))), $args)
            : $string;
    }
}

if (! function_exists('__cecrDate')) {
    /**
     * Returns date with valid format.
     * @since 1.0.0
     * 
     * @param {mixed} $time Time or date value value to format to date.
     * 
     * @return string
     */
    function __cecrDate($time = null)
    {
        if ($time === null)
            $time = time();
        $time = is_string($time) ? strtotime($time) : $time;
        return date('Y-m-d', $time).'T'.date('H:i:s', $time).'Z';
    }
}