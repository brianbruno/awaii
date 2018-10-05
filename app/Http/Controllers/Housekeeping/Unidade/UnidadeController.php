<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 26/09/2018
 * Time: 21:18
 */

namespace App\Http\Controllers\Housekeeping\Unidade;

use App\Unidade;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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

        return view('hk.unidade.cadastrar-unidade', ['resultado' => true]);
    }

    public function associar(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required',
            'unidade' => 'required'
        ]);

        $user = User::find($request->id);

        $user->unidade = $request->unidade;

        $user->save();

        return view('hk.unidade.associar-unidade', ['resultado' => true]);
    }

    public function indexEditar($id) {
        return view('hk.unidade.editar-unidade', ['unidade' => Unidade::find($id)]);
    }

    public function editar($id, Request $request) {
        $validatedData = $request->validate([
            'nome' => 'required',
            'telefone' => 'required'
        ]);

        $unidade = Unidade::find($id);

        $unidade->nome = $request->nome;
        $unidade->telefone = $request->telefone;

        $unidade->save();

        return view('hk.unidade.editar-unidade', ['resultado' => true, 'unidade' => $unidade]);
    }

    public function adicionarLicenca(Request $request){

        $resultado = false;

        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'id' => 'required',
                'validade_licenca' => 'required'
            ]);

            $unidade = Unidade::find($request->id);

            $date = \DateTime::createFromFormat('d/m/Y', $request->validade_licenca);
            $usableDate = $date->format('Y-m-d H:i:s');

            $unidade->validade_licenca = $usableDate;

            $unidade->save();

            $resultado = true;
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();

        }
        return view('hk.unidade.adicionar-licenca', ['resultado' => $resultado]);
    }

}
