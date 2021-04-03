<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KhachHang;
use App\TheLoai;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class KhachHangController extends Controller
{
   
    // cho admin xem
    public function index()
    {
        $khachhang = KhachHang::all();
        //dd($khachhang[0]->chungminhnhandan);
        return view('admin.khachhang.danhsach',['khachhang'=>$khachhang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branch=TheLoai::all();
        return view('frontend.customer.register',['branch'=>$branch]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request,
        [
            'hoten'=>'bail|required',
            'sodienthoai'=>'bail|min:10|max:15|required|unique:khachhang',
            'ngaysinh'=>'bail|required',
            'cmnd'=>'bail|required|min:9|max:13|unique:khachhang,chungminhnhandan',
            'email'=>'bail|required|unique:khachhang',
            'matkhau'=>'bail|required',
            'xacnhanmatkhau'=>'bail|required',
            'diachi'=>'bail|required'
        ],
        [
            'hoten.required'=>'Họ tên không được để trống',
            'sodienthoai.required'=>'Số điện thoại không được để trống',
            'sodienthoai.min'=>'Số điện thoại không được ít hơn 9 và nhiều hơn 15 kí tự',
            'sodienthoai.max'=>'Số điện thoại không được ít hơn 9 và nhiều hơn 15 kí tự',
            'sodienthoai.unique'=>'Số điện thoại không được trùng',
            'cmnd.required'=>'Chứng minh nhân dân không được để trống',
            'cmnd.min'=>'Chứng minh nhân dân không được ít hơn 9 kí tự và nhiều hơn 13 kí tự',
            'cmnd.max'=>'Chứng minh nhân dân không được ít hơn 9 kí tự và nhiều hơn 13 kí tự',
            'cmnd.unique'=>'Chứng minh nhân dân không được trùng',
            'email.required'=>'Email không được bỏ trống',
            'email.unique'=>'Email không được trùng',
            'matkhau.required'=>'Mật khẩu không được bỏ trống',
            'xacnhanmatkhau.required'=>'Mật khẩu xác nhận không được để trống',
            'diachi.required'=>'Địa chỉ không được bỏ trống'
        ]);
         if($request->matkhau!=$request->xacnhanmatkhau){
            //return Redirect::back()->withErrors('thongbao' , "Mật khẩu xác nhận phải trùng với mật khẩu" );
           
            return redirect()->back()->withInput($request->input())->with('thongbao',"Mật khẩu xác nhận phải trùng với mật khẩu");
         }   
         
         $khachhang=new KhachHang();
         $khachhang->chungminhnhandan=$request->cmnd;
         $khachhang->tenkhachhang=$request->hoten;
         $khachhang->sodienthoai=$request->sodienthoai;
         $khachhang->ngaysinh=$request->ngaysinh;
         $khachhang->gioitinh=$request->gioitinh;
         $khachhang->diachi=$request->diachi;
         $khachhang->email=$request->email;
         $khachhang->password=md5($request->matkhau);
         $khachhang->save();
         return redirect('frontend/dangnhap')->with('thongbao','Đăng ký thành công vui lòng đăng nhập');
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
    {   $branch=TheLoai::all();
        $khachhang=KhachHang::find($id);
        return view('frontend.customer.edit',['khachhang'=>$khachhang,'branch'=>$branch]);
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
        $this->validate($request,
        [
            'ten'=>'bail|required',
            'sodienthoai'=>'bail|min:10|max:15|required|unique:khachhang,sodienthoai,'.$id.',chungminhnhandan',
            'ngaysinh'=>'bail|required',
            'email'=>'bail|required|unique:khachhang,email,'.$id.',chungminhnhandan',
            'diachi'=>'bail|required'
        ],
        [
            'hoten.required'=>'Họ tên không được để trống',
            'sodienthoai.required'=>'Số điện thoại không được để trống',
            'sodienthoai.min'=>'Số điện thoại không được ít hơn 9 và nhiều hơn 15 kí tự',
            'sodienthoai.max'=>'Số điện thoại không được ít hơn 9 và nhiều hơn 15 kí tự',
            'sodienthoai.unique'=>'Số điện thoại không được trùng',
            'email.required'=>'Email không được bỏ trống',
            'email.unique'=>'Email không được trùng',
            'diachi.required'=>'Địa chỉ không được bỏ trống'
        ]);
        $khachhang=KhachHang::find($id);
        $khachhang->tenkhachhang=$request->ten;
        $khachhang->sodienthoai=$request->sodienthoai;
        $khachhang->ngaysinh=$request->ngaysinh;
        $khachhang->gioitinh=$request->gioitinh;
        $khachhang->diachi=$request->diachi;
        $khachhang->email=$request->email;
        $khachhang->save();
        return redirect('frontend/edit/'.$id)->with('thongbao',"Cập nhật thành công");
    }

    public function updatePass(Request $request,$id){
        $this->validate($request,
        [
            'pass'=>'bail|required',
            'passNew'=>'bail|required',
            'passConfirm'=>'bail|required',
        ],
        [
            'pass.required'=>'Mật khẩu cũ không được bỏ trống',
            'passConfirm.required'=>'Mật khẩu xác nhận không được để trống',
            'passNew.required'=>'Mật khẩu mới không được để trống',
        ]);
       
        $khachhang=KhachHang::find($id);
        
        if($khachhang->password!=md5($request->pass)){
            return redirect('frontend/edit/'.$id)->with('thongbaoloi','Mật khẩu cũ không hợp lệ');
        }
        if($request->passNew!=$request->passConfirm){
            return redirect('frontend/edit/'.$id)->with('thongbaoloi','Mật khẩu xác nhận không khớp');
        }
        $khachhang->password=md5($request->passNew);
        $khachhang->save();
        return redirect('frontend/edit/'.$id)->with('thongbao',"Cập nhật thành công");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $khachhang = KhachHang::find($id);
       // dd($khachhang);
        $khachhang->delete();
        return redirect('admin/khachhang/danhsach')->with('thongbao', 'Xóa thành công một khách hàng');
    }
    
    public function formdangnhap(){
        $branch=TheLoai::all();
        return view('frontend.customer.login',['branch'=>$branch]);
    }

    public function dangnhap(Request $request){
        $this->validate($request,
        [
            'email'=>'bail|required',
            'password'=>'bail|required'
        ],
        [
            'email.required'=>'Email không được để trống',
            'password.required'=>'Password không được để trống'
        ]);
        $khachhang=KhachHang::all();
        foreach($khachhang as $item){
            if($item->email==$request->email && $item->password==md5($request->password)){
                Cookie::queue('khachhang',$item,2628000);
                Cookie::queue('ten',$item->tenkhachhang,2628000);
                Cookie::queue('cmnd',$item->chungminhnhandan,2628000);
                return redirect()->action('SanPhamController@ShowProduct');
            }
        }
        return redirect('frontend/dangnhap')->with('thongbaoloi','Email hoặc Password sai');
    }

    public function dangxuat(){
        Cookie::queue(Cookie::forget('khachhang'));
        Cookie::queue(Cookie::forget('ten'));
        Cookie::queue(Cookie::forget('cmnd'));
        return redirect('frontend/trangchu');
    }

}
