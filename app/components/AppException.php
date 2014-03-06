<?php
/**
 * AppException component. Handler exception.
 *
 * PHP version 5
 *
 * @category Components
 * @author   Denis Porplenko  <porplenko@gmail.com>
 */

class AppException extends Exception
{
    /**
     * Status exception code
     * @var integer
     */
    protected $statusCode;

    const  HTTP200 = '200';
    const  HTTP400 = '400';
    const  HTTP500 = '500';

    /**
     * Construct
     * @param integer $statusCode status exception
     * @param string $message text exception
     */
    public function __construct($statusCode, $message)
    {
        $allowHttpCodes = array(
            AppException::HTTP200,
            AppException::HTTP400,
            AppException::HTTP500,
            );

        if (!in_array($statusCode, $allowHttpCodes)) {
            throw new Exception("Error statusCode Exception", 1);
        }
        $this->statusCode = $statusCode;
        parent::__construct($message);
    }

    /**
     * Initialization statusCode
     * @return integer status exception
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


}
