<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\SslcommerzAccount;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;



class SSLCommerz 

{
    static function InitiatePayment($payable,$tran_id)
    {
        // dd($payable,$tran_id);
        try {
            $ssl=SslcommerzAccount::first();
            // dd($ssl->store_id,$ssl->store_passwd);
            $response=Http::asForm()->post($ssl->init_url, [
                "store_id"=>$ssl->store_id,
                "store_passwd"=>$ssl->store_passwd,
                'total_amount'=>$payable,
                'currency'=>'BDT',
                'tran_id'=>$tran_id,
                'success_url'=>"$ssl->success_url?tran_id=$tran_id",
                'fail_url'=>"$ssl->fail_url?tran_id=$tran_id",
                'cancel_url'=>"$ssl->cancel_url?tran_id=$tran_id",
                'ipn_url'=>$ssl->ipn_url,
                'cus_name'=>'Rabbil',
                'cus_email'=>'engr.rabbil@yahoo.com',
                'cus_add1'=>'Dhaka',
                'cus_add2'=>'Gulshan',
                'cus_city'=>'Dhaka',
                'cus_state'=>'Dhaka',
                'cus_postcode'=>'1207',
                'cus_country'=>'Bangladesh',
                'cus_phone'=>'01774688159',
                'cus_fax'=>'01774688159',
                'shipping_method'=>'SA Paribahan',
                'ship_name'=>'Salif Al Hasan',
                'ship_add1'=>'Dhaka',
                "ship_add2"=>"Gulshan",
                "ship_city"=>"Dhaka",
                "ship_state"=>"Dhaka",
                "ship_country"=>"Bangladesh",
                "ship_postcode"=>"1207",
                "product_name"=>"Macbook Laptop",
                "product_category"=>"Laptop",
                "product_profile"=>"Electronics",
                "product_amount"=>10
            ]);
           return $response->json('desc');

        }
        catch (Exception $e){
            return $e->getMessage();
        }

    }


    static function InitiateFail($tran_id)
    {
        try {
            Invoice::where(['tran_id'=>$tran_id,'val_id'=>0])->update(['payment_status'=>'fail']);
            return 1;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }
    static function InitiateSuccess($tran_id)
    {
        try {
            Invoice::where(['tran_id'=>$tran_id,'val_id'=>0])->update(['payment_status'=>'success']);
            return 1;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }
    static function InitiateCancel($tran_id)
    {
        try {
            Invoice::where(['tran_id'=>$tran_id,'val_id'=>0])->update(['payment_status'=>'cancel']);
            return 1;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }
    static function InitiateIPN($tran_id,$status,$val_id){
        try {
            Invoice::where(['tran_id'=>$tran_id,'val_id'=>0])->update(['payment_status'=>$status,'val_id'=>$val_id]);
            return 1;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }

}
