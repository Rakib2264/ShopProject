<?php

namespace App\Http\Controllers;

use App\Helpers\SSLCommerz;
use App\Models\Invoice;
use App\Models\CustomerProfile;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
   function PaymentCreate(Request $request , $id)
   {
    // dd($request->all(),$id);
        $OneInvoice=Invoice::where('id',$id)->first();
        $payable= $OneInvoice->payable;
        $tran_id= $OneInvoice->tran_id;
        return SSLCommerz::InitiatePayment($payable,$tran_id);

   }
    function PaymentFail(Request $request)
    {
        return SSLCommerz::InitiateFail($request->query('tran_id'));
    }
    function PaymentSuccess(Request $request)
    {
        return SSLCommerz::InitiateSuccess($request->query('tran_id'));
    }
    function PaymentCancel(Request $request)
    {

        return SSLCommerz::InitiateCancel($request->query('tran_id'));
    }
    function PaymentIPN(Request $request)
    {
        // Payment Received
        // Confirmation SMS
        // Confirmation Update
        // Confirmation Notice
        // status Wise Custom Action
        return SSLCommerz::InitiateIPN($request->input('tran_id'),$request->input('status'),$request->input('val_id'));
    }
} 
