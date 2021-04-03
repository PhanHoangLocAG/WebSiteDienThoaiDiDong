<?php

namespace App\Http\Controllers;

use App\Luong;
use Illuminate\Http\Request;

class LuongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $luong=Luong::all(); 
        return view('admin.luong.danhsach',['luong'=>$luong]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.luong.them');
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
            'mamucluong'=>'required|unique:luong',
            'sotien'=>'required|unique:luong'
        ]
        ,[
            'mamucluong.required'=>'Mức lương không được để trống',
            'mamucluong.unique'=>'Mức lương không được trùng',
            'sotien.required'=>'Số tiền không được để trống',
            'sotien.unique'=>'Số tiền không được trùng'
        ]);
        $luong=new Luong();
        $luong->mamucluong=$request->mamucluong;
        $luong->sotien=$request->sotien;
        $luong->save();
        return redirect('admin/luong/them')->with('thongbao','Thêm mức lương mới thành công');
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
        $luong=Luong::find($id);
        return view('admin.luong.sua',['luong'=>$luong]);
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
            'sotien'=>'required|unique:luong'
        ]
        ,[
            'sotien.required'=>'Số tiền không được để trống',
            'sotien.unique'=>'Số tiền không được trùng'
        ]);
        $luong=Luong::find($id);
        $luong->sotien=$request->sotien;
        $luong->save();
        return redirect('admin/luong/sua/'.$id)->with('thongbao','Sửa mức lương thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $luong=Luong::find($id);
        $luong->delete();
        return redirect('admin/luong/danhsach')->with('thongbao','Xóa thành công một mức lương');
    }
}
