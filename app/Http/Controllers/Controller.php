<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successResponse($data, $message)
    {
        $response = [
            'succsess' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, 200);
    }

    public function errorResponse($message, $errorMessages = [], $statusCode = 404)
    {
        $response = [
            'succsess' => true,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $statusCode);
    }
}
