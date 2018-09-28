<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 22/09/2018
 * Time: 18:32
 */

namespace App\Http\Controllers\Cliente;

use Illuminate\Support\Facades\Auth;
use App\Cliente;
use Illuminate\Http\Request;

class ClienteController {

    public  function index () {
        return view('system.cliente.index', ['clientes' => Cliente::all()]);
    }

    public function cadastrar (Request $request) {

        $validatedData = $request->validate([
            'nome' => 'required|max:100',
            'cpf' => 'required|unique:clientes|max:11|cpf',
            'telefone' => 'required|max:15|numeric',
            'email' => 'required|email',
            'endereco' => 'required',
        ]);

        $cliente = new Cliente();

        $cliente->nome = $request->nome;
        $cliente->cpf = $request->cpf;
        $cliente->telefone = $request->telefone;
        $cliente->email = $request->email;
        $cliente->endereco = $request->endereco;
        $cliente->unidade = Auth::user()->unidade;

        $cliente->save();

        return view('system.cliente.cadastrar-cliente', ['resultado' => true]);
    }

    public function indexEditar ($id) {
        return view('system.cliente.editar-cliente', ['cliente' => Cliente::find($id)]);
    }

    public function editar(Request $request) {
        $validatedData = $request->validate([
            'telefone' => 'required|max:15|numeric',
            'email' => 'required|email',
            'endereco' => 'required',
        ]);

        $cliente = Cliente::find($request->id);

        $cliente->telefone = $request->telefone;
        $cliente->email = $request->email;
        $cliente->endereco = $request->endereco;

        $cliente->save();

        return view('system.cliente.editar-cliente', ['resultado' => true, 'cliente' => $cliente]);
    }
}
