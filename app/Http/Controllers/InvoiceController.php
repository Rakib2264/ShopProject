<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CustomerProfile;
use App\Models\ProductCart;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Helpers\ResponseHelper;
use App\Helpers\SSLCommerz;


class InvoiceController extends Controller
{
    public function InvioiceCreate(Request $request){
        // dd($request->all());
        
        DB::beginTransaction();
        try{
            $user_id = $request->header('id');
            $user_email = $request->header('email');

            $tran_id = uniqid();
            $deivery_status ='Pending';
            $payment_status = 'Pending';

            $profile = CustomerProfile::where('user_id', $user_id)->first();
            $cus_details = "Name:$profile->cus_name, Email:$user_email, Phone:$profile->cus_phone, Address:$profile->cus_address , City:$profile->cus_city";
            $ship_details = "Name:$profile->ship_name, Email:$user_email, Phone:$profile->cus_phone, Address:$profile->ship_address , City:$profile->ship_city";

            // Payable Calculation
            $total = 0;
            $cartList = ProductCart::where('user_id', $user_id)->get();
            foreach($cartList as $cartItem){
                $total = $total + $cartItem->price;
            }

            $vat = ($total * 3) / 100;
            $payable = $total + $vat;

            $invoice = Invoice::create([
                'total' => $total,
                'vat' => $vat,
                'payable' => $payable,
                'cus_details' => $cus_details,
                'ship_details' => $ship_details,
                'tran_id' => $tran_id,
                'delivery_status' => $deivery_status,
                'payment_status' => $payment_status,
                'user_id' => $user_id
            ]);

            $invoice_id = $invoice->id;

            // foreach($cartList as $cartItem){
            //     InvoiceProduct::create([
            //         'invoice_id' => $invoice_id,
            //         'product_id' => $EachPrpduct['product_id'],
            //         'user_id' => $user_id,
            //         'qty' => $EachPrpduct['quantity'],
            //         'sale_price' => $EachPrpduct['price']
            //     ]);
            // }

            foreach($cartList as $cartItem){
    InvoiceProduct::create([
        'invoice_id' => $invoice_id,
        'product_id' => $cartItem->product_id,
        'user_id' => $user_id,
        'qty' => $cartItem->quantity,
        'sale_price' => $cartItem->price
    ]);
}

            $payableMethod = SSLCommerz::InitiatePayment($tran_id, $payable);

            DB::commit();
            return ResponseHelper::Out('Success', array(['payment_url' => $payableMethod, 'payable' => $payable,'vat' => $vat, 'total' => $total]), 200);

        }catch(\Exception $e){
            DB::rollBack();
            return ResponseHelper::Out('Error', $e->getMessage(), 500);
        }
    }

    function InvoiceList(Request $request){
    $user_id = $request->header('id');
    return Invoice::where('user_id', $user_id)->get();
}

function InvoiceProductList(Request $request){
    $user_id = $request->header('id');
    $invoice_id = $request->invoice_id;
    return InvoiceProduct::where(['user_id' => $user_id, 'invoice_id' => $invoice_id])->with('product')->get();
}

function PaymentSuccess(Request $request){
    // dd($request->all());
    return SSLCommerz::InitiateSuccess($request->query('tran_id'));
}

function PaymentCancel(Request $request){
    return SSLCommerz::InitiateCancel($request->query('tran_id'));
}

function PaymentFail(Request $request){
    return SSLCommerz::InitiateFail($request->query('tran_id'));
}

function PaymentIPN(Request $request){
    return SSLCommerz::InitiateIPN(
        $request->input('tran_id'),
        $request->input('status'),
        $request->input('val_id')
    );
}

}
