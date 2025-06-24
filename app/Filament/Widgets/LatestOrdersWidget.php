<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrdersWidget extends BaseWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';
    
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()
                    ->with(['user', 'product'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Pesanan')
                    ->badge()
                    ->color('primary'),
                    
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->description(fn (Transaction $record): string => $record->user->email ?? ''),
                    
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->description(fn (Transaction $record): string => $record->quantity . ' item'),
                    
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR'),
                    
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Tertunda',
                        'paid' => 'Dibayar',
                        'failed' => 'Gagal',
                        'cancelled' => 'Dibatalkan',
                        default => $state
                    })
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => ['failed', 'cancelled'],
                    ]),
                    
                Tables\Columns\BadgeColumn::make('order_status')
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
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'confirmed',
                        'primary' => 'processing',
                        'secondary' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ]),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->since()
                    ->dateTimeTooltip(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Transaction $record): string => route('filament.admin.resources.transactions.view', $record)),
            ]);
    }
}
