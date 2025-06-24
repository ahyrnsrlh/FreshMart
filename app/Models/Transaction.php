<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'payment_status',
        'payment_method',
        'payment_proof',
        'payment_notes',
        'payment_date',
        'order_status'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
        'payment_date' => 'datetime'
    ];

    /**
     * Get the product that belongs to the transaction.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment status badge color.
     */
    public function getPaymentStatusBadgeAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get the order status badge color.
     */
    public function getOrderStatusBadgeAttribute()
    {
        return match($this->order_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'processing' => 'bg-purple-100 text-purple-800',
            'shipped' => 'bg-indigo-100 text-indigo-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get the payment method display name.
     */
    public function getPaymentMethodNameAttribute()
    {
        return match($this->payment_method) {
            'transfer_bank' => 'Transfer Bank',
            'cash' => 'Cash/Tunai',
            'e_wallet' => 'E-Wallet',
            default => 'Belum dipilih'
        };
    }
}
