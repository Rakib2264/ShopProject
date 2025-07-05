<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class CategoryController extends Controller
{
    public function CategoryList(){
        return Cache::remember('CategoryList', 3600, function(){
            return ResponseHelper::Out('Success', Category::all() , 200);
        });
    }
}
