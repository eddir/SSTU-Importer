<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Disable all mass assignment restrictions
        Model::unguard();

        $this->call(GroupsTableSeeder::class);

        // Re enable all mass assignment restrictions
        Model::reguard();
    }
}
