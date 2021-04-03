<?php

namespace App\Http\Controllers;

use App\ChucVu;
use App\Luong;
use App\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nhanvien = DB::table('nhanvien')->join('chucvu', 'chucvu', '=', 'machucvu')->get();
        return view('admin.nhanvien.danhsach', ['nhanvien' => $nhanvien]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $luong = Luong::all();
        $chucvu = ChucVu::all();
        return view('admin.nhanvien.them', ['luong' => $luong, 'chucvu' => $chucvu]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate(
            $request,
            [
                'manhanvien'    => 'bail|required|min:5|max:50|unique:nhanvien',
                'tennhanvien'   => 'bail|required|min:5|max:50',
                'diachi'        => 'bail|required|min:5|max:100',
                'sodienthoai'   => 'bail|required|min:10|max:12|unique:nhanvien',
                'email'         => 'bail|required|unique:nhanvien',
                'ngaysinh'      => 'bail|required',
                'password'      => 'required|min:6|max:20',
                'hinhanh'       => 'bail|required'
            ],
            [
                'manhanvien.required'   => 'Mã nhân viên không được để trống',
                'manhanvien.min'        => 'Mã nhân viên không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'manhanvien.max'        => 'Mã nhân viên không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'manhanvien.unique'     => 'Mã nhân viên không được trùng',
                'tennhanvien.required'  => 'Tên nhân viên không được để trống',
                'tennhanvien.min'       => 'Tên nhân viên không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'tennhanvien.max'       => 'Tên nhân viên không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'diachi.required'       => 'Địa chỉ không được để trống',
                'diachi.min'            => 'Địa chỉ không được bé hơn 5 kí tự và lớn hơn 100 kí tự',
                'diachi.max'            => 'Địa chỉ không được bé hơn 5 kí tự và lớn hơn 100 kí tự',
                'sodienthoai.required'  => 'Số điện thoại không được để trống',
                'sodienthoai.min'       => 'Số điện thoại không bé hơn 10 kí tự và lớn hơn 12 kí tự',
                'sodienthoai.max'       => 'Số điện thoại không bé hơn 10 kí tự và lớn hơn 12 kí tự',
                'sodienthoai.unique'    => 'Số điện thoại không được trùng',
                'email.required'        => 'Email không được để trống',
                'email.unique'          => 'Email không được trùng',
                'ngaysinh.required'     => 'Ngày sinh không được để trống',
                'username.required'     => 'Username không được để trống',
                'username.min'          => 'Username không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'username.max'          => 'Username không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'username.unique'       => 'Username không được trùng',
                'password.required'     => 'Password không được để trống',
                'password.min'          => 'Password không được bé hơn 10 kí tự và lớn hơn 20 kí tự',
                'password.max'          => 'Password không được bé hơn 10 kí tự và lớn hơn 20 kí tự',
                'hinhanh.required'      => 'Hình ảnh không được bỏ trống'
            ]
        );
        if ($this->KiemTraTuoi($request->ngaysinh, $request->ngayvaolam)) {

            return redirect('admin/nhanvien/them')->with('thongbaoloi', 'Nhân viên phải đủ 18 tuổi trở lên ');
        }
        if ($request->passwordconfirm != "") {
            if ($request->password != $request->passwordconfirm) {
                return redirect('admin/nhanvien/them')->with('thongbaoloi', 'Mật khẩu xác nhận phải trùng với mật khẩu ');
            }
        } else {
            return redirect('admin/nhanvien/them')->with('thongbaoloi', 'Mật khẩu xác nhận phải không được bỏ trống');
        }

        $nhanvien = new NhanVien();
        $nhanvien->manhanvien   = $request->manhanvien;
        $nhanvien->tennhanvien  = $request->tennhanvien;
        $nhanvien->gioitinh     = $request->gioitinh;
        $nhanvien->diachi       = $request->diachi;
        $nhanvien->ngaysinh     = $request->ngaysinh;
        $nhanvien->sodienthoai  = $request->sodienthoai;
        $nhanvien->email        = $request->email;
        $nhanvien->chucvu       = $request->chucvu;
        $nhanvien->ngayvaolam   = $request->ngayvaolam;
        $nhanvien->maluong      = $request->maluong;
        $nhanvien->password     = md5($request->password);
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $name = $file->getClientOriginalName();
            $hinh = time() . "_" . $name;
            $file->move("upload/img", $hinh);
            $nhanvien->hinhanh = $hinh;
        } else {
            $nhanvien->hinhanh = "";
        }
        $nhanvien->save();
        return redirect('admin/nhanvien/them')->with('thongbao', 'Thêm thành công một nhân viên mới');
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
        $nhanvien = DB::table('chucvu')->join('nhanvien', 'machucvu', '=', 'chucvu')
            ->join('luong', 'maluong', 'mamucluong')
            ->where('manhanvien', '=', $id)->get();
        $luong  = Luong::all();
        $chucvu = ChucVu::all();
        return view('admin.nhanvien.sua', ['nhanvien' => $nhanvien, 'chucvu' => $chucvu, 'luong' => $luong]);
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
        $this->validate(
            $request,
            [
                'tennhanvien'   => 'bail|required|min:5|max:50',
                'diachi'        => 'bail|required|min:5|max:100',
                'sodienthoai'   => 'bail|required|min:10|max:12|unique:nhanvien,sodienthoai,' . $id . ',manhanvien',
                'email'         => 'bail|required|unique:nhanvien,email,' . $id . ',manhanvien',
                'ngaysinh'      => 'bail|required',
                'password'      => 'bail|required|min:6|max:20',
            ],
            [
                'tennhanvien.required'  => 'Tên nhân viên không được để trống',
                'tennhanvien.min'       => 'Tên nhân viên không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'tennhanvien.max'       => 'Tên nhân viên không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'diachi.required'       => 'Địa chỉ không được để trống',
                'diachi.min'            => 'Địa chỉ không được bé hơn 5 kí tự và lớn hơn 100 kí tự',
                'diachi.max'            => 'Địa chỉ không được bé hơn 5 kí tự và lớn hơn 100 kí tự',
                'sodienthoai.required'  => 'Số điện thoại không được để trống',
                'sodienthoai.min'       => 'Số điện thoại không bé hơn 10 kí tự và lớn hơn 12 kí tự',
                'sodienthoai.max'       => 'Số điện thoại không bé hơn 10 kí tự và lớn hơn 12 kí tự',
                'sodienthoai.unique'    => 'Số điện thoại không được trùng',
                'email.unique'          => 'Email không được để trống',
                'email.unique'          => 'Email không được trùng',
                'ngaysinh.required'     => 'Ngày sinh không được để trống',
                'username.required'     => 'Username không được để trống',
                'username.min'          => 'Username không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'username.max'          => 'Username không bé hơn 5 kí tự và lớn hơn 50 kí tự',
                'password.required'     => 'Password không được để trống',
                'password.min'          => 'Password không được bé hơn 10 kí tự ',
                'password.max'          => 'Password không được lớn hơn 20 kí tự',

            ]
        );
        $nv = DB::table('nhanvien')->where('manhanvien', '<>', $id)->get();
        $nhanvien = NhanVien::find($id);
        $nhanvien->tennhanvien  = $request->tennhanvien;
        $nhanvien->gioitinh     = $request->gioitinh;
        $nhanvien->diachi       = $request->diachi;
        $nhanvien->ngaysinh     = $request->ngaysinh;
        $nhanvien->chucvu       = $request->chucvu;
        $nhanvien->ngayvaolam   = $request->ngayvaolam;
        $nhanvien->maluong      = $request->maluong;
        $nhanvien->password     = $request->password;
        $nhanvien->email        = $request->email;
        $nhanvien->sodienthoai = $request->sodienthoai;
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $name = $file->getClientOriginalName();
            $hinh = time() . "_" . $name;
            $file->move("upload/img", $hinh);
            $nhanvien->hinhanh = $hinh;
        }
        $nhanvien->save();
        return redirect('admin/nhanvien/sua/' . $id)->with('thongbao', 'Sửa thông tin nhân viên thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nhanvien = NhanVien::find($id);
        $nhanvien->delete();
        return redirect('admin/nhanvien/danhsach')->with('thongbao', 'Xóa thành công một nhân viên');
    }

    public function KiemTra($arr, $sdt, $email)
    {
        foreach ($arr as $t) {
            if ($t->sodienthoai == $sdt || $t->email == $email)
                return false;
        }
        return true;
    }

    public function KiemTraTuoi($ngaysinh, $ngayvaolam)
    {
        $ngaydutuoi = strtotime('+18 year', strtotime($ngaysinh));
        $ngayvaolam = strtotime($ngayvaolam);
        return $ngayvaolam >= $ngaydutuoi ? false : true;
    }
}
