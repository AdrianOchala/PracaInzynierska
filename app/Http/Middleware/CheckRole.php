<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array $role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        if(Auth::check()){
            $userRole = Auth::user()->role->name; //Rola zalogowanego użytkownika
            if(in_array($userRole, $role)) //Sprawdzam czy rola użytkownika pozwala na dostęp
            {
                return $next($request);
            }else{
                return redirect('/unauthorised')->with(['msg'=>'Brak uprawnień do korzystania z tej podstrony']);
            }

        }
        return redirect('/unauthorised')->with(['msg'=>'Zaloguj się aby korzystać z tej podstrony']);
    }
}
