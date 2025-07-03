<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPEmail;
use App\Models\UserOTP;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendEmailJob;

class UserController extends Controller
{
    public function SendOTP($UserEmail) {
        $OTP = rand(1000, 9999);
        $details = ['code' => $OTP];

        Mail::to($UserEmail)->send(new OTPEmail($details));
        UserOTP::updateOrCreate(['email' => $UserEmail], ['otp' => $OTP]);
        // Log::info('OTP sent to ' . $UserEmail, ['OTP' => $OTP]);

        return response()->json(['status' => 'success'], 200);
    }

    public function SendOTPLATTER($UserEmail) {
        $OTP = rand(1000, 9999);
        $details = ['code' => $OTP];

        // Mail::to($UserEmail)->send(new OTPEmail($details));
        SendEmailJob::dispatch($UserEmail, new OTPEmail($details));

        UserOTP::updateOrCreate(['email' => $UserEmail], ['otp' => $OTP]);

        return response()->json(['status' => 'success'], 200);
    }
}

