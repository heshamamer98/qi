<?php

namespace Tests\Feature;

use App\Enums\StatusTitle;
use App\Enums\TaskType;
use App\Filament\Resources\CommentResource\Pages\CreateComment;
use App\Filament\Resources\CommentResource\Pages\EditComment;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
use Tests\TestCase;
use Illuminate\Support\Str;
use Livewire\Livewire;

class CommentResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Acting as admin user
        $user = User::where('name', 'admin')->first();
        $this->actingAs($user);
    }

    public function test_create_comment()
    {
        $user = User::where('name', 'admin')->first();
        $status_id = Status::where('title', StatusTitle::IN_PROGRESS->value)->first()->id;

        $name = Str::random(10);
        $project = Project::create([
            'name' => $name,
            'description' => $name . 'description',
            'author_id' => $user->id
        ]);

        $title = Str::random(10);
        $task = Task::create([
            'title' => $title,
            'description' => $title . 'description',
            'type' => TaskType::FEATURE->value,
            'deadline' => Carbon::now()->addDay(),
            'project_id' => $project->id,
            'author_id' => $user->id,
            'status_id' => $status_id
        ]);


        $content = Str::random(25);
        Livewire::test(CreateComment::class)
            ->fillForm([
                'content' => $content,
                'task_id' => $task->id,
                'author_id' => $user->id,
            ])
            ->call('create')
            ->assertHasNoErrors();

        $comment = Comment::latest()->first();

        return $comment;
    }

    /**
     * @depends test_create_comment
     *
     * @return Comment
     */
    public function test_edit_comment($comment)
    {
        $newContent = Str::random(25);
        // Edit comment
        Livewire::test(EditComment::class, [
            'record' => $comment->getRouteKey()
        ])
            ->fillForm([
                'content' => $newContent,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $comment->refresh();

        return $comment;
    }

    /**
     * @depends test_edit_comment
     *
     */
    public function test_delete_comment($comment)
    {
        // Delete comment
        Livewire::test(EditComment::class, [
            'record' => $comment->getRouteKey()
        ])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($comment);
    }
}
