<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\EmployeeResource\Pages;
use App\Filament\App\Resources\EmployeeResource\RelationManagers;
use App\Models\City;
use App\Models\Employee;
use App\Models\State;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                            ->relationship('deparmtment', 
                            'name',
                            modifyQueryUsing:fn(Builder $query)=>$query->whereBelongsTo(Filament::getTenant()))
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
                TextColumn::make("country.name")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('adress')
                    ->searchable(),
                    
               
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('hire_date')
                    ->date()
                    ->sortable()
                    
            ])
            ->filters([
                SelectFilter::make("Filter By Department")
                    ->relationship('deparmtment', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->indicator('Department'),
                    Filter::make('created_at')
                    ->form([
                    DatePicker::make('created_from')->native(false),
                    DatePicker::make('created_until')->native(false),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })//->columnSpan(2)->columns(2)
            ])//layout:FiltersLayout::AboveContent)->filtersFormColumns(3)
            
            ->actions([
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
                Section::make('USer Details')
                    ->schema([
                        TextEntry::make('first_name')
                            ->label('First Name'),
                        TextEntry::make('last_name')
                            ->label('Last Name'),
                    ])->columns(2),
                Section::make('Address Details')
                    ->schema([

                        TextEntry::make('adress')
                            ->label('Address'),
                    ]),
                Section::make('Employment Details')
                    ->schema([

                        TextEntry::make('birth_date')
                            ->label('Birth Date'),
                        TextEntry::make('hire_date')
                            ->label('Hire Date'),
                    ])->columns(2),
                Section::make('Department and Location')
                    ->schema([
                        TextEntry::make('country.name')
                            ->label('Country'),
                        TextEntry::make('state.name')
                            ->label('State'),
                        TextEntry::make('city.name')
                            ->label('City'),
                        TextEntry::make('deparmtment.name')
                            ->label('Department'),
                    ])->columns(2),
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
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
