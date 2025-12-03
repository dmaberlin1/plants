<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlantType;
use Illuminate\Http\JsonResponse;

class PlantTypeController extends Controller
{
    public function index(): JsonResponse
    {
        $types = PlantType::all();
        return response()->json(['data' => $types]);
    }
}
