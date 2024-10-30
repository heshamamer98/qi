<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OverviewWidget;
use App\Filament\Widgets\ProjectsWidget;
use App\Filament\Widgets\ProjectTasksWidget;
use App\Filament\Widgets\TasksWidget;
use Filament\Pages\Page;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    public function getWidgets(): array
    {
        return [
            OverviewWidget::class,
            ProjectTasksWidget::class,
        ];
    }
}
