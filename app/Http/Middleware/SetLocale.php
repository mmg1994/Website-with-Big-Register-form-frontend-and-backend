<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Your logic for setting the locale goes here

        // For example, you can access the locale from the request URL
        $locale = $request->segment(1); // Assuming the locale is the first segment of the URL

        // Set the locale for the current request
        app()->setLocale($locale);

        return $next($request);
    }
}