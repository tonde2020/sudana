<?php

namespace App\Filament\Resources\LocalityResource\RelationManagers;

use App\Models\Category;
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
use Illuminate\Database\Eloquent\Builder;

class HighlightsRelationManager extends RelationManager
{
    protected static string $relationship = 'entries';

    protected static ?string $title = 'التعريف والمعالم والشخصيات';

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
                    ->label('نوع المحتوى')
                    ->options(fn () => Category::query()
                        ->whereIn('slug', ['history', 'landmarks', 'notable-figures'])
                        ->pluck('name_ar', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('العنوان')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label('الرابط المختصر')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('excerpt')
                    ->label('ملخص قصير')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label('المحتوى')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('panorama_path')
                    ->label('صورة الجولة الافتراضية 360°')
                    ->disk('public')
                    ->directory('virtual-tours')
                    ->image()
                    ->imageEditor()
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
                    ->default(Entry::STATUS_DRAFT)
                    ->required(),
                Forms\Components\Toggle::make('is_featured')
                    ->label('محتوى مميز')
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
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->whereIn('slug', ['history', 'landmarks', 'notable-figures']))
                ->with('category'))
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('category.name_ar')
                    ->label('القسم')
                    ->badge(),
                Tables\Columns\IconColumn::make('panorama_path')
                    ->label('360')
                    ->boolean()
                    ->getStateUsing(fn (Entry $record): bool => filled($record->panorama_path)),
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
