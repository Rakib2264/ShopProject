<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPEmail;
use App\Models\UserOTP;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendEmailJob;
use App\Helpers\ResponseHelper;
use App\Helpers\JWTToken;


class UserController extends Controller
{
    // public function SendOTP($UserEmail) {
    //     $OTP = rand(1000, 9999);
    //     $details = ['code' => $OTP];

    //     Mail::to($UserEmail)->send(new OTPEmail($details));
    //     UserOTP::updateOrCreate(['email' => $UserEmail], ['otp' => $OTP]);
    //     // Log::info('OTP sent to ' . $UserEmail, ['OTP' => $OTP]);

    //     return response()->json(['status' => 'success'], 200);
    // }

    // public function SendOTPLATTER($UserEmail) {
    //     $OTP = rand(1000, 9999);
    //     $details = ['code' => $OTP];

    //     // Mail::to($UserEmail)->send(new OTPEmail($details));
    //     SendEmailJob::dispatch($UserEmail, new OTPEmail($details));

    //     UserOTP::updateOrCreate(['email' => $UserEmail], ['otp' => $OTP]);

    //     return response()->json(['status' => 'success'], 200);
    // }

    public function UserLogin($UserEmail) {
         try{
             $OTP = rand(1000, 9999);
             $details = ['code' => $OTP];
             SendEmailJob::dispatch($UserEmail, new OTPEmail($details));
             User::updateOrCreate(['email' => $UserEmail], ['otp' => $OTP]);
             return ResponseHelper::Out('Success', ['Otp' => $OTP], 200);
         }catch(\Exception $e){
             return ResponseHelper::Out($e->getMessage(),[], 200);
         }
    }

    public function VerifyLogin($UserEmail, $OTP)
    {
        $user = User::where('email', $UserEmail)->first();

        if (!$user) {
            return ResponseHelper::Out('User not found', [], 404);
        }

        if ($user->otp == $OTP) {
            $user->update(['otp' => '0']);
            $token = JWTToken::CreateToken($UserEmail, $user->id);

            return ResponseHelper::Out('Success', ['token' => $token], 200);
        }

        return ResponseHelper::Out('Invalid OTP', [], 401);
    }


    public function Logout(){
        return redirect('/userLoginPage')->cookie('token',null,-1);
    }
}

