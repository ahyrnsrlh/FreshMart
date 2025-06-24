<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentPendingWidget extends BaseWidget
{
    protected static ?string $heading = 'Pembayaran Menunggu Konfirmasi';
    
    protected static ?int $sort = 1;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()
                    ->where('payment_status', 'pending')
                    ->with(['user', 'product'])
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->description(fn (Transaction $record): string => $record->user->email ?? ''),
                    
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->alignCenter(),
                    
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'transfer_bank' => 'Transfer',
                        'cash' => 'COD',
                        'e_wallet' => 'E-Wallet',
                        default => '-',
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
                    ->label('Tanggal')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view_payment_proof')
                    ->label('Bukti')
                    ->icon('heroicon-o-photo')
                    ->color('info')
                    ->size('sm')
                    ->visible(fn (Transaction $record) => !empty($record->payment_proof))
                    ->url(fn (Transaction $record) => asset('storage/' . $record->payment_proof))
                    ->openUrlInNewTab(),
                    
                Tables\Actions\Action::make('confirm_payment')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->size('sm')
                    ->action(function (Transaction $record) {
                        $record->update([
                            'payment_status' => 'paid',
                            'payment_date' => now(),
                            'order_status' => $record->order_status === 'pending' ? 'confirmed' : $record->order_status,
                        ]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pembayaran')
                    ->modalDescription(fn (Transaction $record) => "Setujui pembayaran untuk pesanan #{$record->id} dari {$record->user->name}?"),
                    
                Tables\Actions\Action::make('reject_payment')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->size('sm')
                    ->action(function (Transaction $record) {
                        $record->update([
                            'payment_status' => 'failed',
                            'order_status' => 'cancelled',
                        ]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pembayaran')
                    ->modalDescription(fn (Transaction $record) => "Tolak pembayaran untuk pesanan #{$record->id} dari {$record->user->name}?"),
            ])
            ->emptyStateHeading('Tidak ada pembayaran pending')
            ->emptyStateDescription('Semua pembayaran sudah dikonfirmasi')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->defaultSort('created_at', 'desc')
            ->paginated([5, 10, 25]);
    }
}
