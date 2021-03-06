@extends('frontend.layouts.index')

@section('content')
<div class="sp-area">
    <div class="container">
        <div class="sp-nav">
            <div class="row">
                <div class="col-lg-4">
                    <div class="sp-img_area">
                        <div class="sp-img_slider slick-img-slider kenne-element-carousel" data-slick-options='{
                        "slidesToShow": 1,
                        "arrows": false,
                        "fade": true,
                        "draggable": false,
                        "swipe": false,
                        "asNavFor": ".sp-img_slider-nav"
                        }'>
                            <?php
                                $arr=explode(';',$sanpham[0]->hinh);
                            ?>
                            @foreach($arr as $item)
                            <div class="single-slide red zoom">
                                <img src="upload/img/{{$item}}" alt="Kenne's Product Thumnail">
                            </div>
                            @endforeach
                        </div>
                        <div class="sp-img_slider-nav slick-slider-nav kenne-element-carousel arrow-style-2 arrow-style-3" data-slick-options='{
                        "slidesToShow": 3,
                        "asNavFor": ".sp-img_slider",
                        "focusOnSelect": true,
                        "arrows" : true,
                        "spaceBetween": 30
                        }' data-slick-responsive='[
                                {"breakpoint":1501, "settings": {"slidesToShow": 3}},
                                {"breakpoint":1200, "settings": {"slidesToShow": 2}},
                                {"breakpoint":992, "settings": {"slidesToShow": 4}},
                                {"breakpoint":768, "settings": {"slidesToShow": 3}},
                                {"breakpoint":575, "settings": {"slidesToShow": 2}}
                            ]'>
                            @foreach($arr as $item)
                            <div class="single-slide red">
                                <img src="upload/img/{{$item}}" alt="Kenne's Product Thumnail">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="sp-content">
                        <div class="sp-heading">
                            <h5><a href="#">{{$sanpham[0]->tensanpham}}</a></h5>
                        </div>
                        <span class="reference">????nh gi??</span>
                        <div class="rating-box">
                            <ul>
                                <li><i class="ion-android-star"></i></li>
                                <li><i class="ion-android-star"></i></li>
                                <li><i class="ion-android-star"></i></li>
                                <li class="silver-color"><i class="ion-android-star"></i></li>
                                <li class="silver-color"><i class="ion-android-star"></i></li>
                            </ul>
                        </div>
                        <div class="sp-essential_stuff">
                            <ul>
                                <li>Th????ng hi???u: <a href="javascript:void(0)">{{$sanpham[0]->loaisanpham}}</a></li>
                                <li>M?? s???n ph???m: <a href="javascript:void(0)">{{$sanpham[0]->masanpham}}</a></li>
                                <li>Tr???ng th??i: <a href="javascript:void(0)">
                                        @if($sanpham[0]->soluong>0)
                                        {{"C??n h??ng"}}
                                        @else
                                        {{"H???t h??ng"}}
                                        @endif
                                </a></li>
                                <li>Gi?? : <a href="javascript:void(0)">
                                    <span style="color:blue;font-weight: bold;font-size: larger;">
                                            @if(is_null($sanpham[0]->Money_discount))
                                                {{number_format($sanpham[0]->giaban,0,"",".")."VND"}}
                                            @else
                                                {{number_format($sanpham[0]->Money_discount,0,"",".")."VND"}}
                                            @endif
                                    </span>
                                    @if(!is_null($sanpham[0]->Money_discount))
                                    <span style="text-decoration: line-through;color:red;">
                                            
                                            {{number_format($sanpham[0]->giaban,0,"",".")."VND"}}
                                    </span>
                                    @endif
                                </a></li>
                                <li>M??u s???n ph???m :   <a href="javascript:void(0)" style="border:1px solid black;background-color:<?php 
                                        switch($sanpham[0]->mausac){
                                                case "R":
                                                    echo "red";
                                                break;
                                                case "G":
                                                    echo "grey";
                                                break;
                                                case "B":
                                                    echo "black";
                                                break;
                                                case "W":
                                                    echo "white";
                                                break;
                                        }
                                    ?>; padding-left:17px;" class="single-color" data-swatch-color="black"></a></li>
                            </ul>
                        </div>
                        <div class="product-size_box" >
                            <span>K??ch th?????c</span>
                            <select class="myniceselect nice-select">
                                <option value="1">{{$sanpham[0]->kichthuoc}}</option>
                            </select>
                        </div>
                        <div class="color-list_area">
                            <span class="sub-title">M??u s???c</span>
                            <div >
                                
                                @foreach($mausac as $item)
                                
                                <a  href="frontend/detailProduct/{{$item->masanpham}}" style="background-color:<?php 
                                        switch($item->mausac){
                                                case "R":
                                                    echo "red";
                                                break;
                                                case "G":
                                                    echo "grey";
                                                break;
                                                case "B":
                                                    echo "black";
                                                break;
                                                case "W":
                                                    echo "white";
                                                break;
                                        }
                                    ?>;width:20px;height:20px;border:1px solid black;margin-right:5px;padding-left: 17px;"  >
                                </a>
                                
                                @endforeach
                                
                            </div>
                        </div>
                        <!-- <div class="quantity">
                            <label>????nh gi?? s???n ph???m</label>
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" value="1" type="text">
                                <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                            </div>
                        </div> -->
                        <div class="qty-btn_area">
                            <ul>
                                <li><a class="qty-cart_btn"
                                @if(isset($_COOKIE['cmnd']))
                                    href="frontend/add/{{$sanpham[0]->masanpham}}"
                                @else
                                    href="frontend/dangnhap"
                                @endif
                                    >Th??m v??o gi??? h??ng</a></li>
                                <!-- B??nh lu???n s???n ph???m -->
                                <li>
                                    @if(isset($_COOKIE['cmnd']))
                                        <a class="qty-cart_btn" data-toggle="modal" data-target="#myModal1" >B??nh lu???n</a>
                                    @else
                                        <a class="qty-cart_btn" href="frontend/dangnhap" >B??nh lu???n</a>
                                    @endif
                                   
                                </li>
                                <!-- End b??nh lu???n -->
                                <li><a class="qty-wishlist_btn"
                                    @if(isset($_COOKIE['cmnd']))
                                        href="frontend/themyeuthich/{{Cookie::get('cmnd')}}/{{$sanpham[0]->masanpham}}"
                                    @else
                                        href="frontend/dangnhap"
                                    @endif                                        
                                data-toggle="tooltip" title="Add To Wishlist"><i class="ion-android-favorite-outline"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(session('thongbao'))
    <div class="alert alert-success">
        {{session('thongbao')}}
    </div>
