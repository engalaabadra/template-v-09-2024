<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CustomException extends Exception
{
    public $statusCode;

    public function __construct($message = "Custom error message", $statusCode = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->statusCode);
    }
}
