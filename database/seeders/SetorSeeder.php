<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setor;

class SetorSeeder extends Seeder
{
    public function run()
    {
        $setores = [
            'Sonorização',
            'Iluminação',
            'Projeção',
            'Transmissão',
            'Fotografia',
            "Story's",
            'Diaconato',
            'Produção',
            'Louvor',
        ];

        foreach ($setores as $setor) {
            Setor::create(['nome' => $setor]);
        }
    }
}