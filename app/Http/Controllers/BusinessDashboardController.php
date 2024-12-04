<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessField;

class BusinessDashboardController extends Controller
{
    public function index()
    {
        $business_member = auth()->user()->businessMember;

        $businessFieldIds = json_decode($business_member->business_field_id, true);
        $businessFields = BusinessField::whereIn('id', $businessFieldIds)->get();
        return view('admin.business.dashboard', compact('business_member', 'businessFields'));
    }
}
