<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Fachada de autenticação
use Illuminate\Support\Facades\Hash; // Para checar a senha
use Illuminate\Validation\ValidationException; // Para retornar erros de validação
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Users::all();

        return response()->json($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
         $request->validate([
            'nome' => 'required|string|max:255',
             'email' => 'nullable|string',
             'senha' => 'nullable|string',
         ]);

         $usuarios = Users::create([
             'nome' => $request->input('nome'),
             'email' => $request->input('email'),
             'numero_celular' => $request->input('numero_celular'),
            'senha' => $request->input('senha'),
         ]);

         return response()->json([
             'mensagem' => 'Usuario cadastrado com sucesso',
         ]);
     }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuarios = Users::find($id);

        if (is_null($usuarios)) {
            
            return response()->json([
                'mensagem' => 'Id do usuario não existir'
            ]);
        } else {

        return response()->json($usuarios);
    }


}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuarios = Users::find($id);

        $usuarios->nome = $request->input('nome');
        $usuarios->email = $request->input('email');
        $usuarios->senha = $request->input('senha');

        $usuarios->save();

        return response()->json(['mensagem' => 'Usuarios atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuarios = Users::findOrFail($id);

        $usuarios->delete();

        return response()->json(['mensagem' => 'Usuario deletado com sucesso']);
    }

     public function logout(Request $request)
    {
        // Desloga o usuário da sessão.
        Auth::logout();

        // Invalida a sessão atual no servidor e regenera o token CSRF.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Resposta de sucesso
        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }


     public function user(Request $request)
    {
        // O método user() da requisição retorna o modelo do usuário autenticado.
        return response()->json([
            'message' => 'Usuario logado com sucesso!',
            'user' => $request->user()
        ]);
    }

   
}        