<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')
        ->paginate(10);;
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|in:admin,member',
            ],
            [
                'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
                'email.unique' => 'Este email já está em uso.'
            ]
        );


        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'string',
            'role' => 'required|in:admin,member',
        ]);

        $telefone = $validated['telephone'];
        $telefoneFormatado = preg_replace('/\D/', '', $telefone); // Remove tudo que não for número
        $telefoneFormatado = preg_replace('/^55/', '+55', $telefoneFormatado); // Garante que o código do país fique correto

        $validated['telephone'] = $telefoneFormatado; // Resultado: +5511987624996

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        //dd($validated);

        $user->update($validated);
        return redirect()->route('users.edit', $user->id)->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Você não pode deletar sua própria conta, entre em contato com o Administrador.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
