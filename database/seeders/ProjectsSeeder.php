<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::where('name', 'manager')->first();
        $developer = User::where('name', 'developer')->first();
        for ($i = 0; $i < 3; $i++) {
            $project = Project::firstOrCreate(
                [
                    'name' => 'project : ' . $i,
                ],
                [
                    'description' => 'project : ' . $i . 'description',
                    'author_id' => $manager->id,
                ]
            );

            if ($project->wasRecentlyCreated) {
                $project->users()->attach($manager->id);
                $project->users()->attach($developer->id);
            }
        }
    }
}
