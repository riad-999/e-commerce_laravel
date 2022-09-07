<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
{
    use Queueable, SerializesModels;

    public $cart;
    public $admin;
    public $order;
    public $wilaya;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cart, $admin, $order, $wilaya)
    {
        $this->cart = $cart;
        $this->admin = $admin;
        $this->order = $order;
        $this->wilaya = $wilaya;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sum = 0;
        foreach ($this->cart as $item) {
            if ($item->promo) {
                if (($item->cut && ($item->cut * $item->price / 100) < $item->promo)) {
                    $sum += floor($item->cut * $item->price / 100) * $item->quantity;
                } else {
                    $sum += $item->promo * $item->quantity;
                }
            } elseif ($item->cut) {
                $sum += $item->quantity * floor($item->cut * $item->price / 100);
            } else {
                $sum += $item->quantity * $item->price;
            }
        }
        return $this->view('email.ordre', [
            'cart' => $this->cart,
            'admin' => $this->admin,
            'sub_total' => $sum,
            'order' => $this->order
        ])->subject('Votre Commande');
    }
}