<?php

namespace App\Exceptions;

use App\Libraries\Api\Response;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $data = env('APP_DEBUG', false) == true ? $exception : null;

        $errorInfo = $this->getInfo($exception);

        return (new Response(-1, $errorInfo['message'], $data, $errorInfo['status']))->toJson();
    }

    /**
     * Return distinguished error message and status codes.
     *
     * @param Exception $exception
     * @return array
     */
    private function getInfo(Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            $status = 404;
            $message = trans('messages.errors.not_found');
        } else {
            $status = 500;
            $message = trans('messages.errors.general');
        }

        return [
            'status' => $status,
            'message' => $message,
        ];
    }
}
