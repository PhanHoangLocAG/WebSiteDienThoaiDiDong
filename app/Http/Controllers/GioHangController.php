<?php

namespace App\Http\Controllers;
session_start();
use App\Cart;
use App\GioHang;
use App\SanPham;
use App\TheLoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;
//use Illuminate\Support\Facades\Session;
use Session;
class GioHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Addcart(Request $req,$id){
        //dd($id);
        $sanpham = SanPham::getDetailProduct($id);
        $id = str_replace("_" , " " , $id);
        $sanpham=$this->getSanPham($sanpham[0]); 
        if($sanpham != null){
            $oldCart = Session('Cart') ? Session('Cart') : null;
            //dd($oldCart);
            $newCart = new Cart($oldCart);
            //dd($newCart,$oldCart);
            $newCart->AddCart($sanpham,$id);
            //dd($newCart);
            $req->session()->put('Cart',$newCart);
            //dd($req->session()->get('Cart'),$newCart);
        }
        
        return redirect('frontend/giohang');
    }

    public function AddcartFromWish(Request $req,$id,$kh){
        $sanpham = SanPham::getDetailProduct($id);
        $sanpham=$this->getSanPham($sanpham[0]); 
        if($sanpham != null){
            $oldCart = Session('Cart') ? Session('Cart') : null;
            //dd($oldCart);
            $newCart = new Cart($oldCart);
            //dd($newCart,$oldCart);
            $newCart->AddCart($sanpham,$id);
            //dd($newCart);
            $req->session()->put('Cart',$newCart);
            //dd($req->session()->get('Cart'),$newCart);
        }
        DB::table('yeuthich')->where('makhachhang','=',$kh)->where('masanpham','=',$id)->delete();
        return redirect('frontend/giohang');
    }

    public function Deletecart(Request $req,$id){
            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->DeleteCart($id);
            if(Count($newCart->products) > 0){
                $req->session()->put('Cart',$newCart);
            }else{
                $req->session()->forget('Cart');
            }
            return redirect('frontend/giohang');
        }

    public function UpdateCart(Request $req){
        
        $oldCart = Session('Cart') ? Session('Cart') : null;
        if($oldCart == null){
            return redirect()->back()->with('thongbao','Chưa có sản phẩm để cập nhật');
        }
        $newCart = new Cart($oldCart);
        //dd($newCart);
        foreach($req->request as $key => $value){
            $key = str_replace("_" , " " , $key);
            $newCart->UpdateCart($key, $value);
        }
        if(Count($newCart->products) > 0){
            $req->session()->put('Cart',$newCart);
        }else{
            $req->session()->forget('Cart');
        }
        return redirect('frontend/giohang');
    }
    

    public function index()
    {
        $branch=TheLoai::all(); 
        //$sanpham=SanPham::getdiscount();
        $Cart = Session('Cart') ? Session('Cart') : null ;
        
        return view('frontend.giohang.cart',['branch'=>$branch,'cart'=>$Cart]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        
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

    //toi uu san pham
    public function getSanPham($sanpham){
        if($sanpham != null){
            $arr = explode(';',$sanpham->hinh);
            $sanpham->hinh = $arr[0];
            if($sanpham->Money_discount != null){
                $sanpham->giaban = $sanpham->Money_discount;
            }
            
        }
        return $sanpham;
    }
}
