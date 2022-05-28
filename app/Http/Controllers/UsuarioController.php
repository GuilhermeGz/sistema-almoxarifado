<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        if (Gate::allows('read-usuario')) {
            return view('usuario/usuario_index', ['usuarios' => Usuario::withTrashed()->get()]);
        }
        if (Gate::denies('read-usuario')) {
            abort('403', 'Não Autorizado');
        }
    }

    public function create()
    {
        return view('usuario/usuario_create', ['cargos' => Cargo::all()]);
    }

    public function store(Request $request)
    {

        $request['cpf'] = str_replace(['.', '-'], '', $request['cpf']);
        $request['numTel'] = str_replace(['(', ')', '-'], '', $request['numTel']);

        $validator = Validator::make($request->all(), Usuario::$rules, Usuario::$messages)->validate();

        $data = [
            'nome' => $request['nome'],
            'email' => $request['email'],
            'cpf' => $request['cpf'],
            'rg' => $request['rg'],
            'data_nascimento' => $request['data_nascimento'],
            'matricula' => $request['matricula'],
            'cargo_id' => $request['cargo'],
            'numTel' => $request['numTel'],
            'senha' => Hash::make($request->password),
            'setor' => $request['setor'],
        ];

        Usuario::create($data);


        $credentials = ['email' => $request['email']];
        Password::sendResetLink($credentials);
        return redirect(route('usuario.index'));
    }

    public function show($id)
    {
        if (Gate::allows('read-usuario')) {
            return view('usuario/usuario_show', ['usuario' => Usuario::find($id)]);
        }
        if (Gate::denies('read-usuario')) {
            abort('403', 'Não Autorizado');
        }
    }

    public function edit($id)
    {
        if (Gate::allows('update-usuario', $id)) {
            return view('usuario/usuario_edit', ['usuario' => Usuario::find($id), 'cargos' => Cargo::all()]);
        }
        if (Gate::denies('update-usuario', $id)) {
            abort('403', 'Não Autorizado');
        }
    }

    public function edit_perfil($id)
    {
        return view('usuario/usuario_edit_perfil', ['usuario' => Usuario::find($id), 'cargos' => Cargo::all()]);
    }

    public function edit_senha($id)
    {
        return view('usuario/usuario_edit_senha', ['usuario' => Usuario::find($id)]);
    }

    public function update_perfil(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        $rules = array_slice(Usuario::$rules, 0, 7);
        $messages = array_slice(Usuario::$messages, 0, 23);

        $rules['email'] = [
            'required', 'email', 'min:5', 'max:100',
            Rule::unique('usuarios')->ignore($usuario->id),
        ];

        $rules['cpf'] = [
            'required', 'numeric', 'min:0', 'digits_between:10,11',
            Rule::unique('usuarios')->ignore($usuario->id),
        ];

        $rules['rg'] = [
            'required', 'numeric', 'min:0', 'digits_between:7,11',
            Rule::unique('usuarios')->ignore($usuario->id),
        ];

        $rules['matricula'] = [
            'required', 'integer', 'min:1',
            Rule::unique('usuarios')->ignore($usuario->id),
        ];

        $request['cpf'] = str_replace(['.', '-'], '', $request['cpf']);
        $request['numTel'] = str_replace(['(', ')', '-'], '', $request['numTel']);

        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $data = [
            'nome' => $request['nome'],
            'email' => $request['email'],
            'cpf' => $request['cpf'],
            'rg' => $request['rg'],
            'data_nascimento' => $request['data_nascimento'],
            'matricula' => $request['matricula'],
            'numTel' => $request['numTel'],
            'setor' => $request['setor'],
        ];

        $usuario->fill($data)->Update();

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function update_senha(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        $rules = array_slice(Usuario::$rules, 7);
        $messages = array_slice(Usuario::$messages, 27);

        $rules['current_password'] = 'required|string|min:8|password';

        $messages['current_password.required'] = 'A senha atual é um campo obrigatório.';
        $messages['current_password.min'] = 'A senha atual deve ter no mínimo 8 caracteres.';
        $messages['current_password.password'] = 'A senha atual está incorreta';

        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $usuario->senha = Hash::make($request->password);

        $usuario->save();

        return redirect()->back()->with('success', 'Senha atualizada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        $rules = array_slice(Usuario::$rules, 0, 7);

        $messages = array_slice(Usuario::$messages, 0, 23);

        $rules['email'] = [
            'required', 'email', 'min:5', 'max:100',
            Rule::unique('usuarios')->ignore($usuario->id),
        ];

        $rules['cpf'] = [
            'required', 'numeric', 'min:0', 'digits_between:10,11',
            Rule::unique('usuarios')->ignore($usuario->id),
        ];

        $rules['rg'] = [
            'required', 'numeric', 'min:0', 'digits_between:7,11',
            Rule::unique('usuarios')->ignore($usuario->id),
        ];

        $rules['matricula'] = [
            'required', 'integer', 'min:1',
            Rule::unique('usuarios')->ignore($usuario->id),
        ];

        $request['cpf'] = str_replace(['.', '-'], '', $request['cpf']);
        $request['numTel'] = str_replace(['(', ')', '-'], '', $request['numTel']);

        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $data = [
            'email' => $request['email'],
            'nome' => $request['nome'],
            'cpf' => $request['cpf'],
            'rg' => $request['rg'],
            'data_nascimento' => $request['data_nascimento'],
            'matricula' => $request['matricula'],
            'cargo_id' => $request['cargo'],
            'numTel' => $request['numTel'],
            'setor' => $request['setor'],
        ];

        $usuario->fill($data)->Update();

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuario = Usuario::all()->find($id);
        $usuario->delete();

        return redirect(route('usuario.index'))->with('sucess', 'Usuário removido com sucesso!');
    }

    public function restore($id)
    {
        $usuario = Usuario::onlyTrashed()->where('id', $id)->first();
        $usuario->restore();

        return redirect(route('usuario.index'))->with('sucess', 'Usuário restaurado com sucesso!');
    }
}
