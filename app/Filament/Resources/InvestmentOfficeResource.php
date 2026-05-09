<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvestmentOfficeResource\Pages;
use App\Models\InvestmentOffice;
use App\Support\FeatureTableGuard;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class InvestmentOfficeResource extends Resource
{
    protected static ?string $model = InvestmentOffice::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'جهات الاستثمار';

    protected static ?string $modelLabel = 'جهة استثمار';

    protected static ?string $pluralModelLabel = 'جهات الاستثمار';

    protected static string|\UnitEnum|null $navigationGroup = 'الاستثمار والهوية';

    public static function canAccess(): bool
    {
        return FeatureTableGuard::hasTables(static::getRequiredTables()) && parent::canAccess();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return FeatureTableGuard::hasTables(static::getRequiredTables()) && parent::shouldRegisterNavigation();
    }

    protected static function getRequiredTables(): array
    {
        return ['investment_offices', 'states'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الجهة')
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
                        Forms\Components\TextInput::make('name_fr')
                            ->label('الاسم بالفرنسية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط المختصر')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description_ar')
                            ->label('الوصف بالعربية')
                            ->rows(3),
                        Forms\Components\Textarea::make('description_en')
                            ->label('الوصف بالإنجليزية')
                            ->rows(3),
                        Forms\Components\Textarea::make('description_fr')
                            ->label('الوصف بالفرنسية')
                            ->rows(3),
                        Forms\Components\TextInput::make('contact_name')
                            ->label('اسم جهة الاتصال')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email(),
                        Forms\Components\TextInput::make('phone')
                            ->label('الهاتف'),
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('واتساب'),
                        Forms\Components\TextInput::make('address_ar')
                            ->label('العنوان بالعربية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address_en')
                            ->label('العنوان بالإنجليزية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address_fr')
                            ->label('العنوان بالفرنسية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('website_url')
                            ->label('الموقع الإلكتروني')
                            ->url(),
                        Forms\Components\TextInput::make('working_hours')
                            ->label('ساعات العمل')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشطة')
                            ->default(true),
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
                    ->label('الجهة')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name_ar')
                    ->label('الولاية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact_name')
                    ->label('التواصل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشطة')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->label('الولاية')
                    ->relationship('state', 'name_ar'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة'),
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
            'index' => Pages\ListInvestmentOffices::route('/'),
            'create' => Pages\CreateInvestmentOffice::route('/create'),
            'edit' => Pages\EditInvestmentOffice::route('/{record}/edit'),
        ];
    }
}
