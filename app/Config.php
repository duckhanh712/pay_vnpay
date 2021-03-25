<?php
$vnp_TmnCode = "PQ5QGNWU"; //Mã website tại VNPAY
$vnp_HashSecret = "XKFGEIEPJCLIUZWDDLIRZCHXNJOOLVZB"; //Chuỗi bí mật
$vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/vnpay_php/vnpay_return.php";
 Class Http {


     public function execPostRequest($url, $data)
     {
         $ch = curl_init($url);
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                 'Content-Type: application/json',
                 'Content-Length: ' . strlen($data))
         );
         curl_setopt($ch, CURLOPT_TIMEOUT, 5);
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
         //execute post
         $result = curl_exec($ch);
         //close connection
         curl_close($ch);
         return $result;
     }

 }
