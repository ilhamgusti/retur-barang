<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        // Force to application/json rendering on API calls
        if ($request->is('api*')) {
            // set Accept request header to application/json
            $request->headers->set('Accept', 'application/json');
        }

        // Default to the parent class' implementation of handler
        return parent::render($request, $e);
    }
    
}
