<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'المتطوعون والمستخدمون';

    protected static ?string $modelLabel = 'مستخدم';

    protected static ?string $pluralModelLabel = 'المستخدمون';

    protected static string|\UnitEnum|null $navigationGroup = 'الدليل الوطني';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المستخدم')
                    ->schema([
                        TextInput::make('name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('phone')
                            ->label('الهاتف')
                            ->maxLength(30),
                        TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->revealable()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),
                        Select::make('state_id')
                            ->label('الولاية')
                            ->relationship('state', 'name_ar')
                            ->searchable()
                            ->preload(),
                        Select::make('role')
                            ->label('الدور')
                            ->options([
                                'citizen' => 'مستخدم',
                                'ambassador' => 'مساهم',
                                'moderator' => 'مراجع',
                                'admin' => 'إدارة',
                            ])
                            ->required(),
                        Select::make('application_status')
                            ->label('حالة الطلب')
                            ->options([
                                'pending' => 'بانتظار المراجعة',
                                'approved' => 'معتمد',
                                'rejected' => 'مرفوض',
                            ])
                            ->required(),
                        CheckboxList::make('volunteer_skills')
                            ->label('مجالات المساهمة')
                            ->options([
                                'history' => 'التاريخ والآثار',
                                'photography' => 'التصوير والجولات 360',
                                'investment' => 'فرص الاستثمار',
                                'services' => 'دليل الخدمات',
                                'culture' => 'الثقافة والشخصيات',
                                'community' => 'التنسيق المجتمعي',
                            ])
                            ->columns(2),
                        Textarea::make('bio')
                            ->label('نبذة أو دافع المساهمة')
                            ->rows(5)
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
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('البريد')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('الهاتف')->toggleable(),
                Tables\Columns\TextColumn::make('state.name_ar')->label('الولاية')->placeholder('غير محددة'),
                Tables\Columns\TextColumn::make('role')->label('الدور')->badge(),
                Tables\Columns\TextColumn::make('volunteer_skills')
                    ->label('مجالات المساهمة')
                    ->formatStateUsing(function ($state): string {
                        if (! is_array($state) || $state === []) {
                            return 'غير محددة';
                        }

                        $labels = [
                            'history' => 'التاريخ والآثار',
                            'photography' => 'التصوير والجولات 360',
                            'investment' => 'فرص الاستثمار',
                            'services' => 'دليل الخدمات',
                            'culture' => 'الثقافة والشخصيات',
                            'community' => 'التنسيق المجتمعي',
                        ];

                        return collect($state)
                            ->map(fn (string $item) => $labels[$item] ?? $item)
                            ->implode('، ');
                    })
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('application_status')
                    ->label('الحالة')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\IconColumn::make('is_active')->label('نشط')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('application_status')
                    ->label('حالة الطلب')
                    ->options([
                        'pending' => 'بانتظار المراجعة',
                        'approved' => 'معتمد',
                        'rejected' => 'مرفوض',
                    ]),
                Tables\Filters\SelectFilter::make('role')
                    ->label('الدور')
                    ->options([
                        'citizen' => 'مستخدم',
                        'ambassador' => 'مساهم',
                        'moderator' => 'مراجع',
                        'admin' => 'إدارة',
                    ]),
            ])
            ->actions([
                Action::make('approve')
                    ->label('اعتماد')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (User $record) => $record->application_status !== 'approved')
                    ->action(fn (User $record) => $record->update([
                        'application_status' => 'approved',
                        'is_active' => true,
                        'role' => $record->role ?: 'ambassador',
                    ])),
                Action::make('reject')
                    ->label('رفض')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (User $record) => $record->application_status !== 'rejected')
                    ->action(fn (User $record) => $record->update([
                        'application_status' => 'rejected',
                        'is_active' => false,
                    ])),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
