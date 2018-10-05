<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 28/09/2018
 * Time: 22:03
 */

namespace App\Http\Controllers\Housekeeping\Usuario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UsuarioController {

    public function indexEditar($id) {
        return view('hk.usuario.editar-usuario', ['usuario' => User::find($id)]);
    }

    public function editar($id, Request $request) {

        $user = User::find($id);
        try {
            DB::beginTransaction();

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->unidade != 'null') {
                $user->unidade = $request->unidade;
            } else {
                $user->unidade = NULL;
            }
            $user->level = $request->level;

            $user->save();
            DB::commit();
            $response = view('hk.usuario.editar-usuario', ['usuario' => $user, 'resultado' => true]);
        } catch (\Exception $ex) {
            DB::rollBack();
            $response = view('hk.usuario.editar-usuario', ['exception' => $ex->getMessage(),
                'resultado' => false, 'usuario' => $user]);
        }

        return $response;
    }

}
