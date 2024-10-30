<?php

namespace Tests\Feature;

use App\Enums\StatusTitle;
use App\Enums\TaskType;
use App\Filament\Resources\TaskResource\Pages\CreateTask;
use App\Filament\Resources\TaskResource\Pages\EditTask;
use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
use Tests\TestCase;
use Illuminate\Support\Str;
use Livewire\Livewire;

class TaskResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Acting as admin user
        $user = User::where('name', 'admin')->first();
        $this->actingAs($user);
    }

    public function test_create_task()
    {
        $user = User::where('name', 'admin')->first();
        $status_id = Status::where('title', StatusTitle::OPEN->value)->first()->id;

        $name = Str::random(10);
        $project = Project::create([
            'name' => $name,
            'description' => $name . 'description',
            'author_id' => $user->id
        ]);


        $title = Str::random(10);
        Livewire::test(CreateTask::class)
            ->fillForm([
                'title' => $title,
                'description' => $title . 'description',
                'type' => TaskType::FEATURE->value,
                'deadline' => Carbon::now()->addDay(),
                'project_id' => $project->id,
                'author_id' => $user->id,
                'status_id' => $status_id
            ])
            ->call('create')
            ->assertHasNoErrors();

        $task = Task::latest()->first();

        return $task;
    }

    /**
     * @depends test_create_task
     *
     * @return Task
     */
    public function test_edit_task($task)
    {
        $status_id = Status::where('title', StatusTitle::IN_PROGRESS->value)->first()->id;
        // Edit task
        Livewire::test(EditTask::class, [
            'record' => $task->getRouteKey()
        ])
            ->fillForm([
                'status_id' => $status_id,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $task->refresh();

        return $task;
    }

    /**
     * @depends test_edit_task
     *
     */
    public function test_delete_task($task)
    {
        // Delete task
        Livewire::test(EditTask::class, [
            'record' => $task->getRouteKey()
        ])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($task);
    }
}
