<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContributionResource\Pages;
use App\Models\Contribution;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ContributionResource extends Resource
{
    protected static ?string $model = Contribution::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'مراجعة المساهمات';

    protected static ?string $modelLabel = 'مساهمة';

    protected static ?string $pluralModelLabel = 'المساهمات';

    protected static string|\UnitEnum|null $navigationGroup = 'الدليل الوطني';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المساهمة')
                    ->schema([
                        Forms\Components\TextInput::make('contributor_name')
                            ->label('اسم المساهم')
                            ->required(),
                        Forms\Components\TextInput::make('contributor_email')
                            ->label('البريد الإلكتروني')
                            ->email(),
                        Forms\Components\TextInput::make('contributor_phone')
                            ->label('الهاتف'),
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
                            ->required(),
                        Forms\Components\Textarea::make('review_notes')
                            ->label('ملاحظات المراجع')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('contributor_name')
                    ->label('المساهم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state.name_ar')
                    ->label('الولاية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name_ar')
                    ->label('التصنيف')
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'warning' => Contribution::STATUS_PENDING,
                        'success' => Contribution::STATUS_APPROVED,
                        'danger' => Contribution::STATUS_REJECTED,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Contribution::STATUS_PENDING => 'بانتظار المراجعة',
                        Contribution::STATUS_APPROVED => 'معتمد',
                        Contribution::STATUS_REJECTED => 'مرفوض',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('وقت الإرسال')
                    ->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        Contribution::STATUS_PENDING => 'بانتظار المراجعة',
                        Contribution::STATUS_APPROVED => 'معتمد',
                        Contribution::STATUS_REJECTED => 'مرفوض',
                    ]),
                Tables\Filters\SelectFilter::make('state')
                    ->label('الولاية')
                    ->relationship('state', 'name_ar'),
            ])
            ->actions([
                Action::make('approve_and_publish')
                    ->label('اعتماد ونشر')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->hidden(fn (Contribution $record): bool => $record->status === Contribution::STATUS_APPROVED)
                    ->action(function (Contribution $record): void {
                        $record->publishToOfficialEntry(auth()->user());

                        Notification::make()
                            ->title('تم اعتماد المساهمة')
                            ->body('تم تحويل المساهمة إلى محتوى رسمي بنجاح.')
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListContributions::route('/'),
            'create' => Pages\CreateContribution::route('/create'),
            'edit' => Pages\EditContribution::route('/{record}/edit'),
        ];
    }
}
