<?php

use Arifpay\Arifpay\ArifPay;
use Arifpay\Arifpay\Helper\ArifpaySupport;
use Arifpay\Arifpay\Lib\ArifpayBeneficary;
use Arifpay\Arifpay\Lib\ArifpayCheckoutItem;
use Arifpay\Arifpay\Lib\ArifpayCheckoutRequest;
use Arifpay\Arifpay\Lib\ArifpayOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("/test", function (Request $request) {
    $arifpay = new ArifPay('your-api');
    $dt = Carbon::now()->addHours(6);
    $expired = ArifpaySupport::getExpireDateFromDate($dt);
    $data = new ArifpayCheckoutRequest(
        "https://api.arifpay.com",
        floor(rand() * 10000) . "",
        'https://api.arifpay.com',
        'https://gateway.arifpay.net/test/callback',
        'https://127.0.0.1/beu-laravel',
        ["CARD"],
        $expired,
        [
            ArifpayCheckoutItem::fromJson([
                "name" => 'Bannana',
                "price" => 45,
                "quantity" => 1,
            ]),
        ],
        [
            ArifpayBeneficary::fromJson([
                "accountNumber" => '01320811436100',
                "bank" => 'AWINETAA',
                "amount" => 10.0,
            ]),
        ],
    );
    $session = $arifpay->create($data, new ArifpayOptions(false));
    return $session;
});

Route::get("/fetch/{id}", function (Request $request, $id) {
    $arifpay = new ArifPay('16WD8h8ab2xQjn1IFR6Lk6qFH4K5nc14');
    return $arifpay->fetch($id,new ArifpayOptions(true));
});