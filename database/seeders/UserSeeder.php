<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Wellington',
                'email' => 'wellington@shalomdigital.com.br',
                'password' => Hash::make('12345678'),
                'role' => 'admin'
            ],
            [
                'name' => 'Breno Onofre',
                'email' => 'breno.onofre@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Cesar Cavalcante',
                'email' => 'cesar.cavalcante@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Daniel Guima',
                'email' => 'daniel.guima@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Enzo Bruno',
                'email' => 'enzo.bruno@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Enzzo Capelo',
                'email' => 'enzzo.capelo@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Flávio Ferraz',
                'email' => 'flavio.ferraz@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Gabriel Melo',
                'email' => 'gabrielmelosp@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Genilson Oliveira',
                'email' => 'genilson.oliveira@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Gisele Rufino',
                'email' => 'gisele.rufino@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Karine Ferraz',
                'email' => 'karine.ferraz@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Laércio de Andrade',
                'email' => 'laercio.andrade@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Murillo Xavier',
                'email' => 'murillo.xavier@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Nathalia de Sá',
                'email' => 'nathalia.sa@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Priscila Souza',
                'email' => 'priscila.souza@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Renzo Di Crecico',
                'email' => 'renzo.dicrecico@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Stella Blima',
                'email' => 'stella.blima@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Tiago Doná',
                'email' => 'tiago.dona@teste.com.br',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Vinicius Rufino',
                'email' => 'vgrufino@hotmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ],
            [
                'name' => 'Vivianne Stafussi',
                'email' => 'vivianne.stafussi@teste.com',
                'password' => Hash::make('12345678'),
                'role' => 'member'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
