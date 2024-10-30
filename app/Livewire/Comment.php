<?php

namespace App\Livewire;

use App\Events\commentEvent;
use App\Models\Comment as ModelsComment;
use Carbon\Carbon;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;

class Comment extends Component implements HasForms
{
    use InteractsWithForms;

    public $comments;
    public $taskId;
    public $data = [];

    public function mount($taskId = null)
    {
        $this->taskId = $taskId;
        $this->comments = ModelsComment::select('content', 'author_id', 'created_at')->with([
            'author' => function ($query) {
                $query->select('id', 'name');
            }
        ])->where('task_id', $taskId)->get()->toArray();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('content')
                ->label('Write new comment')
                ->rows(3)
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();
        $newComment = ModelsComment::create([
            'content' => $data['content'],
            'task_id' => $this->taskId,
            'author_id' => $user->id,
        ]);

        if ($newComment) {
            event(new commentEvent($user, $data['content']));
        }
        $this->data = [];
    }


    public static function getHeader()
    {
        return "comments";
    }


    public function render()
    {
        return view('livewire.comment');
    }
}
