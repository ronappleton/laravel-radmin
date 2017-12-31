<?php

namespace RonAppleton\Radmin\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;

class RadminAthenticate extends Authenticate
{
    protected function authenticate(array $guards)
    {
        if (empty($guards)) {
            return $this->auth->authenticate();
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        return redirect('admin.login');
    }
}
