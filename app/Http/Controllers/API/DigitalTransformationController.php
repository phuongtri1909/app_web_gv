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
        $digitalTransformations = DigitalTransformation::get();

        return response()->json($digitalTransformations);
    }
}
