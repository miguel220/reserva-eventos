<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipe;

class EquipeSeeder extends Seeder
{
    public function run()
    {
        Equipe::create(['nome' => 'Predestinados', 'descricao' => 'Descrição da Equipe A']);
        Equipe::create(['nome' => 'Atos 29', 'descricao' => 'Descrição da Equipe B']);
        Equipe::create(['nome' => 'Sal da Terra', 'descricao' => 'Descrição da Equipe C']);
        Equipe::create(['nome' => 'Conclamados', 'descricao' => 'Descrição da Equipe D']);
        Equipe::create(['nome' => 'Inabaláveis', 'descricao' => 'Descrição da Equipe E']);
        Equipe::create(['nome' => 'Convictos', 'descricao' => 'Descrição da Equipe F']);
        Equipe::create(['nome' => 'Gerados pela fé', 'descricao' => 'Descrição da Equipe G']);
        Equipe::create(['nome' => 'Saulo e bel', 'descricao' => 'Descrição da Equipe H']);
        Equipe::create(['nome' => 'Semeadores', 'descricao' => 'Descrição da Equipe I']);
        Equipe::create(['nome' => 'Sem Equipe', 'descricao' => 'Descrição da Equipe J']);
    }
}