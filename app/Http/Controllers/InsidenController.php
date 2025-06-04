<?php

namespace App\Http\Controllers;

class InsidenController extends Controller
{
    public function __invoke()
    {
        return view('datamutu.insiden.index');   
    }
}
