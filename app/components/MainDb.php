<?php
/**
 * Main database driver component
 *
 * PHP version 5
 *
 * @category Components
 * @author   Denis Porplenko <porplenko@gmail.com>
 */

class MainDb extends MysqliDb
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $db = A::getMainApp()->db;

        $dbhost = $db['dbhost'];
        $dblogin = $db['dblogin'];
        $dbpass = $db['dbpass'];
        $dbname = $db['dbname'];

        parent:: __construct($dbhost, $dblogin, $dbpass, $dbname);
    }

}
