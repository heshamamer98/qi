<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Enums\StatusTitle;
use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'in progress' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('status', function ($query) {
                        $query->where('title', '=', StatusTitle::IN_PROGRESS);
                    });
                }),

            'done' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    // $query->status->title == StatusTitle::DONE
                    $query->whereHas('status', function ($query) {
                        $query->where('title', '=', StatusTitle::DONE);
                    });
                }),
        ];
    }
}
