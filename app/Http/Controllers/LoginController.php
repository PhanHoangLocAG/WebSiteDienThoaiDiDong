<?php

namespace App\Http\Controllers;

use App\KhachHang;
use App\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()//Call Form Login
    {
       
        return view('admin.login');
    }

    public function logout(){
        Cookie::queue(Cookie::forget('name'));
        Cookie::queue(Cookie::forget('pass'));
        return view('admin.login');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//Dang nhap
    {
        try {
            if(!isset($request->email) || !isset($request->password)) throw new \Exception("Nhập đầy đủ thông tin!");
            $data = $request->only('email', 'password');
            if (!Auth::attempt($data)) throw new \Exception("Tài khoản hoặc mật khẩu không chính xác!");
            return view('admin.dashboard');
            
        } catch(\Exception $e) {
            return redirect()->back()->with('thongbao',$e->getMessage());   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
