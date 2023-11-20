<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\ActivationService;

//Add protected variable:


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
protected $activationService;


    protected $redirectTo = '/home';


    public function __construct(ActivationService $activationService)
    {
        $this->middleware('guest');
         $this->activationService = $activationService;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
           // 'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'tipo_usuario'=>'required',
        ]);
    }
    protected function create(array $data)
    {
        return User::create([
            //'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'tipo_usuario' => $data['tipo_usuario']
        ]);
    }
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $user = $this->create($request->all());
        $this->activationService->sendActivationMail($user);
        return redirect('/login')->with('status', 'Te hemos enviado un codigo de activacion. Verifica tu Correo');
    }
}
