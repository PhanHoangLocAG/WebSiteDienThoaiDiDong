<?php

namespace App\Http\Controllers;

use App\ChucVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chucvu=ChucVu::all();
        return view('admin.chucvu.danhsach',['chucvu'=>$chucvu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.chucvu.them');
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
            'machucvu'=>'unique:ChucVu|min:5|max:20|required',
            'tenchucvu'=>'unique:ChucVu|min:5|max:50|required'
        ],
        [
            'machucvu.unique'=>'Mã chức vụ không được trùng',
            'machucvu.min'=>'Mã chức vụ không được ít hơn 5 kí tự và lớn hơn 20 kí tự',
            'machucvu.max'=>'Mã chức vụ không được ít hơn 5 kí tự và lớn hơn 20 kí tự',
            'machucvu.required'=>'Mã chức vụ không được bỏ trống',
            'tenchucvu.unique'=>'Tên chức vụ không được trùng',
            'tenchucvu.min'=>'Tên chức vụ không được ít hơn 5 kí tự và lớn hơn 50 kí tự',
            'tenchucvu.max'=>'Tên chức vụ không được ít hơn 5 kí tự và lớn hơn 50 kí tự',
            'tenchucvu.required'=>'Tên chức vụ không được bỏ trống'
        ]);
        $chucvu=new ChucVu();
        $chucvu->machucvu=$request->machucvu;
        $chucvu->tenchucvu=$request->tenchucvu;
        $chucvu->save();
        return redirect('admin/chucvu/them',)->with('thongbao','Thêm thành công một chức vụ mới');
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
        $chucvu=ChucVu::find($id);
        return view('admin.chucvu.sua',['chucvu'=>$chucvu]);
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
            'tenchucvu'=>'unique:ChucVu|min:5|max:50|required'
        ],
        [
            'tenchucvu.unique'=>'Tên chức vụ không được trùng',
            'tenchucvu.min'=>'Tên chức vụ không được ít hơn 5 kí tự và lớn hơn 50 kí tự',
            'tenchucvu.max'=>'Tên chức vụ không được ít hơn 5 kí tự và lớn hơn 50 kí tự',
            'tenchucvu.required'=>'Tên chức vụ không được bỏ trống'
        ]);
        $chucvu=ChucVu::find($id);
        $chucvu->tenchucvu=$request->tenchucvu;
        $chucvu->save();
        return redirect('admin/chucvu/sua/'.$id,)->with('thongbao','Sửa thành công một chức vụ ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chucvu=ChucVu::find($id);
        $chucvu->delete();
        return redirect('admin/chucvu/danhsach')->with('thongbao','Xóa thành công một chức vụ');
    }
}
