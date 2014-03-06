<?php

/**
 * MainLogger component
 *
 * PHP version 5
 *
 * @category Components
 * @author   Denis Porplenko <porplenko@gmail.com>
 */

class MainLogger
{
    /**
     * Insert information by query to storage
     * @return integer id new record
     */
    public function log()
    {
        $request  = A::getMainApp()->request;
        $response = A::getMainApp()->response;

        $log = array(
                'ip'               => CommonHelpers::getIp(),
                'client_puk'       => $request->puk,
                'query'            => $request->fullUri,
                'module'           => $request->module,
                'action'           => $request->action,
                'params'           => serialize($request->params),
                'response_code'    => $response->code,
                'response_message' => $response->message,
                );

        $db = new MainDb();
        return $db->insert('logs', $log);
    }
}
