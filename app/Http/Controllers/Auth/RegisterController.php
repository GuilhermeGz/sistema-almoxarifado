<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Img;
use App\Providers\RouteServiceProvider;
use App\Usuario;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, \App\Usuario::$rules, \App\Usuario::$messages);
    }

    protected function create(array $data)
    {
        $imgExtension = $data['imagem']->extension();
        $imgName = Img::nameNewImage(Usuario::all(), $data['nome'], $imgExtension);

        $data['imagem']->storeAs(Img::usuariosDir(), $imgName);

        return Usuario::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'cpf' => $data['cpf'],
            'rg' => $data['rg'],
            'data_nascimento' => $data['data_nascimento'],
            'matricula' => $data['matricula'],
            'imagem' => $imgName,
            'senha' => Hash::make($data['password']),
            'cargo_id' => 1
        ]);
    }
}
