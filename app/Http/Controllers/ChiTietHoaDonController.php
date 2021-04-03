<?php

namespace App\Http\Controllers;

use App\HoaDon;
use App\KhachHang;
use App\TheLoai;
use App\ChiTietHoaDon;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;

use Session;
class ChiTietHoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $branch=TheLoai::all(); 
        $khachhang=KhachHang::find($id);

        $Cart = Session('Cart') ? Session('Cart') : null ;
        if($Cart == null){
            return redirect()->back()->with('thongbao' , 'Chưa có sản phẩm để đặt hàng');
        }
        return view('frontend.giohang.bill',['branch'=>$branch,'khachhang' => $khachhang, 'cart' => $Cart]);
    }

    //list invoice for admin
    public function listInvoice()
    {
        $hoadon = HoaDon::getInvoice();
        //dd($hoadon);
        return view('admin.donhang.hoadon',['hoadon'=>$hoadon]);
    }
    
    public function listInvoiced()
    {
        $hoadon = HoaDon::getInvoiced();
        //dd($hoadon);
        return view('admin.donhang.hoadonthanhtoan',['hoadon'=>$hoadon]);
    }

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
    public function store(Request $request, $id)
    {
        $this->validate($request,[
            'ten' => 'bail|required',
            'diachi' => 'bail|required',
            'email' => 'bail|required',
            'sodienthoai' => 'bail|required',
        ],[
            'ten.required' => 'Tên không được bỏ trống',
            'diachi.required' => 'Địa chỉ không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'sodienthoai.required' => 'Số điện thoại không được bỏ trống'
        ]);
        $Cart = Session('Cart') ? Session('Cart') : null ; 
        
        //dd($request->session()->get('Cart'));
        if($Cart != null){
        $hoadon = new HoaDon();
        $hoadon->makhachhang = $id;
        $hoadon->manhanvien = 'admin';
        $hoadon->tenkhachhang = $request->ten;
        $hoadon->diachi = $request->diachi;
        $hoadon->sodienthoai = $request->sodienthoai;
        $hoadon->email = $request->email;
        $hoadon->thanhtoan = 1; 
        $hoadon->phuongthucgiaohang = $request->giaohang ;
        $hoadon->save();
        
        $hoadon_id =HoaDon::getId($id);
        
        $data = array();
        foreach($Cart->products as $item){
            $temmp = [
                'name' => $item['productInfo']->tensanpham,
                'soluong' => $item['quantity'] ,
                'thanhtien' => $item['price'] 
            ];
            $data[] = $temmp ;
        }
        $mahoadon = $hoadon_id->mahoadon ;
        $ngaylap = $hoadon_id->created_at ;
        //kiem tra loai giao hang
        if($request->giaohang == 1)
            $total = $Cart->totalPrice + 30000;
        else
            $total = $Cart->totalPrice;
        $sentMail = new MailController( $request->email );
        $sentMail->basic_email($mahoadon , $ngaylap , $data, $total , $request->giaohang);
            foreach($Cart->products as $key => $value){
                $key = str_replace('_',' ',$key);
                $chitiethoadon = new ChiTietHoaDon();
                $chitiethoadon->masanpham = $key ;
                $chitiethoadon->mahoadon = $hoadon_id->mahoadon ;
                $chitiethoadon->soluong = $value['quantity'] ;
                $chitiethoadon->dongia = $value['productInfo']->giaban ;
                $chitiethoadon->thanhtien = $value['price'] ;
                $chitiethoadon->save();
            }
            $request->session()->forget('Cart');
        }
        return redirect('frontend/donhang/'.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req, $id)
    {
        $branch =TheLoai::all();
        $hoadon = ChiTietHoaDon::getData($id);
        return view('frontend.giohang.donhang',['branch'=>$branch,'hoadon'=>$hoadon]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Cho admin su dung
    public function edit($id)
    {
        $hoadon = HoaDon::find($id);
        $hoadon->thanhtoan = 0;
        $hoadon->save();
        return  redirect('admin/hoadon/danhsach')->with('thongbao','Cập nhật thành công');
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

    // Xoa don hang trong vong 12 gio
    public function destroy($id)
    {
        $hoadon = HoaDon::find($id);
        //dd($hoadon);
        $a = strtotime($hoadon->created_at.' +12 hours');
        $time = time();
        $mahoadon = $hoadon->makhachhang;
        // Vuot qua 12 gio
        if($a < $time){
            return redirect()->back()->with('thongbaoloi','Đơn hàng bạn không được hủy');
        }else{
            ChiTietHoaDon::where('mahoadon' , '=' , $id)->delete();
            $hoadon->delete();
            return redirect('frontend/donhang/'.$mahoadon)->with('thongbao','Đơn hàng bạn đã được hủy');
        }

    }
}
