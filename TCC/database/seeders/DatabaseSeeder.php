<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Chamando os seeders
        $this->call([
            UsuarioSeeder::class,
            EmpresaSeeder::class,
            VtuberSeeder::class, // Adicionando VtuberSeeder
            UsuarioVtuberSeeder::class,
        ]);
        
    }
}
