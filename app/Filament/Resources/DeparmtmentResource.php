<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeparmtmentResource\Pages;
use App\Filament\Resources\DeparmtmentResource\RelationManagers;
use App\Models\Deparmtment;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeparmtmentResource extends Resource
{
    protected static ?string $model = Deparmtment::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'System Settings';
    protected static ?string $navigationLabel = 'Department';
    protected static ?string $modelLab = 'Departments';
    protected static ?int $navigationSort = 4;


    public static function getNavigationBadge(): string{
        return (string) Deparmtment::count();
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'warning'; 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('employees_count')
                    ->counts('employees')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public  static function Infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('State Details')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Department Name'),
                        TextEntry::make('employees_count')
                        ->state(function (Model $record) {
                            return $record->employees->count();
                        })
                        
                    ])->columns(2)
                   
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
            'index' => Pages\ListDeparmtments::route('/'),
            'create' => Pages\CreateDeparmtment::route('/create'),
            'view' => Pages\ViewDeparmtment::route('/{record}'),
            'edit' => Pages\EditDeparmtment::route('/{record}/edit'),
        ];
    }
}
