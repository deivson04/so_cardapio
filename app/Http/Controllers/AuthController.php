<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validação dos dados de entrada
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        // 2. Busca o usuário pelo email
        $user = Users::where('email', $request->email)->first();

        // 3. Verifica as credenciais e se o usuário é um administrador
        // Se o usuário não existir OU a senha estiver incorreta, ou NÃO for um admin,
        // retorna um erro de credenciais.
        if (! $user || ! Hash::check($request->senha, $user->senha) || ! $user->is_admin) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas ou você não tem permissão de administrador.'],
            ]);
        }

        // 4. Autentica o usuário na sessão
        // Usa a fachada Auth para efetivar o login do usuário.
        Auth::login($user);

        // 5. Resposta de sucesso
        return response()->json([
            'message' => 'Login de administrador realizado com sucesso!',
            'user' => $user
        ]);
    }

   public function register(Request $request)
   {
        $request->validate([
            'nome' => 'required|string|max:255',
             'email' => 'nullable|string',
             'senha' => 'nullable|string',
         ]);

         $usuarios = Users::create([
             'nome' => $request->input('nome'),
             'email' => $request->input('email'),
         ]); 
         
         return response()->json([
             'mensagem' => 'Usuario logado com sucesso',
         ]);
   }
}
