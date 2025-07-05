<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class MaintenanceController extends Controller
{
    public function ClearAppCache(){
        Artisan::call('cache:clear');
        return ResponseHelper::Out('Success', 'Cache Cleared', 200);
    }
}
