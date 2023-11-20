<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Gnral_Personales;
use App\Http\Requests;

use Session;

use Illuminate\Support\Facades\Auth;
use App\User;
class Tutorias_AsignaCorGenController extends Controller
{
    //
    public function index()
    {

        return view('tutorias.asignacorgen.index');

    }
}
