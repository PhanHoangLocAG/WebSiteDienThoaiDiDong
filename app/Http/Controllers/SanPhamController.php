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
            'masanpham.unique'=>'M?? s???n ph???m kh??ng ???????c tr??ng',
            'masanpham.min'=>'M?? s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'masanpham.max'=>'M?? s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'masanpham.required'=>'M?? s???n ph???m kh??ng ???????c ????? tr???ng',
            'tensanpham.min'=>'T??n s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'tensanpham.max'=>'T??n s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'tensanpham.required'=>'T??n s???n ph???m kh??ng ???????c ????? tr???ng',
            'bonho.min'=>'B??? nh??? s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'bonho.max'=>'B??? nh??? s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'bonho.required'=>'B??? nh??? s???n ph???m kh??ng ???????c ????? tr???ng',
            'hedieuhanh.min'=>'H??? ??i???u h??nh s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'hedieuhanh.max'=>'H??? ??i???u h??nh s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'hedieuhanh.required'=>'H??? ??i???u h??nh s???n ph???m kh??ng ???????c ????? tr???ng',
            'manhinh.min'=>'M??n h??nh s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'manhinh.max'=>'M??n h??nh s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'manhinh.required'=>'M??n h??nh s???n ph???m kh??ng ???????c ????? tr???ng',
            'camera.min'=>'Camera s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'camera.max'=>'Camera s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'camera.required'=>'Camera s???n ph???m kh??ng ???????c ????? tr???ng',
            'ketnoi.min'=>'K???t n???i kh??ng d??y s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'ketnoi.max'=>'K???t n???i kh??ng d??y s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'ketnoi.required'=>'K???t n???i kh??ng d??y s???n ph???m kh??ng ???????c ????? tr???ng',
            'trongluong.min'=>'Tr???ng l?????ng s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'trongluong.max'=>'Tr???ng l?????ng s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'trongluong.required'=>'Tr???ng l?????ng s???n ph???m kh??ng ???????c ????? tr???ng',
            'pin.min'=>'Pin s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'pin.max'=>'Pin s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'pin.required'=>'Pin s???n ph???m kh??ng ???????c ????? tr???ng',
            'hinhanh.required'=>'H??nh s???n ph???m kh??ng ???????c ????? tr???ng',
            'mausac.required'=>'M??u s???c s???n ph???m kh??ng ???????c ????? tr???ng',
            'kichthuoc.required'=>'K??ch th?????c s???n ph???m kh??ng ???????c ????? tr???ng',
            'gia.required'=>'Gi?? s???n ph???m kh??ng ???????c b??? tr???ng',
            'soluong.required'=>'S??? l?????ng s???n ph???m kh??ng ???????c b??? tr???ng'
        ]);
        $temp=DB::table('sanpham')->get();
        $kiemtra=$this->KiemTraTrung($temp,$request->tensanpham,$request->kichthuoc,$request->mausac);
        if($kiemtra){
            return redirect('admin/sanpham/them')->with('thongbaoloi','Ki???m tra l???i m??u s???c v?? k??ch th?????c v?? t??n s???n ph???m n?? ???? t???n t???i');
        }
        if($request->soluong<=0)
        {
            return redirect('admin/sanpham/them')->with('thongbaoloi','S??? l?????ng kh??ng ???????c b?? h??n 0');

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
        return redirect('admin/sanpham/them')->with('thongbao','Th??m th??nh c??ng m???t s???n ph???m m???i');

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
            'tensanpham.min'=>'T??n s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'tensanpham.max'=>'T??n s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'tensanpham.required'=>'T??n s???n ph???m kh??ng ???????c ????? tr???ng',
            'bonho.min'=>'B??? nh??? s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'bonho.max'=>'B??? nh??? s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'bonho.required'=>'B??? nh??? s???n ph???m kh??ng ???????c ????? tr???ng',
            'hedieuhanh.min'=>'H??? ??i???u h??nh s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'hedieuhanh.max'=>'H??? ??i???u h??nh s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'hedieuhanh.required'=>'H??? ??i???u h??nh s???n ph???m kh??ng ???????c ????? tr???ng',
            'manhinh.min'=>'M??n h??nh s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'manhinh.max'=>'M??n h??nh s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'manhinh.required'=>'M??n h??nh s???n ph???m kh??ng ???????c ????? tr???ng',
            'camera.min'=>'Camera s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'camera.max'=>'Camera s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'camera.required'=>'Camera s???n ph???m kh??ng ???????c ????? tr???ng',
            'ketnoi.min'=>'K???t n???i kh??ng d??y s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'ketnoi.max'=>'K???t n???i kh??ng d??y s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'ketnoi.required'=>'K???t n???i kh??ng d??y s???n ph???m kh??ng ???????c ????? tr???ng',
            'trongluong.min'=>'Tr???ng l?????ng s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'trongluong.max'=>'Tr???ng l?????ng s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'trongluong.required'=>'Tr???ng l?????ng s???n ph???m kh??ng ???????c ????? tr???ng',
            'pin.min'=>'Pin s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'pin.max'=>'Pin s???n ph???m kh??ng ???????c b?? h??n 5 k?? t??? v?? l???n h??n 50 k?? t???',
            'pin.required'=>'Pin s???n ph???m kh??ng ???????c ????? tr???ng',
            'mausac.required'=>'M??u s???c s???n ph???m kh??ng ???????c ????? tr???ng',
            'kichthuoc.required'=>'K??ch th?????c s???n ph???m kh??ng ???????c ????? tr???ng'
        ]);
        $sanpham=SanPham::find($id);
        $temp=DB::table('sanpham')->where('masanpham','<>',$id)->get();
        $kiemtra=$this->KiemTraTrung($temp,$request->tensanpham,$request->kichthuoc,$request->mausac);
        if($kiemtra){
            return redirect('admin/sanpham/sua/'.$id)->with('thongbao','Ki???m tra l???i m??u s???c v?? k??ch th?????c v?? t??n s???n ph???m n?? ???? t???n t???i');
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
        return redirect('admin/sanpham/sua/'.$id)->with('thongbao','S???a th??nh c??ng m???t s???n ph???m m???i');


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
        return redirect('admin/sanpham/danhsach')->with('thongbao','X??a th??nh c??ng m???t s???n ph???m');
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

    //T??m ki???m theo t??n
    public function search(Request $req){
        if($req->search == null){
            return redirect('frontend/trangchu');
        }else{
            $sanpham = SanPham::getListProductSearch($req->search);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$req->search]);
        }
    }
    //T??m ki???m theo lo???i s???n ph???m
    public function searchType($ten,$maloai){
        //dd($maloai);
            $sanpham = SanPham::getListProductType($ten,$maloai);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }
    //T??m ki???m theo s???n ph???m m???i
    public function searchNewProduct($ten){
        //dd($maloai);
            $sanpham = SanPham::getNewProductName($ten);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }
    //T??m ki???m theo cao ?????n th???p
    public function searchPriceHightToLow($ten){
        //dd($maloai);
            $sanpham = SanPham::getProductHightToLow($ten);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }
    //T??m ki???m s???n ph???m t??? th???p ?????n cao
    public function searchPriceLowToHight($ten){
        //dd($maloai);
            $sanpham = SanPham::getProductLowToHight($ten);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }


    //T??m ki???m theo gi?? b??n
    public function searchPrice($ten,$gia){
        //dd($maloai);
            $sanpham = SanPham::getListProductPrice($ten,$gia);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }

    //T??m khi???m theo s???n ph???m khuy???n m??i
    public function searchDiscount($ten){
        //dd($maloai);
            $sanpham = SanPham::getListProductDiscount($ten);
            //dd($sanpham);
            $branch=TheLoai::all();
            return view('frontend.timkiem.newProduct',['branch'=>$branch,'newProduct'=>$sanpham,'ten'=>$ten]);
    }

}
  