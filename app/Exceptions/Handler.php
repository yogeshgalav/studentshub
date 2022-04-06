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
use Inertia\Inertia;

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
        $exception_code = $exception->getCode();
        if ($exception_code == 401) {
            Log::warning('Unauthorized',['url'=>$request->url()]);
        }
        if ($exception_code == 404) {
            Log::warning('PageNotFound',['url'=>$request->url()]);
        }
        if ($exception_code == 419) {
                Log::warning('TokenMismatchException',['url'=>$request->url(), 'request'=>$request, 'exception'=>$exception]);
        }
        //api exception
        if ($request->wantsJson()) {
            if ($exception instanceof ModelNotFoundException) {
                Log::warning('ModelNotFoundException',['url'=>$request->url(), 'request'=>$request, 'exception'=>$exception]);
                return response()->json(['error'=>[
                    'message' => 'Resource not found',
                ]], 404);
            }
    
            if ($exception instanceof AuthorizationException) {
                Log::warning('AuthorizationException',['url'=>$request->url(), 'request'=>$request, 'exception'=>$exception]);
                return response()->json(['error'=>[
                    'message' => 'Forbidden',
                ]], 403);
            }
    
            if ($exception instanceof ValidationException) {
                Log::warnig('ValidationException',['url'=>$request->url(), 'request'=>$request, 'exception'=>$exception]);
                return response()->json(['error'=>[
                    'message'=>'Validation Error',
                    'errors'=>$exception->validator->errors()
                ]],422);
            }
        } 
        //web exception
        if (!$request->wantsJson()) {
            if (!app()->environment(['local', 'testing']) && in_array($exception_code, [500, 503, 404, 403])) {
                return Inertia::render('Error/error', ['status' => $exception_code])
                    ->toResponse($request)
                    ->setStatusCode($exception_code);
            } else if ($exception_code === 419) {
                return back()->with([
                    'message' => 'The page expired, please try again.',
                ]);
            }
        }
        
        return parent::render($request, $exception);
    }
}
