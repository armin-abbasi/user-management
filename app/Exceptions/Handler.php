<?php

namespace App\Exceptions;

use App\Libraries\Api\Response;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Display exception info if in debug mode.
        $data = env('APP_DEBUG', false) == true ? (string)$exception : null;

        $errorInfo = $this->getInfo($exception);

        // Return particular error code or -1 if not given.
        $code = $errorInfo['code'] ?: -1;

        // Return error messages in case of Validation Exception.
        $data = $errorInfo['data'] ?: $data;

        return (new Response($code, $errorInfo['message'], $data, $errorInfo['status']))->toJson();
    }

    /**
     * Return distinguished error message and status codes.
     *
     * @param Exception $exception
     * @return array
     */
    private function getInfo(Exception $exception)
    {
        $code = null;
        $data = null;

        if ($exception instanceof NotFoundHttpException) {
            $status = 404;
            $message = trans('messages.errors.not_found');
        } elseif ($exception instanceof UnAuthenticatedUser) {
            $status = 401;
            $code = -3;
            $message = $exception->getMessage();
        } elseif ($exception->getCode() == 23000) {
            $status = 400;
            $message = trans('messages.errors.resource_exists');
        } elseif ($exception instanceof NotFoundResourceException) {
            $status = 404;
            $message = $exception->getMessage();
        } elseif ($exception instanceof ValidationException) {
            $status = 420;
            $code = -2;
            $data = $exception->errors();
            $message = trans('messages.errors.invalid_input');
        } else {
            $status = 500;
            $message = trans('messages.errors.general');
        }

        return [
            'status' => $status,
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ];
    }
}
