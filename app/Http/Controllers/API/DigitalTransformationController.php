<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\DigitalTransformation;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;

class DigitalTransformationController extends Controller
{
    public function index(Request $request)
    {
        $digitalTransformations = DigitalTransformation::with('unit')->get();

        $filteredTransformations = $digitalTransformations->filter(function ($digitalTransformation) {
            return $digitalTransformation->unit && $digitalTransformation->unit->unit_code == "P17";
        });

        return response()->json($filteredTransformations);
    }

    public function indexQGV(Request $request)
    {
        $digitalTransformations = DigitalTransformation::with('unit')->get();

        $filteredTransformations = $digitalTransformations->filter(function ($digitalTransformation) {
            return $digitalTransformation->unit && $digitalTransformation->unit->unit_code == "QGV";
        });

        return response()->json($filteredTransformations);
    }
}
