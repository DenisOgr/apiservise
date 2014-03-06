<?php

/**
 * RequestManager component
 *
 * PHP version 5
 *
 * @category Components
 * @author   Denis Porplenko <porplenko@gmail.com>
 */

class RequestManager
{
    /**
     * Config by request module
     * @var array
     */
    private $_moduleConfig;

    /**
     * Raw/Temp title action from query(need validate)
     * @var string
     */
    private $_rawAction;

    /**
     * Module title
     * @var string
     */
    public $module;

    /**
     * Action title
     * @var string
     */
    public $action;

    /**
     * Method title
     * @var string
     */
    public $method;

    /**
     * Response type title
     * @var string
     */
    public $type;

    /**
     * Params from query. All params(with sign)
     * @var array
     */
    public $params;

    /**
     * Param  restfull action
     * @var array
     */
    public $paramToAction = array();

    /**
     * Uri without params
     * @var string
     */
    public $uri;

    /**
     * Full uri from query
     * @var string
     */
    public $fullUri;

    /**
     * Public key
     * @var string
     */
    public $puk;

    /**
     * Private key
     * @var string
     */
    public $prk;

    const METHOD_POST    = 'post';
    const METHOD_GET     = 'get';
    const METHOD_PUT     = 'put';
    const METHOD_DELETE  = 'delete';
    const METHOD_HEAD    = 'head';
    const METHOD_DEFAULT = 'get';

    public function __construct()
    {
    }

    /**
     * Initialization request manager
     */
    public function init()
    {
        $this->fullUri    = $_SERVER['REQUEST_URI'];

        if (strpos($this->fullUri, '?') !== false) {
            list($uri, $params)  = explode('?', $this->fullUri);
        }
        $this->uri = $uri;

        if (!empty($params)) {
            $this->params = $this->strToArrayParams($params);
        }

        $this->initType();
        $this->initKeys();
        $this->initSign();
        $this->initMethod();
        $this->initModuleAction();

    }

    /**
     * Convert string with params to array
     * @param  string $str input string
     * @return array      output array
     */
    public function strToArrayParams($str)
    {
        $arrayRawParams = explode('&', $str);
        foreach ($arrayRawParams as $param) {
            $curParam = explode('=', $param);
            if (count($curParam) == 2) {
                $arrayParams[$curParam[0]] = $curParam[1];
            }
        }
        return $arrayParams;
    }

    /**
     * Convert array with params to url string
     * @param  array $array input array
     * @return string        output string
     */
    public function arrayToStringParams($array)
    {
        $stringParams = '';
        foreach ($array as $key => $param) {
            $stringParams .= $key . '=' .$param . '&';
        }
        return substr($stringParams, 0, strlen($stringParams) - 1);
    }

    /**
     * Initialization public and private key from query.
     * Validate client by keys
     */
    public function initKeys()
    {
        if (!isset($this->params['puk'])) {
            throw new AppException(AppException::HTTP400, "Public key does not exist!");
        }
        $this->puk = filter_var($this->params['puk'],
                                    FILTER_SANITIZE_SPECIAL_CHARS,
                                    FILTER_FLAG_STRIP_HIGH |
                                    FILTER_FLAG_ENCODE_HIGH);

        $db = new MainDb();
        $clients = $db->where ("puk", $this->puk)->getOne ("clients");

        if (isset($clients['prk'])) {
            $this->prk = $clients['prk'];
        } else {
            throw new AppException(AppException::HTTP400, "Client does not exist!");
        }
    }

    /**
     * Check signature from query.
     * Validate signature
     */
    public function initSign()
    {
        if (!isset($this->params['sign'])) {
            throw new AppException(AppException::HTTP400, "Signature does not exist!");
        }
        $params = $this->params;
        unset($params['sign']);

        $uriParams  = $this->arrayToStringParams($params);
        $signFromUs = md5($this->uri . '?' . $uriParams . $this->prk);

        if ($this->params['sign'] != $signFromUs) {
            throw new AppException(AppException::HTTP400, "Wrong signature!");
        }
    }

    /**
     * Initialization module and action from query.
     */
    public function initModuleAction()
    {
        //check module
        $params = explode('/', trim($this->uri, '/'));
        if (isset($params['0'])) {
            $module      = strtolower($params['0']);
            $allowModules = A::getMainApp()->getConfig('modules');
            if (isset($allowModules[$module])) {
                $this->module        = $module;
                $this->_moduleConfig = $allowModules[$module];
            }
        }
        if (is_null($this->module)) {
            throw new AppException(AppException::HTTP400, "Request module does not exist!");
        }

        //check action
        $this->_rawAction = isset($params['1']) ? $params['1'] : NULL;

        //check user actions in config
        if (!is_null($this->_rawAction) && isset($this->_moduleConfig['actions'])) {
            $userActions = $this->_moduleConfig['actions'];
            if (in_array($this->_rawAction, $userActions)) {
                return $this->action  = $this->_rawAction;
            }
        }

        //check restfull action
        if (ctype_digit($this->_rawAction)) {
            $this->paramToAction['id'] = $this->_rawAction;
        }

        if ($this->method == RequestManager::METHOD_GET
            && is_null($this->_rawAction)) {
            return $this->action = MainModule::RESTFULL_ACTION_ITEMS;
        }

        if ($this->method == RequestManager::METHOD_GET
            && ctype_digit($this->_rawAction)) {
            return $this->action = MainModule::RESTFULL_ACTION_VIEW;
        }

        if ($this->method == RequestManager::METHOD_POST
            && is_null($this->_rawAction)) {
            return $this->action = MainModule::RESTFULL_ACTION_ADD;
        }

        if ($this->method == RequestManager::METHOD_PUT
            && ctype_digit($this->_rawAction)) {
            return $this->action = MainModule::RESTFULL_ACTION_EDIT;
        }

        if ($this->method == RequestManager::METHOD_DELETE
            && ctype_digit($this->_rawAction)) {
            return $this->action = MainModule::RESTFULL_ACTION_DELETE;
        }
        if (is_null($this->action)) {
            throw new AppException(AppException::HTTP400, " Request action does not exist!");
        }

    }

    /**
     * Initialization type response from query
     */
    public function initType()
    {
        if (isset($this->params['type'])) {
            $type = strtolower($this->params['type']);

            $this->type = ResponseTypeFactory::isValidType($type) ?
                $type :
                ResponseTypeFactory::TYPE_DEFAULT;

        } else {
            $this->type = ResponseTypeFactory::TYPE_DEFAULT;
        }
    }

    /**
     * Initialization type query
     */
    public function initMethod()
    {
        if (isset($this->params['method'])) {
            $method = strtolower($this->params['method']);
            $allowMethods = array(
                RequestManager::METHOD_POST,
                RequestManager::METHOD_GET,
                RequestManager::METHOD_PUT,
                RequestManager::METHOD_HEAD,
                RequestManager::METHOD_DELETE,
                );
            if (in_array($method, $allowMethods)) {
                $resultMethod = $method;
            }
        }

        if (empty($resultMethod)) {
            $resultMethod = isset($_SERVER['REQUEST_METHOD']) ?
            strtolower($_SERVER['REQUEST_METHOD']) :
            RequestManager::METHOD_DEFAULT;
        }

        $this->method = $resultMethod;
    }
}
