<?php

namespace App\Http\Middleware;

use App\NhanVien;
use Closure;
use Illuminate\Support\Facades\Auth;
class CheckLogin
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
        if(Auth::check()){
            return $next($request);   
        }else{
            return redirect('admin/login');
        }
    }

    public  function check($email,$pass){
        $nhanvien=NhanVien::getAccountAdmin();
        //dd($nhanvien);
        foreach($nhanvien as $item){
            if($item->email==$email && $item->password==$pass)
            {
                return true;
            }
        }
        return false;
    }

}
