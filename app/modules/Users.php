<?php
/**
 * Users modules
 *
 * PHP version 5
 *
 * @category Modules
 * @author   Denis Porplenko <porplenko@gmail.com>
 */

class Users extends MainModule
{

    /**
     * Get database table in  module
     * @return sting table name
     */
    protected function getTable()
    {
        return 'users';
    }

    /**
     * Get users
     * @param  integer $id id view item
     */
    public function view($id)
    {
        $db = new MainDb();
        $request = A::getMainApp()->request;
        $select = null;

        if (isset($request->params['select'])) {
            $select = htmlspecialchars($request->params['select']);
        }

        $user = $db->where('id', $id)->getOne($this->getTable(), $select);

        if ($user === null) {
            throw new AppException(AppException::HTTP400, "There is no record of a user");

        }
        ResponseManager::render(array('data' => $user));
    }

     /**
     * Get users
     */
    public function items()
    {
         $db = new MainDb();

         $users = $db->get($this->getTable());

        if ($users === null) {
            throw new AppException(AppException::HTTP400, "There are no records of a users");
        }
        ResponseManager::render(array('data' => $users));
    }

    /**
     * Get first user
     */
    public function firstUser()
    {
        $db   = new MainDb();
        $user = $db->where('id', 1)->getOne($this->getTable());

        ResponseManager::render(array('data' => $user));
    }

}
