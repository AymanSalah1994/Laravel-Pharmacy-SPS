<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Doctor;

class CheckDoctorBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if($user->userable_type == 'App\Models\Doctor'){
        $doctor = Doctor::findOrFail($user->userable_id);
            if ($doctor->is_banned == 1) {
                return response()->view('doctor.ban', [], 403);
            }
      }
        return $next($request);
    }
}
