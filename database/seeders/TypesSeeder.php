<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $types = ['Books', 'Songs', 'Movies', 'Series'];

        foreach ($types as $t) {
            $type = new Type();
            $type->name = $t;
            $type->save();
        }
    }
}
