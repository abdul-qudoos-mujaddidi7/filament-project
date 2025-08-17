<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\City;
use App\Models\Employee;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Employee Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                ->description('Please Enter your details')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                    ->required(),
                Forms\Components\TextInput::make('last_name')
                    ->required(),
               
                    ])->columns(2),
                    Forms\Components\Section::make('Address Information')
                    ->description('Please Enter your address details')
                    ->schema([
                        Forms\Components\TextInput::make('adress')
                            ->required(),
                       
                    ]),

                    Forms\Components\Section::make('Employment Details')
                    ->description('Please Enter your employment details')
                    ->schema([
                        Forms\Components\DatePicker::make('birth_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('m-d-Y'),
                        Forms\Components\DatePicker::make('hire_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('m-d-Y'),
                    ])->columns(2),

                    Forms\Components\Section::make('Department and Location')
                    ->description('Please select your department and location')
                    ->schema([
                        Forms\Components\Select::make('country_id')
    ->relationship('country', 'name')
    ->required()
    ->searchable()
    ->preload()
    ->live()
    ->afterStateUpdated(function (Set $set) {
        $set('state_id', null);
        $set('city_id', null);
    })
    ->native(true),

Forms\Components\Select::make('state_id')
    ->options(fn (Get $get) => 
        $get('country_id')
            ? State::query()
                ->where('country_id', $get('country_id'))
                ->pluck('name', 'id')
                ->toArray()
            : []
    )
    ->live()
    ->afterStateUpdated(fn (Set $set) => $set('city_id', null)) // reset only city when state changes
    ->required()
    ->searchable()
    ->preload()
    ->native(true),

Forms\Components\Select::make('city_id')
    ->options(fn (Get $get) => 
        $get('state_id')
            ? City::query()
                ->where('state_id', $get('state_id'))
                ->pluck('name', 'id')
                ->toArray()
            : []
    )
    ->live()
    ->required()
    ->searchable()
    ->preload()
    ->native(true),
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(true),
                       
                       
                        
                    ])->columns(2),
              
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('adress')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hire_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country_id')
                    ->numeric()
                    ->sortable(),
               
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
