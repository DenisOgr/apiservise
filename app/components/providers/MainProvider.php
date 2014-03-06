<?php
/**
 * Main Provider component class
 *
 * PHP version 5
 * @category Components.providers
 * @author   Denis Porplenko  <porplenko@gmail.com>
 */

abstract class MainProvider
{
    /**
     * Abstract handler to convert data
     * @param  array $data output data
     * @return mixes       convert output data
     */
    abstract public function handler($data);
}
