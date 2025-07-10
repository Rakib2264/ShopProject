<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductSlider;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\ProductReview;
use App\Models\ProductWishes;
use App\Models\ProductCart;

class ProductController extends Controller
{
    public function ListProductByCategory($id){
        return Cache::remember('ListProductByCategory'.$id, 3600, function() use ($id){
            return ResponseHelper::Out('Success',Product::where('category_id', $id)->with('brand', 'category')->get(), 200);
        });
    }

    public function ListProductByRemark($remark){
        return Cache::remember('ListProductByRemark'.$remark, 3600, function() use ($remark){
            return ResponseHelper::Out('Success',Product::where('remark', $remark)->with('brand', 'category')->get(), 200);
        });
    }

    public function ListProductByBrand($id){
        return Cache::remember('ListProductByBrand'.$id, 3600, function() use ($id){
            return ResponseHelper::Out('Success',Product::where('brand_id', $id)->with('brand', 'category')->get(), 200);
        });
    }

    public function ListProductBySlider(){
        return Cache::remember('ListProductBySlider', 3600, function(){
            return ResponseHelper::Out('Success',ProductSlider::with('product')->get(), 200);
        });
    }

    public function ProductDetailsById($id){
        return Cache::remember('ProductDetailsById'.$id,3600,function () use($id){
            return ResponseHelper::Out('Success',ProductDetail::where('product_id', $id)->with('product', 'product.brand', 'product.category')->get(), 200);
        });
    }

        public function ListReviewByProduct($id){
        return Cache::remember('ListReviewByProduct'.$id, 3600, function() use ($id){
            return ResponseHelper::Out('Success',ProductReview::where('product_id', $id)->with([
                'profile'=>function($query){
                    $query->select('id', 'cus_name');
                }
            ])->get(), 200);
        });
    }

    public function ProductWishList(Request $request){
        $user_id = $request->header('id');
        return ResponseHelper::Out('Success',ProductWishes::where('user_id', $user_id)->with('product')->get(), 200);
    }

    public function CreateWishList(Request $request, $product_id){
        $user_id = $request->header('id');
        $data = ProductWishes::updateOrCreate(
            [ 'user_id' => $user_id, 'product_id' => $product_id],
            [ 'user_id' => $user_id, 'product_id' => $product_id]
        );

        return ResponseHelper::Out('Success', $data, 200);
    }


    public function RemoveWishList(Request $request, $product_id){
        $user_id = $request->header('id');
        $data = ProductWishes::where('user_id', $user_id)->where('product_id', $product_id)->delete();
        return ResponseHelper::Out('Success', $data, 200);
    }

    public function CreateCartList(Request $request, $product_id){
        $user_id = $request->header('id');
        $color = $request->input('color');
        $size = $request->input('size');
        $quantity = $request->input('quantity');
        $UnitPrice = 0;

        $productDetails = Product::where('id','=', $product_id)->first();

        if($productDetails->discount == 1){
            $UnitPrice = $productDetails->discount_price;
        }else{
            $UnitPrice = $productDetails->price;
        }
        $total = $UnitPrice * $quantity;

        $data = ProductCart::updateOrCreate(
            [ 'user_id' => $user_id, 'product_id' => $product_id],
            [ 
                'user_id' => $user_id, 
                'product_id' => $product_id,
                'color' => $color,
                'size' => $size,
                'quantity' => $quantity,
                'price' => $total
            ]
        );

        return ResponseHelper::Out('Success', $data, 200);

        
    }

    public function ProductCartList(Request $request){
        $user_id = $request->header('id');
        $data = ProductCart::where('user_id', $user_id)->with('product')->get();
        return ResponseHelper::Out('Success', $data, 200);
    }

    public function RemoveCartList(Request $request, $product_id){
        $user_id = $request->header('id');
        $data = ProductCart::where('user_id', $user_id)->where('product_id', $product_id)->delete();
        return ResponseHelper::Out('Success', $data, 200);
    }
}
