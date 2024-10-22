<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LawsController extends Controller
{
    //
    public function showFormLegal(){
        return view('pages.client.gv.form-law');
    }
}
