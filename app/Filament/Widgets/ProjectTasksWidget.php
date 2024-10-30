<?php

namespace App\Filament\Widgets;

use App\Enums\StatusTitle;
use App\Models\Status;
use App\Models\Task;
use Filament\Widgets\ChartWidget;

class ProjectTasksWidget extends ChartWidget
{
    protected static ?string $heading = 'Tasks Statuses chart';
    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getFilters(): array
    {
        $taskStatuses = Status::getStatuses();
        array_unshift($taskStatuses, 'All');
        return $taskStatuses;
    }

    protected function getData(): array
    {
        $tasksQuery = Task::query()->with('status');
        if ($this->filter) {
            $tasksQuery->where('status_id', $this->filter);
        }

        $tasks = $tasksQuery->get()->groupBy(function ($tasksQuery) {
            return $tasksQuery->status->title;
        });

        $quantities = [];
        foreach ($tasks as $task => $value) {
            array_push($quantities, $value->count());
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tasks Statuses',
                    'data' => $quantities,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $this->filter ? [Status::getStatuses()[$this->filter]] : StatusTitle::values(),
        ];
    }



    protected function getType(): string
    {
        return 'bar';
    }
}
