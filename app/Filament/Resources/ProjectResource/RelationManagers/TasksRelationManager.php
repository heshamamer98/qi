<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Filament\Resources\TaskResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    public function form(Form $form): Form
    {
        return TaskResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'sm' => 1,
                'md' => 1,
                'lg' => 1,
                'xl' => 2,
            ])
            ->recordTitleAttribute('title')
            ->columns([
                Grid::make()
                    ->schema([
                        Tables\Columns\TextColumn::make('title')
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'mb-2']),
                        Tables\Columns\TextColumn::make('description')
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'mb-2']),
                    ])
            ])
            ->recordUrl(
                fn (Model $record): string => TaskResource::getUrl('view', ['record' => $record->id]),
            )
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
