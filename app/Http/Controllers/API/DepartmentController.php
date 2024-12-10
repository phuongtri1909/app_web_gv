<?php

namespace App\Http\Controllers\API;

use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::get();
        return response()->json($departments);
    }
}
