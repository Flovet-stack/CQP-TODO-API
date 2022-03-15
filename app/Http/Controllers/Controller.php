<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $statusCode, $status)
    {
        $response = [
            'success' => true,
            'statusCode' => $statusCode,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, $status);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($message, $statusCode, $status, $errors = [])
    {
        $response = [
            'success' => false,
            'statusCode' => $status,
            'status' => $statusCode,
            'message' => $message,
            "errors" => $errors,
        ];


        return response()->json($response, $status);
    }
}
