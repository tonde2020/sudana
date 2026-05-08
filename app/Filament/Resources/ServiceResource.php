<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Entry;
use App\Models\Service;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'الخدمات والأرقام';

    protected static ?string $modelLabel = 'خدمة';

    protected static ?string $pluralModelLabel = 'الخدمات والأرقام';

    protected static string|\UnitEnum|null $navigationGroup = 'الدليل الوطني';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الخدمة')
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
                            ->preload(),
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الخدمة')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('service_type')
                            ->label('نوع الخدمة')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone_primary')
                            ->label('الهاتف الأساسي')
                            ->tel(),
                        Forms\Components\TextInput::make('phone_secondary')
                            ->label('هاتف إضافي')
                            ->tel(),
                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email(),
                        Forms\Components\TextInput::make('address')
                            ->label('العنوان')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('map_url')
                            ->label('رابط الخريطة')
                            ->url(),
                        Forms\Components\Textarea::make('description')
                            ->label('الوصف')
                            ->rows(3)
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
                Tables\Columns\TextColumn::make('name')
                    ->label('الخدمة')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('state.name_ar')
                    ->label('الولاية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('locality.name_ar')
                    ->label('المحلية')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('service_type')
                    ->label('النوع')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone_primary')
                    ->label('الهاتف')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'gray' => Entry::STATUS_DRAFT,
                        'warning' => Entry::STATUS_PENDING_REVIEW,
                        'success' => Entry::STATUS_PUBLISHED,
                        'danger' => Entry::STATUS_REJECTED,
                    ]),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
