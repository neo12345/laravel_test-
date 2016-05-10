<?php

namespace App\Http\Middleware;

use Closure;

class EditFormCreatePost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();
        
        $input['title'] = 'middleware.'.$input['title'];
        $input['slug'] = 'middleware.'.$input['slug'];
        $input['description'] = 'middleware.'.$input['description'];
        $input['content'] = 'middleware.'.$input['content'];
        $request->replace($input);
        
        return $next($request);
    }
}
