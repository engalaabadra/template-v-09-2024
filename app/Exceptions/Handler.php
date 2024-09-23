<?php

namespace App\Exceptions;

use App\Traits\HandlerTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
  //  use HandlerTrait;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // return response()->json([
        //     'message' => 'Internal Server Error',
        //     ], 500); // Respond with 500 Internal Server Error
        $this->exceptions();
        // // Handle specific exceptions globally
        // $this->renderable(function (CustomException $e, $request) {
        //     return response()->json([
        //         'error' => $e->getMessage(),
        //     ], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        // });

        // You can add more exception types here if needed

    }
    public function exceptions()
    {
        // Catch CustomException and handle it
        $this->renderable(function (CustomException $e, $request) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        });

        // Add more custom exception handling if needed
        // $this->renderable(function (AnotherCustomException $e, $request) {
        //     return response()->json([
        //         'error' => $e->getMessage(),
        //     ], $e->getCode());
        // });
    }
    // public function exceptions()
    // {
    //     $this->renderable(function (CustomException $e, $request) {
    //         return response()->json([
    //             'error' => $e->getMessage(),
    //         ], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
    //     });

    //     $this->renderable(function (AnotherCustomException $e, $request) {
    //         return response()->json([
    //             'error' => $e->getMessage(),
    //         ], $e->getCode() ?: $e->getCode());
    //     });
    // }
    //  /**
    //  * Render an exception into an HTTP response.
    //  */
    // public function render($request, Throwable $exception)
    // {
    //     // This is effectively a global try-catch where we handle all exceptions
    //     try {
    //         return parent::render($request, $exception);
    //     } catch (Throwable $e) {
    //         // Catch any unhandled exceptions
    //         return response()->json([
    //             'error' => 'An unexpected error occurred',
    //             'message' => $e->getMessage(),
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }
    // // Render an exception into an HTTP response
    // public function render($request, Throwable $exception)
    // {
    //     try{

    //         if ($exception instanceof CustomException) {
    //             return $exception->render($request);
    //         }
            
    //         return parent::render($request, $exception);
    //     }catch (Throwable $e) {
    //         // This will handle all uncaught exceptions and return a custom response
    //         return response()->json([
    //             'message' => 'An error occurred.',
    //             'error' => $e->getMessage(),
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    // // Custom method to handle JSON exceptions
    // protected function handleJsonException(Exception $exception)
    // {
    //     // Customize the response based on exception type
    //     $status = $this->getStatusCodeForException($exception);
    //     $message = $this->getMessageForException($exception);

    //     return response()->json([
    //         'error' => $message,
    //     ], $status);
    //     // if ($exception instanceof \App\Exceptions\CustomException) {
    //     //     return response()->json([
    //     //         'error' => 'Custom error message',
    //     //     ], 400); // Use a custom status code if needed
    //     // }
    
    //     // // Default handling
    //     // return parent::render($request, $exception);
    
    // }

    // // Get status code based on exception
    // protected function getStatusCodeForException(Exception $exception)
    // {
    //     if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
    //         return SymfonyResponse::HTTP_NOT_FOUND;
    //     }

    //     if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
    //         return SymfonyResponse::HTTP_UNAUTHORIZED;
    //     }

    //     // Add more conditions as needed

    //     return SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
    // }

    // // Get message based on exception
    // protected function getMessageForException(Exception $exception)
    // {
    //     return $exception->getMessage() ?: 'An error occurred';
    // }
}
