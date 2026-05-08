<?php

namespace App\Filament\Resources\LocalityResource\RelationManagers;

use App\Models\Contribution;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ContributionsRelationManager extends RelationManager
{
    protected static string $relationship = 'contributions';

    protected static ?string $title = 'مساهمات المحلية';

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
                Forms\Components\TextInput::make('contributor_name')
                    ->label('اسم المساهم')
                    ->required(),
                Forms\Components\TextInput::make('contributor_email')
                    ->label('البريد الإلكتروني')
                    ->email(),
                Forms\Components\TextInput::make('contributor_phone')
                    ->label('الهاتف'),
                Forms\Components\Select::make('category_id')
                    ->label('التصنيف')
                    ->relationship('category', 'name_ar')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('title')
                    ->label('العنوان')
                    ->required(),
                Forms\Components\RichEditor::make('content')
                    ->label('المحتوى')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options([
                        Contribution::STATUS_PENDING => 'بانتظار المراجعة',
                        Contribution::STATUS_APPROVED => 'معتمد',
                        Contribution::STATUS_REJECTED => 'مرفوض',
                    ])
                    ->default(Contribution::STATUS_PENDING)
                    ->required(),
                Forms\Components\Textarea::make('review_notes')
                    ->label('ملاحظات المراجعة')
                    ->rows(3)
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('contributor_name')
                    ->label('المساهم'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                Action::make('approve_and_publish')
                    ->label('اعتماد ونشر')
                    ->color('success')
                    ->visible(fn (Contribution $record) => $record->status !== Contribution::STATUS_APPROVED)
                    ->action(function (Contribution $record): void {
                        $record->publishToOfficialEntry(auth()->user());

                        Notification::make()
                            ->title('تم اعتماد المساهمة')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
