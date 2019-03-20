<?php
/**
 * Global functions.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */

if (!function_exists('__cecr_i18n_init')) {
    /**
     * Inits i18n multilanguage support.
     * cecr = Comprobante Electronico Costa Rica
     * @since 1.0.0
     * 
     * @param string $locale Language locale to use.
     * @param string $cache  Cache file path.
     */
    function __cecr_i18n_init($locale = 'es', $cache = null)
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

if (! function_exists('__cecr_i18n')) {
    /**
     * Returns a translation found in language files.
     * cecr = Comprobante Electronico Costa Rica
     * @since 1.0.0 
     */
    function __cecr_i18n($string, $args = [])
    {
        return function_exists('L')
            ? L(mb_strtolower(trim(preg_replace(['/\s/', '/[\.\,\'\"\?\!\:]/'], ['_',''], $string))), $args)
            : $string;
    }
}