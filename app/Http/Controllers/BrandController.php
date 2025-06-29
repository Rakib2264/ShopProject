<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class BrandController extends Controller
{
     public function BrandList(){
     return Cache::remember('BrandList', 3600, function(){
            return Brand::all();
        });
    }
}
