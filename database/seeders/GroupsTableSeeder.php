<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Hour;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    public function run()
    {
        Group::factory(5)->create()->each(function ($g) {
            Hour::factory(20)->create(['group_id' => $g->id]);
        });
    }
}