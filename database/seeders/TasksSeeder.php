<?php

namespace Database\Seeders;

use App\Enums\StatusTitle;
use App\Enums\TaskType;
use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project = Project::latest()->first();
        $user = User::where('name', 'manager')->first();
        $openStatus = Status::where('title', StatusTitle::OPEN->value)->first();
        $inProgressStatus = Status::where('title', StatusTitle::IN_PROGRESS->value)->first();
        $reviewStatus = Status::where('title', StatusTitle::REVIEW->value)->first();
        Task::create([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'type' => TaskType::FEATURE->value,
            'deadline' => now()->addDay(),
            'project_id' => $project->id,
            'author_id' => $user->id,
            'status_id' => $openStatus->id,
        ]);

        Task::create([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'type' => TaskType::FEATURE->value,
            'deadline' => now()->addDay(),
            'project_id' => $project->id,
            'author_id' => $user->id,
            'status_id' => $inProgressStatus->id,
        ]);

        Task::create([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'type' => TaskType::FEATURE->value,
            'deadline' => now()->addDay(),
            'project_id' => $project->id,
            'author_id' => $user->id,
            'status_id' => $inProgressStatus->id,
        ]);
        Task::create([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'type' => TaskType::BUG->value,
            'deadline' => now()->addDay(),
            'project_id' => $project->id,
            'author_id' => $user->id,
            'status_id' => $reviewStatus->id,
        ]);
    }
}
