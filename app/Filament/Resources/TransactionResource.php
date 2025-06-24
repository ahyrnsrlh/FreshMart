<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = 'Pesanan';
    
    protected static ?string $modelLabel = 'Pesanan';
    
    protected static ?string $pluralModelLabel = 'Pesanan';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([                Forms\Components\Section::make('Informasi Pelanggan')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Pelanggan')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
                    
                Forms\Components\Section::make('Informasi Produk')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Produk')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                              Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1),
                            
                        Forms\Components\TextInput::make('total_price')
                            ->label('Total Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                    ])->columns(3),
                    
                Forms\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Tertunda',
                                'paid' => 'Dibayar',
                                'failed' => 'Gagal',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->default('pending')
                            ->required(),
                            
                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'transfer_bank' => 'Transfer Bank',
                                'cash' => 'Bayar di Tempat',
                                'e_wallet' => 'E-Wallet',
                            ]),
                            
                        Forms\Components\DateTimePicker::make('payment_date')
                            ->label('Tanggal Pembayaran'),
                    ])->columns(3),
                    
                Forms\Components\Section::make('Status Pesanan')
                    ->schema([
                        Forms\Components\Select::make('order_status')
                            ->label('Status Pesanan')
                            ->options([
                                'pending' => 'Tertunda',
                                'confirmed' => 'Dikonfirmasi',
                                'processing' => 'Diproses',
                                'shipped' => 'Dikirim',
                                'delivered' => 'Diterima',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->default('pending')
                            ->required(),
                    ]),
                    
                Forms\Components\Section::make('Bukti Pembayaran & Catatan')
                    ->schema([
                        Forms\Components\FileUpload::make('payment_proof')
                            ->label('Bukti Pembayaran')
                            ->image()
                            ->directory('payment_proofs')
                            ->visibility('public')
                            ->downloadable(),
                            
                        Forms\Components\Textarea::make('payment_notes')
                            ->label('Catatan Pembayaran')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Pesanan')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->sortable()
                    ->searchable()
                    ->description(fn (Transaction $record): string => $record->user->email ?? ''),
                    
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->sortable()
                    ->searchable()
                    ->description(fn (Transaction $record): string => $record->product->category->name ?? ''),
                    
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->sortable()
                    ->alignCenter(),
                    
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold'),                Tables\Columns\TextColumn::make('payment_status')                    ->label('Pembayaran')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Tertunda',
                        'paid' => 'Dibayar',
                        'failed' => 'Gagal',
                        'cancelled' => 'Dibatalkan',
                        default => $state
                    })
                    ->badge()                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'cancelled' => 'danger',
                        default => 'gray'
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'paid' => 'heroicon-o-check-circle',
                        'failed' => 'heroicon-o-x-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle'
                    }),
                Tables\Columns\TextColumn::make('order_status')                    ->label('Status Pesanan')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Tertunda',
                        'confirmed' => 'Dikonfirmasi',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'delivered' => 'Diterima',
                        'cancelled' => 'Dibatalkan',
                        default => $state
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'processing' => 'primary',
                        'shipped' => 'secondary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray'
                    }),
                    
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'transfer_bank' => 'Transfer Bank',
                        'cash' => 'Bayar di Tempat',
                        'e_wallet' => 'E-Wallet',
                        default => 'Belum Dipilih',
                    })
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\IconColumn::make('payment_proof')
                    ->label('Bukti')
                    ->boolean()
                    ->trueIcon('heroicon-o-photo')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('danger'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pesanan')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Tanggal Bayar')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Belum Dibayar'),
            ])            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Tertunda',
                        'paid' => 'Dibayar',
                        'failed' => 'Gagal',
                        'cancelled' => 'Dibatalkan',
                    ]),
                    
                Tables\Filters\SelectFilter::make('order_status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Tertunda',
                        'confirmed' => 'Dikonfirmasi',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'delivered' => 'Diterima',
                        'cancelled' => 'Dibatalkan',
                    ]),
                    
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'transfer_bank' => 'Transfer Bank',
                        'cash' => 'Bayar di Tempat',
                        'e_wallet' => 'E-Wallet',
                    ]),
                    
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Pesanan Dari'),
                        DatePicker::make('created_until')
                            ->label('Pesanan Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                      Tables\Filters\TernaryFilter::make('has_payment_proof')
                    ->label('Ada Bukti Pembayaran')
                    ->nullable()
                    ->trueLabel('Dengan Bukti')
                    ->falseLabel('Tanpa Bukti')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('payment_proof'),
                        false: fn (Builder $query) => $query->whereNull('payment_proof'),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
                
                Tables\Actions\Action::make('view_payment_proof')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-o-photo')
                    ->color('info')
                    ->visible(fn (Transaction $record) => !empty($record->payment_proof))
                    ->url(fn (Transaction $record) => asset('storage/' . $record->payment_proof))
                    ->openUrlInNewTab(),
                  Tables\Actions\Action::make('confirm_payment')
                    ->label('Konfirmasi Pembayaran')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Transaction $record) => $record->payment_status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Catatan Admin (opsional)')
                            ->placeholder('Tambahkan catatan untuk pelanggan...')
                            ->rows(3),
                    ])                    ->action(function (Transaction $record, array $data) {
                        $record->update([
                            'payment_status' => 'paid',
                            'payment_date' => now(),
                            'order_status' => $record->order_status === 'pending' ? 'confirmed' : $record->order_status,
                            'payment_notes' => $data['admin_notes'] ?? null,
                        ]);
                        
                        // Kirim notifikasi ke user
                        $record->user->notify(new \App\Notifications\PaymentStatusNotification(
                            $record, 
                            'confirmed', 
                            $data['admin_notes'] ?? null
                        ));
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran Dikonfirmasi')
                            ->body("Pembayaran untuk pesanan #{$record->id} berhasil dikonfirmasi")
                            ->success()
                            ->send();
                    })
                    ->modalHeading('Konfirmasi Pembayaran')
                    ->modalDescription('Konfirmasi pembayaran akan mengubah status menjadi "Dibayar" dan pesanan akan diproses.')
                    ->modalWidth('md'),
                    
                Tables\Actions\Action::make('reject_payment')
                    ->label('Tolak Pembayaran')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Transaction $record) => $record->payment_status === 'pending')
                    ->form([                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->placeholder('Jelaskan alasan mengapa pembayaran ditolak...')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Transaction $record, array $data) {
                        // Kembalikan stok produk
                        $record->product->increment('stock', $record->quantity);
                        
                        $record->update([
                            'payment_status' => 'failed',
                            'order_status' => 'cancelled',
                            'payment_notes' => $data['rejection_reason'],
                        ]);
                        
                        // Kirim notifikasi ke user
                        $record->user->notify(new \App\Notifications\PaymentStatusNotification(
                            $record, 
                            'rejected', 
                            $data['rejection_reason']
                        ));
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran Ditolak')
                            ->body("Pembayaran untuk pesanan #{$record->id} telah ditolak dan stok dikembalikan")
                            ->warning()
                            ->send();
                    })
                    ->modalHeading('Tolak Pembayaran')
                    ->modalDescription('Penolakan pembayaran akan membatalkan pesanan dan mengembalikan stok produk.')                    ->modalWidth('md'),
                    
                Tables\Actions\Action::make('process_order')
                    ->label('Proses')
                    ->icon('heroicon-o-cog')
                    ->color('primary')
                    ->visible(fn (Transaction $record) => $record->order_status === 'confirmed')
                    ->action(function (Transaction $record) {
                        $record->update(['order_status' => 'processing']);
                        
                        $record->user->notify(new \App\Notifications\PaymentStatusNotification(
                            $record, 
                            'processing'
                        ));
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Pesanan Diproses')
                            ->body("Pesanan #{$record->id} sedang diproses")
                            ->info()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('ship_order')
                    ->label('Kirim')
                    ->icon('heroicon-o-truck')
                    ->color('warning')
                    ->visible(fn (Transaction $record) => $record->order_status === 'processing')
                    ->action(function (Transaction $record) {
                        $record->update(['order_status' => 'shipped']);
                        
                        $record->user->notify(new \App\Notifications\PaymentStatusNotification(
                            $record, 
                            'shipped'
                        ));
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Pesanan Dikirim')
                            ->body("Pesanan #{$record->id} telah dikirim")
                            ->warning()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('deliver_order')
                    ->label('Diterima')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (Transaction $record) => $record->order_status === 'shipped')
                    ->action(function (Transaction $record) {
                        $record->update(['order_status' => 'delivered']);
                        
                        $record->user->notify(new \App\Notifications\PaymentStatusNotification(
                            $record, 
                            'delivered'
                        ));
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Pesanan Diterima')
                            ->body("Pesanan #{$record->id} telah diterima pelanggan")                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                      Tables\Actions\BulkAction::make('confirm_payments')
                        ->label('Konfirmasi Pembayaran Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if ($record->payment_status === 'pending') {
                                    $record->update([
                                        'payment_status' => 'paid',
                                        'payment_date' => now(),
                                        'order_status' => $record->order_status === 'pending' ? 'confirmed' : $record->order_status,
                                    ]);
                                }
                            });
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Pesanan')
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('ID Pesanan')
                            ->badge()
                            ->color('primary'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Pesanan')
                            ->dateTime('d F Y, H:i'),
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Nama Pelanggan'),
                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email Pelanggan')
                            ->copyable(),
                    ])
                    ->columns(2),
                    
                Infolists\Components\Section::make('Detail Produk')
                    ->schema([
                        Infolists\Components\TextEntry::make('product.name')
                            ->label('Produk'),
                        Infolists\Components\TextEntry::make('product.category.name')
                            ->label('Kategori'),
                        Infolists\Components\TextEntry::make('quantity')
                            ->label('Jumlah')
                            ->badge()
                            ->color('info'),
                        Infolists\Components\TextEntry::make('total_price')
                            ->label('Total Harga')
                            ->money('IDR')
                            ->size('lg')
                            ->weight('bold'),
                    ])
                    ->columns(2),
                    
                Infolists\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Infolists\Components\TextEntry::make('payment_status')
                            ->label('Status Pembayaran')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Tertunda',
                                'paid' => 'Dibayar',
                                'failed' => 'Gagal',
                                'cancelled' => 'Dibatalkan',
                                default => $state
                            })
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'paid' => 'success',
                                'failed' => 'danger',
                                'cancelled' => 'danger',
                            }),
                        Infolists\Components\TextEntry::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                'transfer_bank' => 'Transfer Bank',
                                'cash' => 'Bayar di Tempat',
                                'e_wallet' => 'E-Wallet',
                                default => 'Belum Dipilih',
                            })
                            ->badge()
                            ->color('gray'),
                        Infolists\Components\TextEntry::make('payment_date')
                            ->label('Tanggal Pembayaran')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('Belum dibayar'),
                        Infolists\Components\ImageEntry::make('payment_proof')
                            ->label('Bukti Pembayaran')
                            ->size(200)
                            ->placeholder('Tidak ada bukti diunggah'),
                        Infolists\Components\TextEntry::make('payment_notes')
                            ->label('Catatan Pembayaran')
                            ->placeholder('Tidak ada catatan'),
                    ])
                    ->columns(2),
                    
                Infolists\Components\Section::make('Status Pesanan')
                    ->schema([
                        Infolists\Components\TextEntry::make('order_status')
                            ->label('Status Pesanan')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Tertunda',
                                'confirmed' => 'Dikonfirmasi',
                                'processing' => 'Diproses',
                                'shipped' => 'Dikirim',
                                'delivered' => 'Diterima',
                                'cancelled' => 'Dibatalkan',
                                default => $state
                            })
                            ->badge()
                            ->size('lg')
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'confirmed' => 'info',
                                'processing' => 'primary',
                                'shipped' => 'secondary',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                            }),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('payment_status', 'pending')->count();
    }
    
    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }
}
