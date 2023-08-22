<?php

namespace App\Http\Middleware;

use App\Http\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;

class CollegeMiddleWare
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       $college_id= auth('sanctum')->user()->currentAccessToken()->college_id;
        if($request->route('id')== $college_id)
        {
            return $next($request);
        }
       else
       {
        return $this->apiResponse((object)[],false,'you did not register for this college',403);
       }
    }
}
