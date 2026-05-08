<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StateResource\RelationManagers\VirtualToursRelationManager;
use App\Filament\Resources\StateResource\Pages;
use App\Models\State;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'الولايات';

    protected static ?string $modelLabel = 'ولاية';

    protected static ?string $pluralModelLabel = 'الولايات';

    protected static string|\UnitEnum|null $navigationGroup = 'الدليل الوطني';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الولاية')
                    ->schema([
                        Forms\Components\TextInput::make('name_ar')
                            ->label('الاسم بالعربية')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name_en')
                            ->label('الاسم بالإنجليزية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط المختصر')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('capital')
                            ->label('العاصمة')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('summary')
                            ->label('نبذة مختصرة')
                            ->rows(3),
                        Forms\Components\RichEditor::make('history')
                            ->label('التاريخ والسرد')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('منشورة للعامة')
                            ->default(false),
                    ])
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('الولاية')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capital')
                    ->label('العاصمة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('localities_count')
                    ->label('عدد المحليات')
                    ->counts('localities'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشورة')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->since(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('حالة النشر'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            VirtualToursRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }
}
