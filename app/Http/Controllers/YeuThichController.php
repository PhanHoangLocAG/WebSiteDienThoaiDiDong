<?php

namespace App\Http\Controllers;

use App\SanPham;
use App\TheLoai;
use App\YeuThich;
use Illuminate\Http\Request;

class YeuThichController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id,$masp)
    {   
        if(YeuThich::isExist($id,$masp)){
            return redirect('frontend/yeuthich/'.$id);
        }
        $yeuthich=new YeuThich();
        $yeuthich->makhachhang=$id;
        $yeuthich->masanpham=$masp;
        $yeuthich->save();
        return redirect('frontend/yeuthich/'.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   $branch=TheLoai::all();
        $yeuthich=YeuThich::getSanPham($id);
        //dd($yeuthich);
        if($yeuthich==null){
            return view('frontend.sanphamyeuthich.wishList',['branch'=>$branch]);
        }else{
            return view('frontend.sanphamyeuthich.wishList',['branch'=>$branch,'yeuthich'=>$yeuthich]);
        }
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
    public function destroy($id,$masp)
    {
        $sanpham=YeuThich::find($id)->where('masanpham','=',$masp);
        $sanpham->delete();
        return redirect('frontend/yeuthich/'.$id);
    }
}
