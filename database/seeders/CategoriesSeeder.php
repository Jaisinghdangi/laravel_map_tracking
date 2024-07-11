<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Fantasy', 'Pop', 'Romance', 'Fiction'];

        foreach ($types as $t) {
            $type = new Category();
            $type->name = $t;
            $type->save();
        }
    }
}
