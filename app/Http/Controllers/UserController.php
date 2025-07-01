<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPEmail;
use App\Models\UserOTP;

class UserController extends Controller
{
public function SendOTP($UserEmail) {
    $OTP = rand(1000, 9999);
    $details = ['code' => $OTP];

    Mail::to($UserEmail)->send(new OTPEmail($details));
    UserOTP::updateOrCreate(['email' => $UserEmail], ['otp' => $OTP]);

    return response()->json(['status' => 'success'], 200);
}

}

