<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function PolicyByType($type){
        return Cache::remember('PolicyByType'.$type, 3600, function() use ($type){
            return Policy::where('type', $type)->get();
        });
    }
}
