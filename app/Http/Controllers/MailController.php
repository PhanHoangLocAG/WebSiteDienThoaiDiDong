<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
   private $mail;

   public function __construct($email)
   {
      $this->mail = $email ;
   }
    public function basic_email($ma , $ngay , $sanpham , $total , $ptgh) {
      
        $data = array(
                        'mahoadon' => $ma,
                        'ngaylap' => $ngay,
                        'sanpham' => $sanpham,
                        'total' => $total ,
                        'ptgh' => $ptgh
                     );
         Mail::send('mail', $data, function($message ) {
           $message->to( $this->mail , 'Phan hoang loc')->subject
              ('CẢM ƠN KHÁCH HÀNG ĐÃ MUA HÀNG');
        
           $message->from('nguyenthimyduyen@gmail.com','Cửa hàng điện thoại trung tín');
        });
        echo "Basic Email Sent. Check your inbox.";
     }
}
