<?php

namespace App\Http\Controllers;

use App\BinhLuan;
use Illuminate\Http\Request;

class BinhLuanController extends Controller
{
    //Tạo bình luận 
    public function addComment(Request $req , $makh , $masp){
       $kq = BinhLuan::check($makh,$masp);
       if($kq){
        $binhluan = new BinhLuan();
        $binhluan->makhachhang = $makh;
        $binhluan->noidung = $req->content;
        $binhluan->masanpham = $masp;
        $binhluan->save();
        //dd('sdf');
        return redirect('frontend/detailProduct/'.$masp)->with('thongbao','Binh luận thành công');
       }
       return redirect()->back()->with('thongbaoloi', 'Bạn chưa mua sản phẩm nên không được đánh giá');
    }

}
