<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VNPAY RESPONSE</title>
    <!-- Bootstrap core CSS -->
    <link href="/backend/assets/bootstrap.min.css" rel="stylesheet"/>
    <!-- Custom styles for this template -->
    <link href="/backend/assets/jumbotron-narrow.css" rel="stylesheet">
    <script src="/backend/assets/jquery-1.11.3.min.js"></script>
</head>
<body>
<?php
$vnp_TmnCode = "PQ5QGNWU"; //Mã website tại VNPAY
$vnp_HashSecret = "XKFGEIEPJCLIUZWDDLIRZCHXNJOOLVZB"; //Chuỗi bí mật
$vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/vnpay_php/vnpay_return.php";
$vnp_SecureHash = $_GET['vnp_SecureHash'];
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}
unset($inputData['vnp_SecureHashType']);
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData = $hashData . '&' . $key . "=" . $value;
    } else {
        $hashData = $hashData . $key . "=" . $value;
        $i = 1;
    }
}

//$secureHash = md5($vnp_HashSecret . $hashData);
$secureHash = hash('sha256',$vnp_HashSecret . $hashData);
?>
<!--Begin display -->
<div class="container">
    <div class="header clearfix">
        <h3 class="text-muted col-6">VNPAY RESPONSE</h3>
        <a class="col-6" href="{{route('payment.form')}}">Tiếp tục thanh toán</a>
    </div>
    <div class="table-responsive">
        <div class="form-group">
            <label >Mã đơn hàng:</label>

            <label><?php echo $_GET['vnp_TxnRef'] ?></label>
        </div>
        <div class="form-group">

            <label >Số tiền:</label>
            <label><?php echo  number_format($_GET['vnp_Amount']/100,0,",",".").' đ'  ?></label>
        </div>
        <div class="form-group">
            <label >Nội dung thanh toán:</label>
            <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
        </div>
        <div class="form-group">
            <label > (vnp_ResponseCode):</label>
            <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
        </div>
        <div class="form-group">
            <label >Mã GD Tại VNPAY:</label>
            <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
        </div>
        <div class="form-group">
            <label >Mã Ngân hàng:</label>
            <label><?php echo $_GET['vnp_BankCode'] ?></label>
        </div>
        <div class="form-group">
            <label >Thời gian thanh toán:</label>
            <label><?php echo Carbon\Carbon::parse($_GET['vnp_PayDate'])->format('Y-m-d H:i:s') ?></label>
        </div>
        <div class="form-group">
            <label >Kết quả:</label>
            <label>
                <?php
                if ($secureHash == $vnp_SecureHash) {
                    if ($_GET['vnp_ResponseCode'] == '00') {
                        echo "GD Thanh cong";
                    } else {
                        echo "GD Khong thanh cong";
                    }
                } else {
                    echo "Chu ky khong hop le";
                }
                ?>

            </label>
        </div>
    </div>
    <p>
        &nbsp;
    </p>
    <footer class="footer">
        <p>&copy; VNPAY 2015</p>
    </footer>
</div>
</body>
</html>
