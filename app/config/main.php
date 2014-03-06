<?php
/**
 * Main application config
 *
 * PHP version 5
 *
 * @category Config
 * @author   Denis Porplenko <porplenko@gmail.com
 */

return array(
    'modules' =>
        array(
            'users' => array(
                //
                'actions' => array(
                    'firstUser'
                    ),
                ),
            ),
        'db' => array(
                'type' => 'mysql',
                'dbhost' => 'localhost',
                'dbname' => 'a',
                'dblogin' => 'root',
                'dbpass' => '1111111',
            ),
    );
