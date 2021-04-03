<?php

 
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
  
class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()      // this function direct go to google
    {
        return Socialite::driver('google')->redirect();
    }
      
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()  // this function get user login of googlre
    {
        try {
           
            $user = Socialite::driver('google')->user();
            
            $finduser = User::where('google_id', $user->id)->first();
           
            if($finduser){
     
                Auth::login($finduser);


                Cookie::queue('khachhang',$finduser['email'],2628000);
                Cookie::queue('ten',$finduser['name'],2628000);
                Cookie::queue('cmnd',$finduser['id'],2628000);
                return redirect()->action('SanPhamController@ShowProduct');

     
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
    
                Auth::login($newUser);
     
                Cookie::queue('khachhang',$newUser['email'],2628000);
                Cookie::queue('ten',$newUser['name'],2628000);
                Cookie::queue('cmnd',$newUser['id'],2628000);
                return redirect()->action('SanPhamController@ShowProduct');
            }
    
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
