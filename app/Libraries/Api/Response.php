<?php

namespace App\Libraries\Api;

use Illuminate\Contracts\Routing\ResponseFactory;

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
     * @param integer $code
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
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function toJson()
    {
        return response([
            'responseCode' => $this->code,
            'responseMessage' => $this->message,
            'data' => $this->data,
        ], $this->statusCode);
    }
}