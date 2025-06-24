<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\Models\Transaction;

class PaymentStatusNotification extends Notification
{
    use Queueable;

    protected $transaction;
    protected $status;
    protected $message;

    public function __construct(Transaction $transaction, string $status, ?string $message = null)
    {
        $this->transaction = $transaction;
        $this->status = $status;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'status' => $this->status,
            'title' => $this->getTitle(),
            'message' => $this->getMessage(),
            'action_url' => route('customer.orders'),
            'type' => 'payment_status'
        ];
    }

    protected function getTitle()
    {
        return match($this->status) {
            'confirmed' => 'Pembayaran Dikonfirmasi',
            'rejected' => 'Pembayaran Ditolak',
            'processing' => 'Pesanan Diproses',
            'shipped' => 'Pesanan Dikirim',
            'delivered' => 'Pesanan Diterima',
            default => 'Update Pesanan'
        };
    }

    protected function getMessage()
    {
        if ($this->message) {
            return $this->message;
        }

        return match($this->status) {
            'confirmed' => "Pembayaran untuk pesanan #{$this->transaction->id} telah dikonfirmasi. Pesanan Anda sedang diproses.",
            'rejected' => "Pembayaran untuk pesanan #{$this->transaction->id} ditolak. Silakan periksa detail pesanan Anda.",
            'processing' => "Pesanan #{$this->transaction->id} sedang diproses dan akan segera dikirim.",
            'shipped' => "Pesanan #{$this->transaction->id} telah dikirim. Lacak pengiriman Anda.",
            'delivered' => "Pesanan #{$this->transaction->id} telah diterima. Terima kasih atas kepercayaan Anda!",
            default => "Status pesanan #{$this->transaction->id} telah diperbarui."
        };
    }
}
