<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function PolicyByType($type){
        return Cache::remember('PolicyByType'.$type, 3600, function() use ($type){
            return ResponseHelper::success('Success',Policy::where('type', $type)->get(), 200);
        });
    }
}
