<?php

namespace App\Http\Controllers;

use App\BinhLuan;
use App\KichThuoc;
use App\MauSac;
use App\SanPham;
use App\TheLoai;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function KiemTraTrung($list,$name,$size,$color){
        foreach($list as $item){
            if($item->tensanpham==$name && $item->mausac==$color && $item->kichthuoc==$size)
                return true;
        }
        return false;       
    }


    public function index()
    {
        $sanpham=SanPham::all();
        return view('admin.sanpham.danhsach',['sanpham'=>$sanpham]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loaisanpham=TheLoai::all();
        $mausac=MauSac::all();
        $kichthuoc=KichThuoc::all();
        return view('admin.sanpham.them',['loaisanpham'=>$loaisanpham,'mausac'=>$mausac,'kichthuoc'=>$kichthuoc]);
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
            'masanpham'=>'bail|unique:sanpham|min:5|max:50|required',
            'tensanpham'=>'bail|min:5|max:50|required',
            'bonho'=>'bail|min:5|max:50|required',
            'hedieuhanh'=>'bail|min:5|max:50|required',
            'manhinh'=>'bail|min:5|max:50|required',
            'camera'=>'bail|min:5|max:50|required',
            'ketnoi'=>'bail|min:5|max:50|required',
            'trongluong'=>'bail|min:5|max:50|required',
            'pin'=>'bail|min:5|max:50|required',
            'hinhanh'=>'bail|required',
            'kichthuoc'=>'bail|required',
            'mausac'=>'bail|required',
            'gia'=>'bail|required',
            'soluong'=>'bail|required'
        ],
        [
            'masanpham.unique'=>'Mã sản phẩm không được trùng',
            'masanpham.min'=>'Mã sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'masanpham.max'=>'Mã sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'masanpham.required'=>'Mã sản phẩm không được để trống',
            'tensanpham.min'=>'Tên sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'tensanpham.max'=>'Tên sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'tensanpham.required'=>'Tên sản phẩm không được để trống',
            'bonho.min'=>'Bộ nhớ sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'bonho.max'=>'Bộ nhớ sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'bonho.required'=>'Bộ nhớ sản phẩm không được để trống',
            'hedieuhanh.min'=>'Hệ điều hành sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'hedieuhanh.max'=>'Hệ điều hành sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'hedieuhanh.required'=>'Hệ điều hành sản phẩm không được để trống',
            'manhinh.min'=>'Màn hình sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'manhinh.max'=>'Màn hình sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'manhinh.required'=>'Màn hình sản phẩm không được để trống',
            'camera.min'=>'Camera sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'camera.max'=>'Camera sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'camera.required'=>'Camera sản phẩm không được để trống',
            'ketnoi.min'=>'Kết nối không dây sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'ketnoi.max'=>'Kết nối không dây sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'ketnoi.required'=>'Kết nối không dây sản phẩm không được để trống',
            'trongluong.min'=>'Trọng lượng sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'trongluong.max'=>'Trọng lượng sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'trongluong.required'=>'Trọng lượng sản phẩm không được để trống',
            'pin.min'=>'Pin sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'pin.max'=>'Pin sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'pin.required'=>'Pin sản phẩm không được để trống',
            'hinhanh.required'=>'Hình sản phẩm không được để trống',
            'mausac.required'=>'Màu sắc sản phẩm không được để trống',
            'kichthuoc.required'=>'Kích thước sản phẩm không được để trống',
            'gia.required'=>'Giá sản phẩm không được bỏ trống',
            'soluong.required'=>'Số lượng sản phẩm không được bỏ trống'
        ]);
        $temp=DB::table('sanpham')->get();
        $kiemtra=$this->KiemTraTrung($temp,$request->tensanpham,$request->kichthuoc,$request->mausac);
        if($kiemtra){
            return redirect('admin/sanpham/them')->with('thongbaoloi','Kiểm tra lại màu sắc và kích thước và tên sản phẩm nó đã tồn tại');
        }
        if($request->soluong<=0)
        {
            return redirect('admin/sanpham/them')->with('thongbaoloi','Số lượng không được bé hơn 0');

        }
        $sanpham=new SanPham();
        $sanpham->masanpham=$request->masanpham;
        $sanpham->tensanpham=$request->tensanpham;
        $sanpham->loaisanpham=$request->loaisanpham;
        $sanpham->bonho=$request->bonho;
        $sanpham->hedieuhanh=$request->hedieuhanh;
        $sanpham->manhinh=$request->manhinh;
        $sanpham->camera=$request->camera;
        $sanpham->ketnoi=$request->ketnoi;
        $sanpham->trongluong=$request->trongluong;
        $sanpham->pin=$request->pin;
        $sanpham->giaban=$request->gia;
        $sanpham->mausac=$request->mausac;
        $sanpham->kichthuoc=$request->kichthuoc;
        $sanpham->soluong=$request->soluong;
        if($request->hasFile('hinhanh')){
            $hinh="";
            foreach($request->file('hinhanh') as $file)
            {
                $name=$file->getClientOriginalName();
                $file->move('upload/img',time()."_".$name);
                if($hinh==""){
                    $hinh=time()."_".$name;
                }else{
                    $hinh.=";".time()."_".$name;
                }
                
            }
            $sanpham->hinh=$hinh;
            
        }else{
            $sanpham->hinh="";
        }
        $sanpham->save();
        return redirect('admin/sanpham/them')->with('thongbao','Thêm thành công một sản phẩm mới');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    
    public function show($id)
    {
        $sanpham=SanPham::getDetailProduct($id);
        $mausac=SanPham::getMauSac($sanpham[0]->tensanpham);
        $branch=TheLoai::all();
        $binhluan = BinhLuan::getBinhLuan($id);
       // dd($binhluan);
        return view('frontend.sanpham.detailProduct',['sanpham'=>$sanpham,'mausac'=>$mausac,'branch'=>$branch,'binhluan'=>$binhluan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loaisanpham=TheLoai::all();
        $sanpham=SanPham::find($id);
        $mausac=MauSac::all();
        $kichthuoc=KichThuoc::all();
        //dd($loaisanpham,$sanpham);
        return view('admin.sanpham.sua',['sanpham'=>$sanpham,'loaisanpham'=>$loaisanpham,'mausac'=>$mausac,'kichthuoc'=>$kichthuoc]);
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
            'tensanpham'=>'bail|min:5|max:50|required|',
            'bonho'=>'bail|min:5|max:50|required',
            'hedieuhanh'=>'bail|min:5|max:50|required',
            'manhinh'=>'bail|min:5|max:50|required',
            'camera'=>'bail|min:5|max:50|required',
            'ketnoi'=>'bail|min:5|max:50|required',
            'trongluong'=>'bail|min:5|max:50|required',
            'pin'=>'bail|min:5|max:50|required',
            'kichthuoc'=>'bail|required',
            'mausac'=>'bail|required'
        ],
        [
            'tensanpham.min'=>'Tên sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'tensanpham.max'=>'Tên sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'tensanpham.required'=>'Tên sản phẩm không được để trống',
            'bonho.min'=>'Bộ nhớ sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'bonho.max'=>'Bộ nhớ sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'bonho.required'=>'Bộ nhớ sản phẩm không được để trống',
            'hedieuhanh.min'=>'Hệ điều hành sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'hedieuhanh.max'=>'Hệ điều hành sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'hedieuhanh.required'=>'Hệ điều hành sản phẩm không được để trống',
            'manhinh.min'=>'Màn hình sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'manhinh.max'=>'Màn hình sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'manhinh.required'=>'Màn hình sản phẩm không được để trống',
            'camera.min'=>'Camera sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'camera.max'=>'Camera sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'camera.required'=>'Camera sản phẩm không được để trống',
            'ketnoi.min'=>'Kết nối không dây sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'ketnoi.max'=>'Kết nối không dây sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'ketnoi.required'=>'Kết nối không dây sản phẩm không được để trống',
            'trongluong.min'=>'Trọng lượng sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'trongluong.max'=>'Trọng lượng sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'trongluong.required'=>'Trọng lượng sản phẩm không được để trống',
            'pin.min'=>'Pin sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'pin.max'=>'Pin sản phẩm không được bé hơn 5 kí tự và lớn hơn 50 kí tự',
            'pin.required'=>'Pin sản phẩm không được để trống',
            'mausac.required'=>'Màu sắc sản phẩm không được để trống',
            'kichthuoc.required'=>'Kích thước sản phẩm không được để trống'
        ]);
        $sanpham=SanPham::find($id);
        $temp=DB::table('sanpham')->where('masanpham','<>',$id)->get();
        $kiemtra=$this->KiemTraTrung($temp,$request->tensanpham,$request->kichthuoc,$request->mausac);
        if($kiemtra){
            return redirect('admin/sanpham/sua/'.$id)->with('thongbao','Kiểm tra lại màu sắc và kích thước và tên sản phẩm nó đã tồn tại');
        }
        $sanpham->tensanpham=$request->tensanpham;
        $sanpham->loaisanpham=$request->loaisanpham;
        $sanpham->bonho=$request->bonho;
        $sanpham->hedieuhanh=$request->hedieuhanh;
        $sanpham->manhinh=$request->manhinh;
        $sanpham->camera=$request->camera;
        $sanpham->ketnoi=$request->ketnoi;
        $sanpham->trongluong=$request->trongluong;
        $sanpham->pin=$request->pin;
        $sanpham->mausac=$request->mausac;
        $sanpham->kichthuoc=$request->kichthuoc;
        if($request->hasFile('hinhanh')){
            $hinh="";
            foreach($request->file('hinhanh') as $file)
            {
                $name=$file->getClientOriginalName();
                $file->move('upload/img',time()."_".$name);
                if($hinh==""){
                    $hinh=time()."_".$name;
                }else{
                    $hinh.=";".time()."_".$name;
                }
                
            }
            $sanpham->hinh=$sanpham->hinh.";".$hinh;
            
        }
        $sanpham->save();
        return redirect('admin/sanpham/sua/'.$id)->with('thongbao','Sửa thành công một sản phẩm mới');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sanpham=SanPham::find($id);
        //delete img
        $hinh = explode(";",$sanpham->hinh);
        //dd($hinh);
        foreach($hinh as $item){
           // dd($item);
            File::delete(public_path("upload/img/$item"));
        }
        $sanpham->delete();
        return redirect('admin/sanpham/danhsach')->with('thongbao','Xóa thành công một sản phẩm');
    }

    

    //Show product for customer
    public function ShowProduct()
    {
        $tempSanPham =SanPham::getdiscount();
        $tempSanPham=$this->deleteExist($tempSanPham);
        $branch=TheLoai::all();
        //dd($tempSanPham);
        $new=SanPham::getNewProduct();
        $new=$this->deleteExist($new);
        return view('frontend.sanpham.product',['sanpham'=>$tempSanPham,'newProduct'=>$new,'branch'=>$branch]);
    }

    //xoa nhung san pham 
    public function deleteExist($tempSanPham){
        for($i=0;$i<count($tempSanPham);$i++){
            for($j=$i+1;$j<count($tempSanPham);$j++){
                if($tempSanPham[$i]==null){
                    break;
                }
                if($tempSanPham[$j]==null){
                    continue;
                }
                if($tempSanPham[$i]->tensanpham==$tempSanPham[$j]->tensanpham){
                    if($tempSanPham[$i]->discount==null){
                        $tempSanPham[$i]=$tempSanPham[$j];
                        $tempSanPham[$j]=null;
                    }else if($tempSanPham[$i]->discount!=null){
                        $tempSanPham[$j]=null;
                    }
                }
            }
        }
        foreach($tempSanPham as $key=>$value){
            if($tempSanPham[$key]==null){
                unset($tempSanPham[$key]);
            }
        }

        return $tempSanPham;
    }

    //Tìm kiếm theo tên
    public function search(Request $req){
        if($req->search == null){
            return redirect('frontend/trangchu');
        }else{
            $sanpham = SanPham::getListProductSearch($req->search);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$req->search]);
        }
    }
    //Tìm kiếm theo loại sản phẩm
    public function searchType($ten,$maloai){
        //dd($maloai);
            $sanpham = SanPham::getListProductType($ten,$maloai);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }
    //Tìm kiếm theo sản phẩm mới
    public function searchNewProduct($ten){
        //dd($maloai);
            $sanpham = SanPham::getNewProductName($ten);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }
    //Tìm kiếm theo cao đến thấp
    public function searchPriceHightToLow($ten){
        //dd($maloai);
            $sanpham = SanPham::getProductHightToLow($ten);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }
    //Tìm kiếm sản phẩm từ thấp đến cao
    public function searchPriceLowToHight($ten){
        //dd($maloai);
            $sanpham = SanPham::getProductLowToHight($ten);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }


    //Tìm kiếm theo giá bán
    public function searchPrice($ten,$gia){
        //dd($maloai);
            $sanpham = SanPham::getListProductPrice($ten,$gia);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }

    //Tìm khiếm theo sản phẩm khuyến mãi
    public function searchDiscount($ten){
        //dd($maloai);
            $sanpham = SanPham::getListProductDiscount($ten);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }

}
  