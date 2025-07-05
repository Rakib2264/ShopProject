<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerProfile;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseHelper;
use App\Models\ProductReview;

class ProfileController extends Controller
{
    public function CreateProfile(Request $request): JsonResponse
    {
    //   dd($request->all());
        $user_id = $request->header('id');
        $request->merge(['user_id' => $user_id]);
        // dd($request->all(), $user_id);

        $data = CustomerProfile::updateOrCreate(
            ['user_id' => $user_id],
            $request->input()
        );

        return ResponseHelper::Out('Success',$data, 200);
    }

    public function ReadProfile(Request $request): JsonResponse
    {
        $user_id = $request->header('id');

        $data = CustomerProfile::where('user_id', $user_id)
            ->with('user')
            ->first();

        return ResponseHelper::Out('Success', $data, 200);
    }

    public function CreateProductReview(Request $request): JsonResponse {
    $user_id = $request->header('id');

    $profile = CustomerProfile::where('user_id', $user_id)->first();
    // dd($profile);

    if ($profile) {
        $request->merge(['customer_id' => $profile->id]);

        $data = ProductReview::updateOrCreate(
            [
                'customer_id' => $profile->id,
                'product_id' => $request->input('product_id')
            ],
            $request->input()
        );

        return ResponseHelper::Out('Success', $data, 200);
    } else {
        return ResponseHelper::Out('Success', 'customer profile not exists', 200);
    }
}

}