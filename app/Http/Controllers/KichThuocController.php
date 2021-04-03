<?php

namespace App\Http\Controllers;

use App\KichThuoc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class KichThuocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kichthuoc=KichThuoc::all();
        return view('admin.kichthuoc.danhsach',['kichthuoc'=>$kichthuoc]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kichthuoc.them');
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
            'makichthuoc'=>'required|unique:kichthuoc',
            'kichthuoc'=>'required|unique:kichthuoc'
        ],
        [
            'makichthuoc.required'=>'Loại kích thước không được trống',
            'makichthuoc.unique'=>'Loại kích thước không được trùng',
            'kichthuoc.required'=>'Kích thước không được bỏ trống',
            'kichthuoc.unique'=>'Kích thước không được trùng'
        ]);
        $kichthuoc=new KichThuoc();
        $kichthuoc->makichthuoc=$request->makichthuoc;
        $kichthuoc->kichthuoc=$request->kichthuoc;
        $kichthuoc->save();
        return redirect('admin/kichthuoc/them')->with('thongbao','Thêm thành công một kích thước mới');
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
        $kichthuoc=KichThuoc::find($id);
        return view('admin.kichthuoc.sua',['kichthuoc'=>$kichthuoc]);
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
            'kichthuoc'=>'required|unique:kichthuoc,kichthuoc,'.$id.',makichthuoc'
        ],
        [
            'kichthuoc.required'=>'Kích thước không được bỏ trống',
            'kichthuoc.unique'=>'Kích thước không được trùng'
        ]);
        $kichthuoc=KichThuoc::find($id);
        $kichthuoc->kichthuoc=$request->kichthuoc;
        $kichthuoc->save();
        return redirect('admin/kichthuoc/sua/'.$id)->with('thongbao','Sửa thành công kích thước ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kichthuoc=KichThuoc::find($id);
        $kichthuoc->delete();
        return redirect('admin/kichthuoc/danhsach')->with('thongbao','Xóa thành công một kích cỡ');
    }
}
