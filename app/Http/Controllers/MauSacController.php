<?php

namespace App\Http\Controllers;

use App\MauSac;
use Illuminate\Http\Request;

class MauSacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mausac=MauSac::all();
        return view('admin.mausac.danhsach',['mausac'=>$mausac]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.mausac.them');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'mamau'=>'required|unique:mausac',
            'tenmau'=>'required|unique:mausac'
        ]
        ,[
            'mamau.required'=>'Mã màu không được trống',
            'mamau.unique'=>'Mã màu không được trùng',
            'tenmau.required'=>'Tên màu không được trống',
            'tenmau.unique'=>'Tên màu không được trùng'
        ]);
        $mausac=new MauSac();
        $mausac->mamau=$request->mamau;
        $mausac->tenmau=$request->tenmau;
        $mausac->save();
        return redirect('admin/mausac/them')->with('thongbao','Thêm thành công một màu sắc mới');
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
        $mausac=MauSac::find($id);
        return view('admin.mausac.sua',['mausac'=>$mausac]);
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
            'tenmau'=>'required|unique:mausac,tenmau,'.$id.',mamau'
        ]
        ,[
            'tenmau.required'=>'Tên màu không được trống',
            'tenmau.unique'=>'Tên màu không được trùng'
        ]);
        $mausac=MauSac::find($id);
        $mausac->tenmau=$request->tenmau;
        $mausac->save();
        return redirect('admin/mausac/sua/'.$id)->with('thongbao','Sửa thành công một màu sắc');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mausac=MauSac::find($id);
        $mausac->delete();
        return redirect('admin/mausac/danhsach')->with('thongbao','Xóa thành công một màu sắc');
    }
}
