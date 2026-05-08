<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocalityResource\RelationManagers\ContributionsRelationManager;
use App\Filament\Resources\LocalityResource\RelationManagers\HighlightsRelationManager;
use App\Filament\Resources\LocalityResource\RelationManagers\InvestmentRelationManager;
use App\Filament\Resources\LocalityResource\Pages;
use App\Filament\Resources\LocalityResource\RelationManagers\ServicesRelationManager;
use App\Filament\Resources\LocalityResource\RelationManagers\VirtualToursRelationManager;
use App\Models\Locality;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class LocalityResource extends Resource
{
    protected static ?string $model = Locality::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'المحليات';

    protected static ?string $modelLabel = 'محلية';

    protected static ?string $pluralModelLabel = 'المحليات';

    protected static string|\UnitEnum|null $navigationGroup = 'الدليل الوطني';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المحلية')
                    ->schema([
                        Forms\Components\Select::make('state_id')
                            ->label('الولاية')
                            ->relationship('state', 'name_ar')
                            ->searchable()
                            ->preload()
                            ->required(),
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
                            ->maxLength(255),
                        Forms\Components\TextInput::make('population_estimate')
                            ->label('تقدير السكان')
                            ->numeric(),
                        Forms\Components\TextInput::make('area_km2')
                            ->label('المساحة بالكيلومتر')
                            ->numeric(),
                        Forms\Components\Textarea::make('summary')
                            ->label('نبذة مختصرة')
                            ->rows(3),
                        Forms\Components\RichEditor::make('description')
                            ->label('الوصف الكامل')
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('editorial_note')
                            ->label('إدارة محتوى المحلية')
                            ->content('بعد حفظ البيانات الأساسية، استخدم الأقسام أسفل الصفحة لإضافة المعالم والشخصيات وفرص الاستثمار والخدمات والمساهمات المرتبطة بهذه المحلية.')
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

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('محتوى المحلية', [
                HighlightsRelationManager::class,
                InvestmentRelationManager::class,
                VirtualToursRelationManager::class,
                ServicesRelationManager::class,
                ContributionsRelationManager::class,
            ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('المحلية')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name_ar')
                    ->label('الولاية')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('population_estimate')
                    ->label('السكان')
                    ->numeric(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشورة')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->label('الولاية')
                    ->relationship('state', 'name_ar'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocalities::route('/'),
            'create' => Pages\CreateLocality::route('/create'),
            'edit' => Pages\EditLocality::route('/{record}/edit'),
        ];
    }
}
