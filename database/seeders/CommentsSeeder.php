<?php

namespace Database\Seeders;

use App\Enums\StatusTitle;
use App\Enums\TaskType;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::where('name', 'manager')->first();
        $admin = User::where('name', 'admin')->first();
        $task_id = Task::latest()->first()->id;

        Comment::create([
            'content' => Str::random(10),
            'task_id' => $task_id,
            'author_id' => $manager->id,
        ]);

        Comment::create([
            'content' => Str::random(10),
            'task_id' => $task_id,
            'author_id' => $admin->id,
        ]);

    }
}
