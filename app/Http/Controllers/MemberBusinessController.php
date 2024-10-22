<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberBusinessController extends Controller
{
    //
    public function showFormMemberBusiness(){
        return view('pages.client.gv.form-member-business');
    }
}
