<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductSlider;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function ListProductByCategory($id){
        return Cache::remember('ListProductByCategory'.$id, 3600, function() use ($id){
            return Product::where('category_id', $id)->with('brand', 'category')->get();
        });
    }

    public function ListProductByRemark($remark){
        return Cache::remember('ListProductByRemark'.$remark, 3600, function() use ($remark){
            return Product::where('remark', $remark)->with('brand', 'category')->get();
        });
    }

    public function ListProductByBrand($id){
        return Cache::remember('ListProductByBrand'.$id, 3600, function() use ($id){
            return Product::where('brand_id', $id)->with('brand', 'category')->get();
        });
    }

    public function ListProductBySlider(){
        return Cache::remember('ListProductBySlider', 3600, function(){
            return ProductSlider::all();
        });
    }

    public function ProductDetailsById($id){
        return Cache::remember('ProductDetailsById'.$id,3600,function () use($id){
            return ProductDetail::where('product_id',$id)->with('product','product.brand','product.category')->get();
        });
    }
}
