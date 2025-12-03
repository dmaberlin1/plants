<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlantProtectionProduct;
use Illuminate\Http\JsonResponse;

class PlantProtectionProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = PlantProtectionProduct::all();
        return response()->json(['data' => $products]);
    }
}
