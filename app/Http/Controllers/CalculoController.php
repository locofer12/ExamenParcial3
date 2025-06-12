<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CalculoController extends Controller
{
    public function mostrarWorker(){

        return view('calculo.workers'); 
    }
}
