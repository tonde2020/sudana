<?php

namespace App\Filament\Resources\LocalityResource\RelationManagers;

use App\Models\Entry;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'services';

    protected static ?string $title = 'الخدمات والجمعيات';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Hidden::make('state_id')
                    ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->state_id)
                    ->dehydrated(),
                Forms\Components\Hidden::make('locality_id')
                    ->default(fn (RelationManager $livewire) => $livewire->getOwnerRecord()->getKey())
                    ->dehydrated(),
                Forms\Components\Select::make('category_id')
                    ->label('التصنيف')
                    ->relationship('category', 'name_ar')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('اسم الخدمة أو الجهة')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('service_type')
                    ->label('النوع')
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
                    ->default(Entry::STATUS_DRAFT)
                    ->required(),
            ])
            ->columns([
                'sm' => 1,
                'xl' => 2,
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الجهة أو الخدمة')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('service_type')
                    ->label('النوع')
                    ->badge(),
                Tables\Columns\TextColumn::make('phone_primary')
                    ->label('الهاتف'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
