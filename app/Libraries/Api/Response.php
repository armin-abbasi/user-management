<?php

namespace App\Libraries\Api;

class Response
{
    /**
     * @var integer $code
     */
    public $code;

    /**
     * @var string $message
     */
    public $message;

    /**
     * @var array
     */
    public $data;

    /**
     * @var int $statusCode
     */
    public $statusCode;

    /**
     * Response constructor.
     * @param int $code
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     */
    public function __construct(int $code, string $message, $data = [], int $statusCode = 200)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * Return all data in HTTP JSON format.
     * @return \Illuminate\Http\Response
     */
    public function toJson()
    {
        return response([
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
        ], $this->statusCode);
    }
}