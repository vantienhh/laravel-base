<?php

namespace App\Http\Controllers\Response;

use App\Http\Transformers\OptimusPrime;
use Symfony\Component\HttpFoundation\Response;

trait ResponseHandler
{
    protected $transform;

    protected function setTransformer($transform)
    {
        $this->transform = $transform;
    }

    private function transform($data)
    {
        $optimus = app()->make(OptimusPrime::class);
        return $optimus->transform($data, $this->transform);
    }

    protected function successResponse($data)
    {
        if ($this->transform) {
            $response = array_merge([
                'code' => 200,
                'status' => 'success',
            ], $this->transform($data));
            return response()->json($response, $response['code']);
        } else {
            if (is_null($data)) {
                $data = [];
            }
            $response = array_merge([
                'code' => 200,
                'status' => 'success',
            ], ['data' => $data]);
            return response()->json($response, Response::HTTP_OK);
        }
    }

    protected function notFoundResponse()
    {
        $response = [
            'code'    => Response::HTTP_NOT_FOUND,
            'status'  => 'error',
            'data'    => 'Resource Not Found',
            'message' => 'Not Found'
        ];
        return response()->json($response, $response['code']);
    }

    protected function errorResponse($data)
    {
        $response = [
            'code'    => 422,
            'status'  => 'error',
            'data'    => $data,
            'message' => 'Unprocessable Entity'
        ];
        return response()->json($response, $response['code']);
    }

}
