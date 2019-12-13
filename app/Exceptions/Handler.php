<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @param Exception $exception
     * @return mixed|void
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
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if($request->expectsJson()){
            $response = [
                'result' => false,
                'message' => $exception->getMessage(),
            ];

            $code = 200;

            switch (get_class($exception)){
                case \Illuminate\Validation\ValidationException::class:
                    /**
                     * @var \Illuminate\Validation\ValidationException $exception
                     */
                    $response['errors'] =  $exception->errors();
                    $code = 422;
                    break;

                case \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException::class:
                case \Tymon\JWTAuth\Exceptions\TokenExpiredException::class:
                    $code = 401;
                    break;

                case \Illuminate\Database\Eloquent\ModelNotFoundException::class:
                    $code = 404;
                    break;
            }

            return response()->json($response, $code);
        } else {
            return parent::render($request, $exception);
        }
    }
}
