<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveIndex
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getRequestUri() == '/Avery/index.php') {
            $newUrl = str_replace('/index.php', '', $request->url());
           // echo 'in';
            return redirect()->to($newUrl);
        }
        
        return $next($request);
    }
}
