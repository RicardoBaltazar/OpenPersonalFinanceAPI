<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Alimentação'],
            ['name' => 'Transporte'],
            ['name' => 'Saúde'],
            ['name' => 'Educação'],
            ['name' => 'Lazer'],
            ['name' => 'Moradia'],
            ['name' => 'Vestuário'],
            ['name' => 'Comunicação'],
            ['name' => 'Despesas Pessoais'],
            ['name' => 'Serviços'],
        ];

        DB::table('categories')->insert($categories);
    }
}
