<?php
/**
 * PHP Provider component class file
 *
 * PHP version 5
 *
 * @category Components.providers
 * @author   Denis Porplenko <porplenko@gmail.com>
 */

class PhpProvider extends MainProvider
{
    /**
     * Formatting results to serialize
     * @param  array $data output data
     * @return string serialize string
     */
    public function handler($data)
    {
        header('Content-type: application/vnd.php.serialized');
        echo serialize($data);
    }
}

