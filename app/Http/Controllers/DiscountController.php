<?php

namespace App\Http\Controllers;

use App\Discount;
use App\SanPham;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sanpham=Discount::all();
        return view('admin.sanpham.discountlist',['sanpham'=>$sanpham]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $sanpham=SanPham::find($id);
        return view('admin.sanpham.discount',['sanpham'=>$sanpham]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $giamgia=Discount::find($id);
        if($giamgia==null){
            $sanpham=SanPham::find($request->masanpham);
            $discount=new Discount();
            $discount->masanpham=$request->masanpham;
            $discount->tensanpham=$request->tensanpham;
            $discount->discount=$request->giamgia;
            $discount->hinh=$sanpham->hinh;
            $discount->Money_discount=$sanpham->giaban-($request->giamgia*$sanpham->giaban/100);
            $discount->save();
            return redirect('admin/sanpham/danhsach')->with('thongbao','Giảm giá thành công sản phẩm '.$request->tensanpham);
        }
        $sanpham=SanPham::find($request->masanpham);
        $giamgia->discount=$request->giamgia;
        $giamgia->hinh=$sanpham->hinh;
        $giamgia->Money_discount=$sanpham->giaban-($request->giamgia*$sanpham->giaban/100);
        $giamgia->save();
        return redirect('admin/sanpham/danhsach')->with('thongbao','Giảm giá thành công sản phẩm '.$request->tensanpham);

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
        $sp=Discount::find($id);
        return view('admin.sanpham.editdiscount',['sanpham'=>$sp]);
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
        $sanpham=SanPham::find($id);
        $sp=Discount::find($id);
        $sp->discount=$request->giamgia;
        $sp->Money_discount=$sanpham->giaban-($request->giamgia*$sanpham->giaban/100);
        $sp->save();
        return redirect('admin/sanpham/discountlist')->with('thongbao','Sửa giảm giá thành công sản phẩm '.$request->tensanpham);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sp=Discount::find($id);
        $sp->delete();
        return redirect('admin/sanpham/discountlist')->with('thongbao','Một sản phẩm giảm giá đã được hủy');
    }
}
