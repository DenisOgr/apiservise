<?php
/**
 * Main Application component
 *
 * PHP version 5
 *
 * @category Components
 * @author   Denis Porplenko  <porplenko@gmail.com>
 */

class MainApp
{
    /**
     * Main application config
     * @var array
     */
    private $_config;

    /**
     * Handler module in query
     * @var MainModule
     */
    private $_m;

    /**
     * Modules array
     * @var array
     */
    public $modules;
    /**
     * Request object
     * @var RequestManager
     */
    public $request;

    /**
     * Response object
     * @var ResponseManager
     */
    public $response;
    /**
     * Database settings
     * @var array
     */
    public $db;

    /**
     * Constructor
     * @param array $config main config
     */
    public function __construct($config)
    {
        A::setApp($this);

        //init handler
        set_exception_handler(array($this, 'handleException'));

        $this->_config = $config;

        foreach ($this->_config as $key => $value) {
            $this->$key = $value;
        }
        //load Response Manager
        $this->response = new ResponseManager();

        //load Request Manager
        $this->request  = new RequestManager();

    }

    /**
     * Get items by config settings
     * @param  string $item title config item
     * @return array config item
     */
    public function getConfig($item)
    {
        if (!isset($this->_config[$item])) {
            throw new AppException(AppException::HTTP500, "Error config item: ". $item);
        } else {
            return $this->_config[$item];
        }
    }
    /**
     * Main action to handler query
     */
    public function go()
    {
        $this->request->init();
        $this->onBeginProcess();
        $this->loadModule();
        call_user_func_array(array($this->_m, $this->request->action),
                            $this->request->paramToAction);
        $this->onEndProcess();
    }

    /**
     * Handler application exceptions
     * @param  Exception $e exception
     */
    public function handleException($e)
    {
        restore_error_handler();
        restore_exception_handler();

        if ($e instanceof AppException) {
            $this->response->code    = $e->getStatusCode();
            $this->response->message = $e->getMessage();
        }
        $this->endApp();
    }

    /**
     * Event to begin process
     */
    protected function onBeginProcess()
    {
    }

    /**
     * Event to end process
     */
    protected function onEndProcess()
    {
        $this->endApp();
    }

    /**
     * Ending main app. Logged query
     */
    protected function endApp()
    {
        $logger = new MainLogger();
        $logger->log();

        $this->response->send();
        exit(0);
    }

    /**
     * Load modules
     */
    protected function loadModule()
    {
        A::load(COMPONENTS, 'MainModule', false);
        $module = ucfirst($this->request->module);
        $this->_m = A::load(MODULES, $module);
    }
}

