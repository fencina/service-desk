<?php

namespace App\Exceptions;


use Illuminate\Contracts\Support\Responsable;

class ApiException extends \Exception implements Responsable
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => 'An error ocurred with Service Desk Api. Contact InvGate.',
        ]);
    }
}