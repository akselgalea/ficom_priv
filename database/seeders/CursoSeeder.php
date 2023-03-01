<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curso = new Curso([
            'curso'=> 'PK',
            'paralelo' => 'A',
            'arancel' => 25000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> 'PK',
            'paralelo' => 'B',
            'arancel' => 25000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> 'K',
            'paralelo' => 'A',
            'arancel' => 25000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> 'K',
            'paralelo' => 'B',
            'arancel' => 25000
        ]);
        $curso->save();

        $curso = new Curso([
            'curso'=> '1',
            'paralelo' => 'A',
            'arancel' => 30000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '1',
            'paralelo' => 'B',
            'arancel' => 30000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '2',
            'paralelo' => 'A',
            'arancel' => 30000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '2',
            'paralelo' => 'B',
            'arancel' => 30000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '3',
            'paralelo' => 'A',
            'arancel' => 30000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '3',
            'paralelo' => 'B',
            'arancel' => 30000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '4',
            'paralelo' => 'A',
            'arancel' => 30000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '4',
            'paralelo' => 'B',
            'arancel' => 30000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '5',
            'paralelo' => 'A',
            'arancel' => 40000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '5',
            'paralelo' => 'B',
            'arancel' => 40000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '6',
            'paralelo' => 'A',
            'arancel' => 40000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '6',
            'paralelo' => 'B',
            'arancel' => 40000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '7',
            'paralelo' => 'A',
            'arancel' => 40000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '7',
            'paralelo' => 'B',
            'arancel' => 40000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '8',
            'paralelo' => 'A',
            'arancel' => 40000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '8',
            'paralelo' => 'B',
            'arancel' => 40000
        ]);
        $curso->save();


        $curso = new Curso([
            'curso'=> '1M',
            'paralelo' => 'A',
            'arancel' => 50000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '1M',
            'paralelo' => 'B',
            'arancel' => 50000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '2M',
            'paralelo' => 'A',
            'arancel' => 50000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '2M',
            'paralelo' => 'B',
            'arancel' => 50000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '3M',
            'paralelo' => 'A',
            'arancel' => 50000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '3M',
            'paralelo' => 'B',
            'arancel' => 50000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '4M',
            'paralelo' => 'A',
            'arancel' => 50000
        ]);
        $curso->save();
        $curso = new Curso([
            'curso'=> '4M',
            'paralelo' => 'B',
            'arancel' => 50000
        ]);
        $curso->save();
    }
}
