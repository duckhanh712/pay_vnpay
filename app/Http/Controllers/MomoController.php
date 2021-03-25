<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\ConfigHttp;
class MomoController extends Controller
{
    public function index()
    {
        return view('momo.payment_form');
    }

    public function payment(Request $request)
    {


        $endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
        $partnerCode = 'MOMO6E5R20210311';
        $accessKey = 'gLRuTv07vONIm9cy';
        $secretKey = 'ZibBamS7aWTd0Pxv9lUs56mSmX3wn6m7';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = "10000";
        $orderId = time() . "";
        $returnUrl = "http://localhost:8000/paymomo/result.php";
        $notifyurl = "http://localhost:8000/paymomo/ipn_momo.php";
// Lưu ý: link notifyUrl không phải là dạng localhost
        $extraData = "merchantName=MoMo Partner";
        $orderId = $request->oderId; // Mã đơn hàng
//        $orderInfo =  $request->orderInfo;
        $amount =  $request->amount;
//        $notifyurl =  $request->notifyUrl;
//        $returnUrl =  $request->returnUrl;
        $extraData =  $request->extraData ?  $request->extraData : "";
        $requestId = time() . "";
        $requestType = "captureMoMoWallet";
        //before sign HMAC SHA256 signature
        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'returnUrl' => $returnUrl,
            'notifyUrl' => $notifyurl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
//            $result = ConfigHttp::execPostRequest($endpoint, json_encode($data));
//            $jsonResult = json_decode($result, true);  // decode json
        dd($data);
        $client = new \GuzzleHttp\Client();
        $request = $client->post($endpoint, $data);
        $client->setDefaultOption('headers', array('Content-type' => 'application/json;charset=UTF-8', ));
        $response = $request->send();

        dd($response['payUrl']);
        //Just a example, please check more in there

//            header('Location: ' . $jsonResult['payUrl']);
    }

}
