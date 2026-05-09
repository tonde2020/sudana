<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvestmentOpportunityResource\Pages;
use App\Models\InvestmentOpportunity;
use App\Support\FeatureTableGuard;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class InvestmentOpportunityResource extends Resource
{
    protected static ?string $model = InvestmentOpportunity::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'الفرص الاستثمارية';

    protected static ?string $modelLabel = 'فرصة استثمار';

    protected static ?string $pluralModelLabel = 'الفرص الاستثمارية';

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
        return ['investment_opportunities', 'investment_offices', 'states', 'localities', 'categories', 'users'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('الربط والهوية')
                    ->schema([
                        Forms\Components\Select::make('state_id')
                            ->label('الولاية')
                            ->relationship('state', 'name_ar')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('locality_id')
                            ->label('المحلية')
                            ->relationship('locality', 'name_ar')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('category_id')
                            ->label('القطاع/التصنيف')
                            ->relationship('category', 'name_ar')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('office_id')
                            ->label('جهة الاستثمار')
                            ->relationship('office', 'name_ar')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('reviewer_id')
                            ->label('المراجع')
                            ->relationship('reviewer', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط المختصر')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                    ]),
                Section::make('المحتوى متعدد اللغات')
                    ->schema([
                        Forms\Components\TextInput::make('title_ar')
                            ->label('العنوان بالعربية')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_en')
                            ->label('العنوان بالإنجليزية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_fr')
                            ->label('العنوان بالفرنسية')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('summary_ar')
                            ->label('الملخص بالعربية')
                            ->rows(3),
                        Forms\Components\Textarea::make('summary_en')
                            ->label('الملخص بالإنجليزية')
                            ->rows(3),
                        Forms\Components\Textarea::make('summary_fr')
                            ->label('الملخص بالفرنسية')
                            ->rows(3),
                        Forms\Components\RichEditor::make('description_ar')
                            ->label('الوصف بالعربية')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description_en')
                            ->label('الوصف بالإنجليزية')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description_fr')
                            ->label('الوصف بالفرنسية')
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'sm' => 1,
                        'xl' => 3,
                    ]),
                Section::make('تفاصيل الاستثمار')
                    ->schema([
                        Forms\Components\TextInput::make('investment_type')
                            ->label('نوع الاستثمار')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('readiness_status')
                            ->label('درجة الجاهزية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('capital_range')
                            ->label('نطاق رأس المال')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('expected_roi_notes')
                            ->label('ملاحظات العائد المتوقع')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('infrastructure_notes_ar')
                            ->label('البنية التحتية بالعربية')
                            ->rows(3),
                        Forms\Components\Textarea::make('infrastructure_notes_en')
                            ->label('البنية التحتية بالإنجليزية')
                            ->rows(3),
                        Forms\Components\Textarea::make('infrastructure_notes_fr')
                            ->label('البنية التحتية بالفرنسية')
                            ->rows(3),
                        Forms\Components\Textarea::make('incentives_ar')
                            ->label('الحوافز بالعربية')
                            ->rows(3),
                        Forms\Components\Textarea::make('incentives_en')
                            ->label('الحوافز بالإنجليزية')
                            ->rows(3),
                        Forms\Components\Textarea::make('incentives_fr')
                            ->label('الحوافز بالفرنسية')
                            ->rows(3),
                        Forms\Components\Textarea::make('risks_ar')
                            ->label('المخاطر بالعربية')
                            ->rows(3),
                        Forms\Components\Textarea::make('risks_en')
                            ->label('المخاطر بالإنجليزية')
                            ->rows(3),
                        Forms\Components\Textarea::make('risks_fr')
                            ->label('المخاطر بالفرنسية')
                            ->rows(3),
                    ])
                    ->columns([
                        'sm' => 1,
                        'xl' => 3,
                    ]),
                Section::make('الاتصال والنشر')
                    ->schema([
                        Forms\Components\TextInput::make('contact_name')
                            ->label('اسم التواصل')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_email')
                            ->label('البريد الإلكتروني')
                            ->email(),
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('الهاتف'),
                        Forms\Components\TextInput::make('contact_whatsapp')
                            ->label('واتساب'),
                        Forms\Components\TextInput::make('source_name')
                            ->label('اسم المصدر')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('source_url')
                            ->label('رابط المصدر')
                            ->url(),
                        Forms\Components\TextInput::make('latitude')
                            ->label('خط العرض')
                            ->numeric(),
                        Forms\Components\TextInput::make('longitude')
                            ->label('خط الطول')
                            ->numeric(),
                        Forms\Components\FileUpload::make('image_path')
                            ->label('صورة الفرصة')
                            ->disk('public')
                            ->directory('investment')
                            ->image()
                            ->imageEditor(),
                        Forms\Components\FileUpload::make('attachment_path')
                            ->label('ملف مرفق')
                            ->disk('public')
                            ->directory('investment')
                            ->downloadable(),
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options(self::statusOptions())
                            ->required()
                            ->default(InvestmentOpportunity::STATUS_DRAFT),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('فرصة مميزة')
                            ->default(false),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('تاريخ النشر'),
                        Forms\Components\DateTimePicker::make('verified_at')
                            ->label('تاريخ التحقق'),
                        Forms\Components\Textarea::make('review_notes')
                            ->label('ملاحظات المراجعة')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_ar')
                    ->label('الفرصة')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('state.name_ar')
                    ->label('الولاية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name_ar')
                    ->label('القطاع')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('office.name_ar')
                    ->label('الجهة')
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'gray' => InvestmentOpportunity::STATUS_DRAFT,
                        'warning' => InvestmentOpportunity::STATUS_PENDING_REVIEW,
                        'success' => InvestmentOpportunity::STATUS_PUBLISHED,
                        'danger' => InvestmentOpportunity::STATUS_REJECTED,
                    ])
                    ->formatStateUsing(fn (string $state): string => self::statusOptions()[$state] ?? $state),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميزة')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('النشر')
                    ->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->label('الولاية')
                    ->relationship('state', 'name_ar'),
                Tables\Filters\SelectFilter::make('category')
                    ->label('القطاع')
                    ->relationship('category', 'name_ar'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(self::statusOptions()),
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
            'index' => Pages\ListInvestmentOpportunities::route('/'),
            'create' => Pages\CreateInvestmentOpportunity::route('/create'),
            'edit' => Pages\EditInvestmentOpportunity::route('/{record}/edit'),
        ];
    }

    public static function statusOptions(): array
    {
        return [
            InvestmentOpportunity::STATUS_DRAFT => 'مسودة',
            InvestmentOpportunity::STATUS_PENDING_REVIEW => 'بانتظار المراجعة',
            InvestmentOpportunity::STATUS_PUBLISHED => 'منشور',
            InvestmentOpportunity::STATUS_REJECTED => 'مرفوض',
            InvestmentOpportunity::STATUS_ARCHIVED => 'مؤرشف',
        ];
    }
}
