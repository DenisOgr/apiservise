<?php

/**
 * Main module component. Userfull RESTFull API
 *
 * GET  users/{id} - get one user
 * GET  users      - get list of users
 * POST users      - create new user
 * PUT users/{id}  - update user
 * DELET users/{id}- delete user
 *
 * PHP version 5
 *
 * @category   Components
 * @author   Denis Porplenko  <porplenko@gmail.com>
 */

abstract class MainModule
{
    const RESTFULL_ACTION_VIEW   = 'view';
    const RESTFULL_ACTION_ITEMS  = 'items';
    const RESTFULL_ACTION_ADD    = 'add';
    const RESTFULL_ACTION_EDIT   = 'edit';
    const RESTFULL_ACTION_DELETE = 'del';

    /**
     * Dummy info about processing restfull actions
     * @var [type]
     */
    protected $dummyInfo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dummyInfo = array(
            'code' => AppException::HTTP500,
            'data'   => 'This action during development.'
        );
    }

    /**
     * Return allow restfull actions
     * @return array Result array
     */
    static public function getRestFullActions()
    {
        return array(
            MainModule::RESTFULL_ACTION_VIEW,
            MainModule::RESTFULL_ACTION_ITEMS,
            MainModule::RESTFULL_ACTION_ADD,
            MainModule::RESTFULL_ACTION_EDIT,
            MainModule::RESTFULL_ACTION_DELETE,
            );
    }

    /**
     * Get database table in concrete module
     * @return sting table name
     */
    abstract protected function getTable();

    /**
     * Get item
     * @param  integer $id id view item
     */
    public function view($id)
    {
        ResponseManager::render($this->dummyInfo);
    }

    /**
     * Get items
     */
    public function items()
    {
        ResponseManager::render($this->dummyInfo);
    }

    /**
     * Insert  item
     */
    public function add()
    {
        ResponseManager::render($this->dummyInfo);
    }

    /**
     * Edit item
     * @param  integer $id id edit item
     */
    public function edit($id)
    {
        ResponseManager::render($this->dummyInfo);
    }

    /**
     * Delete item
     * @param  integer $id id delete item
     */
    public function del($id)
    {
        ResponseManager::render($this->dummyInfo);
    }

}
