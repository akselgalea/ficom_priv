<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Curso;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        
        $this->call(CursoSeeder::class);
        
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'contabilidad']);
        Role::create(['name' => 'matriculas']);
        
        $user = \App\Models\User::factory()->create([
            'name' => 'Usuario admin',
            'email' => 'admin@ficom.cl',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('admin');
        
        $user = \App\Models\User::factory()->create([
            'name' => 'Usuario contabilidad',
            'email' => 'contabilidad@ficom.cl',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('contabilidad');
        
        $user = \App\Models\User::factory()->create([
            'name' => 'Usuario matriculas',
            'email' => 'matriculas@ficom.cl',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('matriculas');
        
        // \App\Models\Apoderado::factory(7)->create();
        // \App\Models\Estudiante::factory(10)->create();
        
    }
}
