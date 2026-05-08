<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VirtualTourResource\Pages;
use App\Models\VirtualTour;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class VirtualTourResource extends Resource
{
    protected static ?string $model = VirtualTour::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'الجولات الافتراضية';

    protected static ?string $modelLabel = 'جولة افتراضية';

    protected static ?string $pluralModelLabel = 'الجولات الافتراضية';

    protected static string|\UnitEnum|null $navigationGroup = 'الدليل الوطني';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الجولة')
                    ->schema([
                        Forms\Components\Select::make('state_id')
                            ->label('الولاية')
                            ->relationship('state', 'name_ar')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('locality_id')
                            ->label('المحلية')
                            ->relationship('locality', 'name_ar')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('entry_id')
                            ->label('المرجع المرتبط')
                            ->relationship('entry', 'title')
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
                            ->label('وصف قصير')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('panorama_path')
                            ->label('صورة الجولة 360°')
                            ->disk('public')
                            ->directory('virtual-tours')
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->maxSize(10240)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('preview_image_path')
                            ->label('صورة الغلاف')
                            ->disk('public')
                            ->directory('virtual-tours/previews')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('meta')
                            ->label('بيانات إضافية')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options([
                                VirtualTour::STATUS_DRAFT => 'مسودة',
                                VirtualTour::STATUS_PUBLISHED => 'منشورة',
                                VirtualTour::STATUS_ARCHIVED => 'مؤرشفة',
                            ])
                            ->default(VirtualTour::STATUS_DRAFT)
                            ->required(),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('جولة مميزة')
                            ->default(false),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->numeric()
                            ->default(0),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('وقت النشر'),
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
                    ->limit(40),
                Tables\Columns\TextColumn::make('state.name_ar')
                    ->label('الولاية')
                    ->placeholder('غير محددة'),
                Tables\Columns\TextColumn::make('locality.name_ar')
                    ->label('المحلية')
                    ->placeholder('على مستوى الولاية')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميزة')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->label('الولاية')
                    ->relationship('state', 'name_ar'),
                Tables\Filters\SelectFilter::make('locality')
                    ->label('المحلية')
                    ->relationship('locality', 'name_ar'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        VirtualTour::STATUS_DRAFT => 'مسودة',
                        VirtualTour::STATUS_PUBLISHED => 'منشورة',
                        VirtualTour::STATUS_ARCHIVED => 'مؤرشفة',
                    ]),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVirtualTours::route('/'),
            'create' => Pages\CreateVirtualTour::route('/create'),
            'edit' => Pages\EditVirtualTour::route('/{record}/edit'),
        ];
    }
}