@endif
@if(session('thongbaoloi'))
    <div class="alert alert-danger">
        {{session('thongbaoloi')}}
    </div>
@endif
<hr>
<!-- Binh luan c???a kh??ch h??ng -->
<h4 style="color: blue;"> <strong> B??nh lu???n c???a kh??ch h??ng ???? mua </strong></h4>
@if(isset($binhluan))
    @if(count($binhluan)>0)
        @foreach($binhluan as $item)
            <p style="margin-bottom: 0px;margin-left: 5px;color:grey"><strong>{{$item->tenkhachhang}}</strong></p>
            <div style="margin-left: 20px;max-width: 500px;"><?php echo $item->noidung ?></div>
        @endforeach
    @else
    <p style="margin-bottom: 0px;margin-left: 5px;"><strong>Kh??ng c?? b??nh lu???n n??o cho s???n ph???m n??y</strong></p>
    @endif

@endif
<!-- B??nh lu???n s???n ph???m -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="width: 600px;">
      <div class="modal-header">
        <h4 class="modal-title" style="font-family: Arial, Helvetica, sans-serif;">B??nh lu???n s???n ph???m</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <form action="{{ URL::to('frontend/binhluan/'.Cookie::get('cmnd').'/'.$sanpham[0]->masanpham ) }}" class="kenne-form" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form-group">
            <label for="comment">N???i dung:</label>
            <textarea class="form-control" rows="7" id="content" name="content"></textarea>
            <script type="text/javascript">CKEDITOR.replace('content'); </script>
        </div>
        <div class="kenne-form-inner">
            <div class="single-input"  style="margin-top: 10px;">
            <button type="submit" class="btn btn-primary" style="background-color:blue;padding:5px 8px;">Submit</button>
            </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection