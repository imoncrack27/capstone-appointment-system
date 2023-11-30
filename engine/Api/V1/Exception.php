<?php


namespace EA\Engine\Api\V1;

/**
 * API v1 Exception Class
 *
 * This exception variation will hold the information needed for exception handling in the API.
 *
 * @deprecated
 */
class Exception extends \Exception {
    /**
     * Header Description
     *
     * e.g. 'Unauthorized'
     *
     * @var string
     */
    protected $header;

    /**
     * Class Constructor
     *
     * @link http://php.net/manual/en/class.exception.php
     *
     * @param string $message
     * @param int $code
     * @param string $header
     * @param \Exception|null $previous
     */
    public function __construct($message = NULL, $code = 500, $header = '', \Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
        $this->header = $header;
    }

    /**
     * Get the header string.
     *
     * @return string
     */
    public function get_header()
    {
        return $this->header;
    }
}
