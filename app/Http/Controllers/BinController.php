<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class BinController extends Controller
{
    public function login()
    {
        return view('Bin.login');
    }

}