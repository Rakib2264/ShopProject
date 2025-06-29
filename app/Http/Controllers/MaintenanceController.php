<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function ClearAppCache(){
        Artisan::call('cache:clear');
        return 'Cache cleared successfully';
    }
}
