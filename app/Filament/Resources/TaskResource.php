<?php

namespace App\Filament\Resources;

use App\Enums\StatusTitle;
use App\Enums\TaskType;
use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Status;
use App\Models\Task;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3),

                        Forms\Components\DateTimePicker::make('deadline')
                            ->native(false),

                        Forms\Components\Select::make('project_id')
                            ->required()
                            ->relationship('project', 'name'),

                        Forms\Components\Select::make('type')
                            ->required()
                            ->options(TaskType::values()),

                        SpatieMediaLibraryFileUpload::make('image')
                            ->disk('media')
                            ->image()
                            ->openable(),

                        Forms\Components\Select::make('author_id')
                            ->label('Created by')
                            ->required()
                            ->relationship('author', 'name')
                            ->disabled()
                            ->default(auth()->user()->id)
                            ->dehydrated(),

                        Forms\Components\ToggleButtons::make('status_id')
                            ->label('status')
                            ->options(Status::getStatuses())
                            ->inline()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('author.name')->searchable(),
                Tables\Columns\TextColumn::make('deadline')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->color(function ($state) {
                        $diff = now()->diffInMinutes(Carbon::parse($state), $absolute = false);
                        if ($diff <= 1440) {
                            return 'danget';
                        }
                        return '';
                    }),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        TaskType::FEATURE->value => TaskType::FEATURE->color(),
                        TaskType::BUG->value => TaskType::BUG->color(),
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        TaskType::FEATURE->value => 'heroicon-o-face-smile',
                        TaskType::BUG->value => 'heroicon-o-bug-ant',
                    }),
                Tables\Columns\TextColumn::make('status.title')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        StatusTitle::OPEN->value => StatusTitle::OPEN->color(),
                        StatusTitle::IN_PROGRESS->value => StatusTitle::IN_PROGRESS->color(),
                        StatusTitle::FROZEN->value => StatusTitle::FROZEN->color(),
                        StatusTitle::REVIEW->value => StatusTitle::REVIEW->color(),
                        StatusTitle::DONE->value => StatusTitle::DONE->color(),
                    }),

                SpatieMediaLibraryImageColumn::make('image'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable(),
            ])
            ->defaultSort('order', 'des')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('status_id')
                    ->label('Asset type')
                    ->relationship('status', 'title'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
            'view' => Pages\ViewTask::route('/{record}/view'),
        ];
    }
}
