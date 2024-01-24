<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create roles
        DB::table('roles')->insert([
            'id'   => 1,
            'name' => 'Administrateur',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
            'id'   => 2,
            'name' => 'Employee',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // create attendances
        /*DB::table('attendances')->insert([
            'name' => Str::random(10),
        ]);*/
    }
}
