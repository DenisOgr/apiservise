<?php
/**
 * Json Provider component
 *
 * PHP version 5
 *
 * @category Components.providers
 * @author   Denis Porplenko <porplenko@gmail.com>
 */

class JsonProvider extends MainProvider
{
    /**
     * Formatting results to json
     * @param  array $data output data
     * @return string json string
     */
    public function handler($data)
    {
        header('Content-type: application/json');
        echo json_encode($data);
    }
}

