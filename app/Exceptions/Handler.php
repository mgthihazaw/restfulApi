<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\QueryException;

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
    public function render($request, Exception $e)
    {
        // if ($e instanceof ValidationException) {
        //     return response(['error' =>"mm"],404);
        // }
        if($e instanceof NotFoundHttpException){
            return response(['error' =>"URL does not exit {base_classname($e)}","code"=>404],404);
        }
        if($e instanceof ModelNotFoundException){
            $model=class_basename($e->getModel());
            return response(['error' =>"Does not exit any {$model} with this specified identificator","code"=>404],404);
        }
        if($e instanceof AuthenticationException){
            return response(['error' =>"UnAuthenticated User","code"=>403],403);
        }
        if($e instanceof AuthorizationException){
            return response(['error' =>"Unauthorized User","code"=>403],403);
        }
        if($e instanceof MethodNotAllowedHttpException){
            return response(['error' =>"This specified method for the request is invalid","code"=>$e->getStatusCode()],$e->getStatusCode());
        }
        if($e instanceof HttpException){
            return response(['error' =>$e->getMessage(),"code"=>$e->getStatusCode()],$e->getStatusCode());
        }
        if($e instanceof QueryException){
            // dd($e);
            $errorCode =$e->errorInfo[2];
           return  $code =$e->errorInfo;
            return response(['error' =>$errorCode,"code"=>409],409);
        }

        return parent::render($request, $e);
    }
    
}
