<?php

namespace App\Http\Controllers;

use App\TheLoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TheLoaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theloai=TheLoai::all();
        return view('admin.loaisanpham.danhsach',['theloai'=>$theloai]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.loaisanpham.them');
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
                'maloai'=>'required|min:5|max:50|unique:theloai',
                'tenloai'=>'required|min:3|max:50|unique:theloai',
                'nhasanxuat'=>'required|min:5|max:50',
                'donvilaprap'=>'required|min:5|max:50',
                'logo'=>'required'
            ],
            [
                'maloai.required'=>'Mã loại không được để trống',
                'maloai.min'=>'Mã loại không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'maloai.max'=>'Mã loại không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'maloai.unique'=>'Mã loại đã tồn tại',
                'tenloai.required'=>'Tên loại không được để trống',
                'tenloai.min'=>'Tên không bé hơn 3 kí tự và lớn hơn 50 kí tự',
                'tenloai.max'=>'Tên không bé hơn 3 kí tự và lớn hơn 50 kí tự',
                'tenloai.unique'=>'Tên loại sản phẩm đã tồn tại',
                'nhasanxuat.min'=>'Tên nhà sản xuất không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'nhasanxuat.max'=>'Tên nhà sản xuất không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'nhasanxuat.required'=>'Tên nhà sản xuất không được để trống',
                'donvilaprap.min'=>'Tên đơn vị lắp ráp không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'donvilaprap.max'=>'Tên đơn vị lắp ráp không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'donvilaprap.required'=>'Tên đơn vị lắp ráp không được để trống',
                'logo.required'=>'Logo không được để trống'
            ]
        );
        $theloai= new TheLoai();
        $theloai->maloai=$request->maloai;
        $theloai->tenloai=$request->tenloai;
        $theloai->nhasanxuat=$request->nhasanxuat;
        $theloai->donvilaprap=$request->donvilaprap;
        if($request->hasFile('logo')){
                $file=$request->file('logo');
                $name=$file->getClientOriginalName();
                $hinh=time()."_".$name;
                $file->move('upload/img',$hinh);
                $theloai->logo=$hinh;
            
        }else{
            $theloai->logo="";
        }
        $theloai->save();
        return redirect('admin/theloai/them')->with('thongbao','Thêm thành công một loại sản phẩm mới');
    }

    
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
        $theloai=TheLoai::find($id);
        return view('admin.loaisanpham.sua',['theloai'=>$theloai]);
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
        
        $theloai=TheLoai::find($id);
        $this->validate($request,
            [
                'tenloai'=>'required|min:3|max:50|unique:theloai,tenloai,'.$id.',maloai',
                'nhasanxuat'=>'required|min:5|max:50',
                'donvilaprap'=>'required|min:5|max:50'
            ],
            [
                'tenloai.required'=>'Tên loại không được để trống',
                'tenloai.min'=>'Tên không bé hơn 3 kí tự và lớn hơn 50 kí tự',
                'tenloai.max'=>'Tên không bé hơn 3 kí tự và lớn hơn 50 kí tự',
                'tenloai.unique'=>'Tên loại sản phẩm đã tồn tại',
                'nhasanxuat.min'=>'Tên nhà sản xuất không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'nhasanxuat.max'=>'Tên nhà sản xuất không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'nhasanxuat.required'=>'Tên nhà sản xuất không được để trống',
                'donvilaprap.min'=>'Tên đơn vị lắp ráp không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'donvilaprap.max'=>'Tên đơn vị lắp ráp không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'donvilaprap.required'=>'Tên đơn vị lắp ráp không được để trống'
            ]
        );
        
        $theloai->tenloai= $request->tenloai;
        $theloai->nhasanxuat= $request->nhasanxuat;
        $theloai->donvilaprap= $request->donvilaprap;
        if($request->hasFile('logo')){
            $file=$request->file('logo');
            $name=$file->getClientOriginalName();
            $hinh=time()."_".$name;
            $file->move('upload/img',$hinh);
            $theloai->logo=$hinh;
        
        }
        $theloai->save();
        return redirect("admin/theloai/sua/$id")->with('thongbao','Sửa thành công loại sản phẩm '.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $theloai=TheLoai::find($id);
        $theloai->delete();
        return redirect('admin/theloai/danhsach')->with('thongbao','Xóa thành công một loại sản phẩm');
    }
}
