<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 26/09/2018
 * Time: 21:18
 */

namespace App\Http\Controllers\Housekeeping;

use App\Unidade;
use App\User;
use Illuminate\Http\Request;


class UnidadeController {

    public function cadastrar(Request $request) {
        $validatedData = $request->validate([
            'nome' => 'required|max:100',
            'telefone' => 'required|max:15'
        ]);

        $cliente = new Unidade();

        $cliente->nome = $request->nome;
        $cliente->telefone = $request->telefone;

        $cliente->save();

        return view('hk.cadastrar-unidade', ['resultado' => true]);
    }

    public function associar(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required',
            'unidade' => 'required'
        ]);

        $user = User::find($request->id);

        $user->unidade = $request->unidade;

        $user->save();

        return view('hk.associar-unidade', ['resultado' => true]);
    }

}
