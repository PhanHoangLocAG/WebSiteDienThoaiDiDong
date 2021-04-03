<?php

use App\Http\Controllers\BinhLuanController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\NhanVienController;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/facebook','Auth\FaceBookController@redirectToFaceBook');
Route::get('auth/facebook/callback','Auth\FaceBookController@handleFaceBookCallback');

Route::get('auth/google','Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback','Auth\GoogleController@handleGoogleCallback');

//login
Route::get('/login',function(){
    return view('admin.login');
});

Route::group(['prefix'=>'admin'],function(){
    
   
    Route::get('login','LoginController@create');
    Route::post('login','LoginController@store');
    Route::get('logout','LoginController@logout');
    //Loại sản phẩm
    Route::group(['prefix'=>'theloai'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('them','TheLoaiController@create');
            Route::post('them','TheLoaiController@store');
            Route::get('danhsach','TheLoaiController@index');
            Route::get('xoa/{ma}','TheLoaiController@destroy');
            Route::get('sua/{ma}','TheLoaiController@edit');
            Route::post('sua/{ma}','TheLoaiController@update');
        });
    });

    //Nhan Vien
    Route::group(['prefix'=>'nhanvien'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('them','NhanVienController@create');
            Route::post('them','NhanVienController@store');
            Route::get('xoa/{ma}','NhanVienController@destroy');
            Route::get('sua/{ma}','NhanVienController@edit');
            Route::post('sua/{ma}','NhanVienController@update');
            Route::get('danhsach','NhanVienController@index');
        });
    });

    //Sản phẩm
    Route::group(['prefix'=>'sanpham'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('them','SanPhamController@create');
            Route::post('them','SanPhamController@store');
            Route::get('xoa/{ma}','SanPhamController@destroy');
            Route::get('sua/{ma}','SanPhamController@edit');
            Route::post('sua/{ma}','SanPhamController@update');
            Route::get('danhsach','SanPhamController@index');
        });

    });

    //Giảm giá sản phẩm
    Route::group(['prefix'=>'sanpham'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('discountlist','DiscountController@index');
            Route::get('discount/{ma}','DiscountController@create');
            Route::post('discount/{ma}','DiscountController@store');
            Route::get('deleteDiscount/{ma}','DiscountController@destroy');
            Route::get('editDiscount/{ma}','DiscountController@edit');
            Route::post('editDiscount/{ma}','DiscountController@update');
        });
    });


    //khach hang
    Route::group(['prefix'=>'khachhang'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('danhsach','KhachHangController@index');
            Route::get('xoa/{ma}','KhachHangController@destroy');
        });
    });

    //chuc vu
    Route::group(['prefix'=>'chucvu'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('them','ChucVuController@create');
            Route::post('them','ChucVuController@store');
            Route::get('xoa/{ma}','ChucVuController@destroy');
            Route::get('sua/{ma}','ChucVuController@edit');
            Route::post('sua/{ma}','ChucVuController@update');
            Route::get('danhsach','ChucVuController@index');
        });
    });

    //luong
    Route::group(['prefix'=>'luong'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('them','LuongController@create');
            Route::post('them','LuongController@store');
            Route::get('xoa/{ma}','LuongController@destroy');
            Route::get('sua/{ma}','LuongController@edit');
            Route::post('sua/{ma}','LuongController@update');
            Route::get('danhsach','LuongController@index');
        });
    });

    //kich thuoc
    Route::group(['prefix'=>'kichthuoc'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('them','KichThuocController@create');
            Route::post('them','KichThuocController@store');
            Route::get('xoa/{ma}','KichThuocController@destroy');
            Route::get('sua/{ma}','KichThuocController@edit');
            Route::post('sua/{ma}','KichThuocController@update');
            Route::get('danhsach','KichThuocController@index');
        });
    });


    //Mau sac
    Route::group(['prefix'=>'mausac'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('them','MauSacController@create');
            Route::post('them','MauSacController@store');
            Route::get('xoa/{ma}','MauSacController@destroy');
            Route::get('sua/{ma}','MauSacController@edit');
            Route::post('sua/{ma}','MauSacController@update');
            Route::get('danhsach','MauSacController@index');
        });
    });


    //Hinh
    Route::group(['prefix'=>'hinh'],function(){
        Route::middleware(['login'])->group(function () {
            Route::get('them','Controller@create');
            Route::post('them','Controller@store');
            Route::get('xoa/{ma}','Controller@destroy');
            Route::get('sua/{ma}','Controller@edit');
            Route::post('sua/{ma}','Controller@update');
            Route::get('danhsach','Controller@index');
        });
    });

    //Hóa đơn
    Route::group(['prefix'=>'hoadon'],function(){

        Route::middleware(['login'])->group(function () {
            Route::get('danhsach','ChiTietHoaDonController@listInvoice');
            Route::get('edit/{ma}','ChiTietHoaDonController@edit');
            Route::get('danhsachthanhtoan','ChiTietHoaDonController@listInvoiced');
        });
    });
});


Route::group(['prefix'=>'frontend'],function(){
    
    //home
    Route::get('trangchu','SanPhamController@ShowProduct');

    //dang ky va dang nhap khach hang
    Route::get('dangnhap','KhachHangController@formdangnhap');
    Route::post('dangnhap','KhachHangController@dangnhap');
    Route::get('dangky','KhachHangController@create');
    Route::post('dangky','KhachHangController@store');
    Route::get('edit/{ma}','KhachHangController@edit');
    Route::get('dangxuat','KhachHangController@dangxuat');
    Route::post('sua/{ma}','KhachHangController@update');
    Route::post('update/{ma}','KhachHangController@updatePass');


    //detail product
    Route::get('detailProduct/{ma}','SanPhamController@show');
    
    
    //gio hang
    Route::get('giohang','GioHangController@index');
    Route::get('add/{ma}','GioHangController@Addcart');
    Route::get('add/{ma}/{mkh}','GioHangController@AddcartFromWish');
    Route::get('deleteCart/{ma}','GioHangController@Deletecart');
    Route::get('editCart','GioHangController@UpdateCart');
    //san pham yeu thich
    Route::get('yeuthich/{ma}','YeuThichController@show');
    Route::get('themyeuthich/{ma}/{masp}','YeuThichController@store');
    Route::get('xoayeuthich/{ma}/{masp}','YeuThichController@destroy');

    //dat hang
    Route::get('dathang/{ma}' , 'ChiTietHoaDonController@index');
    Route::post('muahang/{ma}' , 'ChiTietHoaDonController@store');
    Route::get('donhang/{ma}' , 'ChiTietHoaDonController@show');
    Route::get('huydon/{ma}' , 'ChiTietHoaDonController@destroy');

    //Tim kiem
    Route::post('timkiem','SanPhamController@search');
    Route::get('timkiemloai/{ten}/{maloai}','SanPhamController@searchType');
    Route::get('timkiemgia/{ten}/{gia}','SanPhamController@searchPrice');
    Route::get('timkiemkhuyenmai/{ten}','SanPhamController@searchDiscount');
    Route::get('timkiemsanphammoi/{ten}','SanPhamController@searchNewProduct');
    Route::get('timkiemcaodenthap/{ten}','SanPhamController@searchPriceHightToLow');
    Route::get('timkiemthapdencao/{ten}','SanPhamController@searchPriceLowToHight');

    //Binh luan
    Route::post('binhluan/{makh}/{masanpham}','BinhLuanController@addComment');
});

Route::get('sentmail','MailController@basic_email');