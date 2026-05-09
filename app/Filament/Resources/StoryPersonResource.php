<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryPersonResource\Pages;
use App\Models\StoryPerson;
use App\Support\FeatureTableGuard;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class StoryPersonResource extends Resource
{
    protected static ?string $model = StoryPerson::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'شخصيات محلية';

    protected static ?string $modelLabel = 'شخصية';

    protected static ?string $pluralModelLabel = 'شخصيات محلية';

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
        return ['story_people', 'states', 'localities', 'users'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الشخصية')
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
                        Forms\Components\Select::make('reviewer_id')
                            ->label('المراجع')
                            ->relationship('reviewer', 'name')
                            ->searchable()
                            ->preload(),
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
                        Forms\Components\TextInput::make('headline_ar')
                            ->label('الوصف القصير بالعربية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('headline_en')
                            ->label('الوصف القصير بالإنجليزية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('headline_fr')
                            ->label('الوصف القصير بالفرنسية')
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('bio_ar')
                            ->label('السيرة بالعربية')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('bio_en')
                            ->label('السيرة بالإنجليزية')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('bio_fr')
                            ->label('السيرة بالفرنسية')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image_path')
                            ->label('الصورة')
                            ->disk('public')
                            ->directory('stories/people')
                            ->image()
                            ->imageEditor(),
                        Forms\Components\TextInput::make('birth_year')
                            ->label('سنة الميلاد')
                            ->numeric(),
                        Forms\Components\TextInput::make('death_year')
                            ->label('سنة الوفاة')
                            ->numeric(),
                        Forms\Components\TextInput::make('source_name')
                            ->label('اسم المصدر')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('source_url')
                            ->label('رابط المصدر')
                            ->url(),
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options(StoryResource::statusOptions())
                            ->required()
                            ->default(StoryPerson::STATUS_DRAFT),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('شخصية مميزة')
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
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('الشخصية')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name_ar')
                    ->label('الولاية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('locality.name_ar')
                    ->label('المحلية')
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'gray' => StoryPerson::STATUS_DRAFT,
                        'warning' => StoryPerson::STATUS_PENDING_REVIEW,
                        'success' => StoryPerson::STATUS_PUBLISHED,
                        'danger' => StoryPerson::STATUS_REJECTED,
                    ])
                    ->formatStateUsing(fn (string $state): string => StoryResource::statusOptions()[$state] ?? $state),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميزة')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->label('الولاية')
                    ->relationship('state', 'name_ar'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(StoryResource::statusOptions()),
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
            'index' => Pages\ListStoryPeople::route('/'),
            'create' => Pages\CreateStoryPerson::route('/create'),
            'edit' => Pages\EditStoryPerson::route('/{record}/edit'),
        ];
    }
}
