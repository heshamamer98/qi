<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->rows(3),

                Forms\Components\Select::make('task_id')
                    ->required()
                    ->relationship('task', 'title'),

                Forms\Components\Select::make('author_id')
                    ->label('Created by')
                    ->required()
                    ->relationship('author', 'name')
                    ->disabled()
                    ->default(auth()->user()->id)
                    ->dehydrated(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author.name')->searchable(),
                Tables\Columns\TextColumn::make('content')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('task.title')->searchable()->limit(20),
                Tables\Columns\TextColumn::make('created_at')->searchable()->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('task_id')
                    ->label('Task')
                    ->relationship('task', 'title'),

                Tables\Filters\SelectFilter::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
