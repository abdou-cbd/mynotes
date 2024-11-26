<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotesResource\Pages;
use App\Filament\Resources\NotesResource\RelationManagers;
use App\Models\Notes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotesResource extends Resource
{
    protected static ?string $model = Notes::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('Title')->required(),
                MarkdownEditor::make('Note_content')
                    ->required()
                    ->disableToolbarButtons([
                        'link',
                        'strike',
                        'attachFiles',
                        'codeBlock',
                        'table'
                    ]),
                Hidden::make('user_id')
                    ->default(auth()->id()),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id'),
                TextColumn::make('Title')
                    ->searchable(),
                TextColumn::make('Note_content')
                    ->limit(80),

            ])
            ->filters([
                //
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNotes::route('/create'),
            'edit' => Pages\EditNotes::route('/{record}/edit'),
        ];
    }
}
