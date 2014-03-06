<?php
/**
 * ResponseTypeFactory component.
 * Using factory method to instance provider object
 *
 * PHP version 5
 *
 * @category Components
 * @author   Denis Porplenko  <porplenko@gmail.com>
 */

class ResponseTypeFactory
{

    const TYPE_JSON    = 'json';
    const TYPE_XML     = 'xml';
    const TYPE_PHP     = 'php';
    const TYPE_DEFAULT = 'json';

    /**
     * Main builder to instance response provider
     * @return MainProvider
     */
    public static function build()
    {
        $provider = ucfirst(A::getMainApp()->request->type) . 'Provider';
        $path     = COMPONENTS . DIRECTORY_SEPARATOR . 'providers';
        A::load($path, 'MainProvider', false);
        return A::load($path, $provider);
    }

    /**
     * Checking type response from query
     * @param  string  $type type from query
     * @return boolean       result
     */
    public static function isValidType($type)
    {
        $allowTypes = array(
        ResponseTypeFactory::TYPE_JSON,
        ResponseTypeFactory::TYPE_XML,
        ResponseTypeFactory::TYPE_PHP,
        );

        return in_array($type, $allowTypes);
    }
}

