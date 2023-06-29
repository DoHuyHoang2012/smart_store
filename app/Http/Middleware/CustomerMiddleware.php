<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->has('customerInfo')){
            return redirect()->route('customer/login')->with('no','Vui lòng đăng nhập hệ thống');
        }else if(session('customerInfo')['status'] == 0) {
            $request->session()->pull('customerInfo');
            return redirect()->route('customer/login')->with('no','Tài khoản của bạn chưa được kích hoạt');
        }
 
        return $next($request);
    }
}