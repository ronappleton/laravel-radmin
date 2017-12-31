<?php

namespace RonAppleton\Radmin\Exceptions;

use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Auth\AuthenticationException;

class RadminHandler extends Handler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if(str_contains($request->getRequestUri(), 'admin') !== true)
        {
            return $request->expectsJson()
                ? response()->json(['message' => $exception->getMessage()], 401)
                : redirect()->guest(route('login'));
        }
        else {
            return $request->expectsJson()
                ? response()->json(['message' => $exception->getMessage()], 401)
                : redirect()->guest(route('admin.login'));
        }
    }
}