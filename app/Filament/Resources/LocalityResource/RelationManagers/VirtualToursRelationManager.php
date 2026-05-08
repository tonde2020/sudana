<?php

namespace App\Filament\Resources\LocalityResource\RelationManagers;

use App\Models\VirtualTour;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class VirtualToursRelationManager extends RelationManager
{
    protected static string $relationship = 'virtualTours';

    protected static ?string $title = 'جولات المحلية الافتراضية';

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
                Forms\Components\Select::make('entry_id')
                    ->label('المرجع المرتبط')
                    ->relationship('entry', 'title')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('title')
                    ->label('العنوان')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('الرابط المختصر')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('excerpt')
                    ->label('وصف قصير')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('panorama_path')
                    ->label('صورة الجولة 360°')
                    ->disk('public')
                    ->directory('virtual-tours')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('preview_image_path')
                    ->label('صورة الغلاف')
                    ->disk('public')
                    ->directory('virtual-tours/previews')
                    ->image()
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
            ])
            ->columns([
                'sm' => 1,
                'xl' => 2,
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('العنوان')->searchable()->limit(40),
                Tables\Columns\IconColumn::make('is_featured')->label('مميزة')->boolean(),
                Tables\Columns\TextColumn::make('status')->label('الحالة')->badge(),
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
