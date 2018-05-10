<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
//use Illuminate\Database\Eloquent\NotFoundHttpException as NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use Illuminate\Http\Response;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //dd($exception);
        if($request->expectsJson())
        {
            if($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'errors' => 'Product Model not found'
                ], Response::HTTP_NOT_FOUND);
                //return 'model not found';
            }   

            if($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'errors' => 'Incorect route'
                ], Response::HTTP_NOT_FOUND);
                //return 'model not found';
            }   

            
        }
        

        return parent::render($request, $exception);
    }
}
