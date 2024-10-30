<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class OverviewWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 3;

    protected function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {
        $projectsCount = DB::table('projects')->count();
        $tasksCount = DB::table('tasks')->count();
        $commentsCount = DB::table('comments')->count();

        $tasksQuery = Task::with('status')->get()->groupBy(function ($tasksQuery) {
            return $tasksQuery->status->title;
        });

        $taskDescription = '';
        foreach ($tasksQuery as $key => $value) {
            $taskDescription.= $key. ': '. count($value). '<br>';
        }

        return [
            Stat::make('Projects count', $projectsCount)
                ->color('warning'),
            Stat::make('Tasks count', $tasksCount)
                ->color('warning')
                ->description(new HtmlString($taskDescription)),
            Stat::make('Comments count', $commentsCount)
                ->color('warning'),
        ];
    }
}
