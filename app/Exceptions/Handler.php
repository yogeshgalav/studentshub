<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Support\Facades\Log;

/***
 * Class Handler
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        // \App\Exceptions\EmailAddressAlreadyExistsException::class,
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
     * @param Throwable $exception
     *
     * @return void
     * @throws Exception
     */
    

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     *
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception->getCode() == 401) {
            Log::warning('Unauthorized',['url'=>$request->url()]);
        }
        if ($exception->getCode() == 404) {
            Log::warning('PageNotFound',['url'=>$request->url()]);
        }
        if ($exception->getCode() == 419) {
                Log::warning('TokenMismatchException',['url'=>$request->url(), 'request'=>$request, 'exception'=>$exception]);
        }
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            Log::warning('ModelNotFoundException',['url'=>$request->url(), 'request'=>$request, 'exception'=>$exception]);
            return response()->json(['error'=>[
                'message' => 'Resource not found',
            ]], 404);
        }

        if ($exception instanceof AuthorizationException && $request->wantsJson()) {
            Log::warning('AuthorizationException',['url'=>$request->url(), 'request'=>$request, 'exception'=>$exception]);
            return response()->json(['error'=>[
                'message' => 'Forbidden',
            ]], 403);
        }

        if ($exception instanceof ValidationException && $request->wantsJson()) {
            Log::warnig('ValidationException',['url'=>$request->url(), 'request'=>$request, 'exception'=>$exception]);
            return response()->json(['error'=>[
                'message'=>'Validation Error',
                'errors'=>$exception->validator->errors()
            ]],422);
        }

        return parent::render($request, $exception);
    }
}
