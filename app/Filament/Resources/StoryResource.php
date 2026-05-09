<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryResource\Pages;
use App\Models\Story;
use App\Support\FeatureTableGuard;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class StoryResource extends Resource
{
    protected static ?string $model = Story::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'الحكايات والنوادر';

    protected static ?string $modelLabel = 'مادة سردية';

    protected static ?string $pluralModelLabel = 'الحكايات والنوادر';

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
        return ['stories', 'story_people', 'states', 'localities', 'users'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('الربط والتصنيف')
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
                        Forms\Components\Select::make('story_person_id')
                            ->label('الشخصية المرتبطة')
                            ->relationship('person', 'name_ar')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('reviewer_id')
                            ->label('المراجع')
                            ->relationship('reviewer', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('story_type')
                            ->label('نوع المادة')
                            ->options(self::storyTypeOptions())
                            ->required()
                            ->default(Story::TYPE_STORY),
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
                        Forms\Components\RichEditor::make('content_ar')
                            ->label('النص بالعربية')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('content_en')
                            ->label('النص بالإنجليزية')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('content_fr')
                            ->label('النص بالفرنسية')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('interpretation_ar')
                            ->label('الشرح بالعربية')
                            ->rows(3),
                        Forms\Components\Textarea::make('interpretation_en')
                            ->label('الشرح بالإنجليزية')
                            ->rows(3),
                        Forms\Components\Textarea::make('interpretation_fr')
                            ->label('الشرح بالفرنسية')
                            ->rows(3),
                    ])
                    ->columns([
                        'sm' => 1,
                        'xl' => 3,
                    ]),
                Section::make('المصدر والنشر')
                    ->schema([
                        Forms\Components\TextInput::make('narrator_name')
                            ->label('اسم الراوي')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('source_name')
                            ->label('اسم المصدر')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('source_url')
                            ->label('رابط المصدر')
                            ->url(),
                        Forms\Components\FileUpload::make('audio_path')
                            ->label('ملف صوتي')
                            ->disk('public')
                            ->directory('stories/audio'),
                        Forms\Components\FileUpload::make('image_path')
                            ->label('صورة')
                            ->disk('public')
                            ->directory('stories/images')
                            ->image()
                            ->imageEditor(),
                        Forms\Components\TextInput::make('audience_age_group')
                            ->label('الفئة العمرية')
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options(self::statusOptions())
                            ->required()
                            ->default(Story::STATUS_DRAFT),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('مادة مميزة')
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
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('story_type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => self::storyTypeOptions()[$state] ?? $state),
                Tables\Columns\TextColumn::make('state.name_ar')
                    ->label('الولاية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('person.name_ar')
                    ->label('الشخصية')
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'gray' => Story::STATUS_DRAFT,
                        'warning' => Story::STATUS_PENDING_REVIEW,
                        'success' => Story::STATUS_PUBLISHED,
                        'danger' => Story::STATUS_REJECTED,
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
                Tables\Filters\SelectFilter::make('story_type')
                    ->label('النوع')
                    ->options(self::storyTypeOptions()),
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
            'index' => Pages\ListStories::route('/'),
            'create' => Pages\CreateStory::route('/create'),
            'edit' => Pages\EditStory::route('/{record}/edit'),
        ];
    }

    public static function storyTypeOptions(): array
    {
        return [
            Story::TYPE_STORY => 'حكاية',
            Story::TYPE_ANECDOTE => 'نادرة',
            Story::TYPE_RIDDLE => 'أحجية',
            Story::TYPE_PROVERB => 'مثل',
            Story::TYPE_BIOGRAPHY => 'سيرة',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            Story::STATUS_DRAFT => 'مسودة',
            Story::STATUS_PENDING_REVIEW => 'بانتظار المراجعة',
            Story::STATUS_PUBLISHED => 'منشور',
            Story::STATUS_REJECTED => 'مرفوض',
            Story::STATUS_ARCHIVED => 'مؤرشف',
        ];
    }
}
