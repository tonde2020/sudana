<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntryResource\Pages;
use App\Models\Entry;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class EntryResource extends Resource
{
    protected static ?string $model = Entry::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'المحتوى الرسمي';

    protected static ?string $modelLabel = 'محتوى';

    protected static ?string $pluralModelLabel = 'المحتوى الرسمي';

    protected static string|\UnitEnum|null $navigationGroup = 'الدليل الوطني';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المحتوى')
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
                            ->label('التصنيف')
                            ->relationship('category', 'name_ar')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('author_id')
                            ->label('الكاتب/المدخل')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط المختصر')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('excerpt')
                            ->label('ملخص قصير')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('content')
                            ->label('المحتوى')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('panorama_path')
                            ->label('صورة الجولة الافتراضية (360°)')
                            ->disk('public')
                            ->directory('virtual-tours')
                            ->image()
                            ->imageEditor()
                            ->helperText('ارفع صورة بانورامية بنسبة 2:1 لتفعيل المشهد التفاعلي.')
                            ->maxSize(10240)
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('meta')
                            ->label('بيانات إضافية')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options([
                                Entry::STATUS_DRAFT => 'مسودة',
                                Entry::STATUS_PENDING_REVIEW => 'بانتظار المراجعة',
                                Entry::STATUS_PUBLISHED => 'منشور',
                                Entry::STATUS_REJECTED => 'مرفوض',
                            ])
                            ->required()
                            ->default(Entry::STATUS_DRAFT),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('محتوى مميز')
                            ->default(false),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('تاريخ النشر'),
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
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->limit(45),
                Tables\Columns\TextColumn::make('state.name_ar')
                    ->label('الولاية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name_ar')
                    ->label('التصنيف')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'gray' => Entry::STATUS_DRAFT,
                        'warning' => Entry::STATUS_PENDING_REVIEW,
                        'success' => Entry::STATUS_PUBLISHED,
                        'danger' => Entry::STATUS_REJECTED,
                    ]),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean(),
                Tables\Columns\IconColumn::make('panorama_path')
                    ->label('360')
                    ->boolean()
                    ->getStateUsing(fn (Entry $record): bool => filled($record->panorama_path)),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('النشر')
                    ->dateTime('Y-m-d H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->label('الولاية')
                    ->relationship('state', 'name_ar'),
                Tables\Filters\SelectFilter::make('category')
                    ->label('التصنيف')
                    ->relationship('category', 'name_ar'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        Entry::STATUS_DRAFT => 'مسودة',
                        Entry::STATUS_PENDING_REVIEW => 'بانتظار المراجعة',
                        Entry::STATUS_PUBLISHED => 'منشور',
                        Entry::STATUS_REJECTED => 'مرفوض',
                    ]),
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
            'index' => Pages\ListEntries::route('/'),
            'create' => Pages\CreateEntry::route('/create'),
            'edit' => Pages\EditEntry::route('/{record}/edit'),
        ];
    }
}
