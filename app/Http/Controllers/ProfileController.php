<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();



        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'string|nullable',
            'password' => 'nullable|min:8|confirmed',
        ]);



        $telefone = $validated['telephone'];
        $telefoneFormatado = preg_replace('/\D/', '', $telefone); // Remove tudo que não for número
        $telefoneFormatado = preg_replace('/^55/', '+55', $telefoneFormatado); // Garante que o código do país fique correto
        $validated['telephone'] = $telefoneFormatado; // Resultado: +5511987624996

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->telephone = $telefoneFormatado;

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        //dd($validated);

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Dados atualizados com sucesso.');
    }
}
