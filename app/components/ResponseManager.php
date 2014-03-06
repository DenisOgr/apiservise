<?php
/**
 * ResponseManager component
 *
 * PHP version 5
 *
 * @category Components
 * @author   Denis Porplenko  <porplenko@gmail.com>
 */

class ResponseManager
{
    /**
     * Response status code
     * @var int
     */
    public $code;

    /**
     * Response data
     * @var mixed
     */
    public $data;

    /**
     * Response message
     * @var string
     */
    public $message;

    /**
     * Send response to client
     */
    public function send()
    {
        A::load(COMPONENTS, 'ResponseTypeFactory', false);
        $provider = ResponseTypeFactory::build();

        echo $provider->handler($this->prepare());
    }

    /**
     * Prepare data before sending
     * @return array result array
     */
    protected function prepare()
    {
        return array(
            'code'    => $this->code,
            'data'    => $this->data,
            'message' => $this->message,
            );
    }

    /**
     * Render data from module action.
     * Set values from action module to response.
     * @param  array $data input array
     */
    public static function render($data)
    {
        $response = A::getMainApp()->response;
        $allowVars = get_object_vars($response);

        foreach ($allowVars as $key => $vars) {
            if (!empty($data[$key])) {
                $response->$key = $data[$key];
            }
        }
        if ($response->code === null) {
            $response->code = AppException::HTTP200;
        }
    }
}
