<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function success($message, $data= null)
    {
        $response = [];
        $response['result'] = true;
        $response['message'] = $message;
        if (!is_null($data)) {
            $response['data'] = $data;
        }
        return response()->json([
            $response
        ],200);
    }
    protected function created($message, $data)
    {
        return response()->json([
            'result' => true,
            'message' => $message,
            'data' => $data,
        ],201);
    }
    protected function notFound($message)
    {
        return response()->json([
            'result' => false,
            'message' => $message,
        ],404);
    }
}
