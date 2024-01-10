<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComparisonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $param =[
            'id' =>1,
            'name' =>'aiueo',
            'price' =>2000,
        ];
        DB::table('comparisons')->insert($param);

        $param =[
            'id' =>2,
            'name' =>'kakikukeko',
            'price' =>1000,
        ];
        DB::table('comparisons')->insert($param);
    }
}
