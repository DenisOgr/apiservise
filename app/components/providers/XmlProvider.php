<?php
/**
 * Xml Provider component
 *
 * PHP version 5
 *
 * @category Components.providers
 * @author   Denis Porplenko <porplenko@gmail.com>
 */
class XmlProvider extends MainProvider
{
    /**
     * Formatting results to xml
     * @param  array $data output data
     * @return string xml
     */
    public function handler($data)
    {
        A::load(VENDORS, 'Array2XML', false);

        $data = CommonHelpers::normalize($data);
        $xml  = Array2XML::createXML('response', $data);

        header('Content-Type: text/xml');
        echo $xml->saveXML();
    }
}

