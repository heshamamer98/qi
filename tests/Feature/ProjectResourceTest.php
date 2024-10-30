<?php

namespace Tests\Feature;

use App\Filament\Resources\ProjectResource\Pages\CreateProject;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Models\Project;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Tests\TestCase;
use Illuminate\Support\Str;
use Livewire\Livewire;

class ProjectResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Acting as admin user
        $user = User::where('name', 'admin')->first();
        $this->actingAs($user);
    }

    public function test_create_project()
    {
        $user = User::where('name', 'admin')->first();

        $name = Str::random(10);
        Livewire::test(CreateProject::class)
            ->fillForm([
                'name' => $name,
                'description' => $name . 'description',
                'author_id' => $user->id
            ])
            ->call('create')
            ->assertHasNoErrors();

        $project = Project::latest()->first();

        return $project;
    }

    /**
     * @depends test_create_project
     *
     * @return Project
     */
    public function test_edit_project($project)
    {
        $usersIds = User::whereIn('name', ['developer', 'manager'])->pluck('id')->toArray();

        // Edit palette
        Livewire::test(EditProject::class, [
            'record' => $project->getRouteKey()
        ])
            ->fillForm([
                'users' => $usersIds,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $project->refresh();

        return $project;
    }

    /**
     * @depends test_edit_project
     *
     * @return Project
     */
    public function test_delete_project($project)
    {
        // Delete palette
        Livewire::test(EditProject::class, [
            'record' => $project->getRouteKey()
        ])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($project);
    }
}
