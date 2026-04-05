<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Alat;
use Illuminate\Http\Request;

class OrderService
{
    /**
     * Membuat order dari keranjang
     *
     * @param \Illuminate\Support\Collection $cart
     * @param int $userId
     * @param Request $request
     * @return Payment
     */
    public function createOrder($cart, int $userId, Request $request): Payment
    {
        // =================== CREATE PAYMENT ===================
        $payment = Payment::create([
            'no_invoice' => $userId . "/" . now()->timestamp,
            'user_id' => $userId,
            'total' => $cart->sum('harga')
        ]);

        $cartAlat = [];
        $start = date('Y-m-d H:i', strtotime($request['start_date'] . " " . $request['start_time']));

        // =================== CREATE ORDER ===================
        foreach ($cart as $c) {
            $end = $c->alat_id
                ? date('Y-m-d H:i', strtotime($start . "+" . $c->durasi . " hours"))
                : $start;

            Order::create([
                'alat_id' => $c->alat_id,
                'service_id' => $c->service_id,
                'user_id' => $userId,
                'payment_id' => $payment->id,
                'durasi' => $c->durasi,
                'starts' => $start,
                'ends' => $end,
                'harga' => $c->harga,
                'is_bonus' => false,
            ]);

            if ($c->alat_id) {
                $cartAlat[] = $c->alat_id;
            }

            $c->delete();
        }

        // =================== BONUS ITEM ===================
        $bonusJumlah = floor($payment->total / 300000);

        if ($bonusJumlah > 0) {
            $bonusAlat = Alat::whereNotIn('id', $cartAlat)
                ->inRandomOrder()
                ->take($bonusJumlah)
                ->get();

            foreach ($bonusAlat as $alat) {
                Order::create([
                    'alat_id' => $alat->id,
                    'service_id' => null,
                    'user_id' => $userId,
                    'payment_id' => $payment->id,
                    'durasi' => 0,
                    'starts' => $start,
                    'ends' => $start,
                    'harga' => 0,
                    'is_bonus' => true,
                ]);
            }

            // =================== FLASH NOTIFICATION ===================
            session()->flash(
                'bonus',
                '🎉 Selamat! Anda mendapatkan ' . $bonusJumlah . ' bonus karena total sewa mencapai Rp' . number_format($payment->total, 0, ',', '.')
            );
        }

        return $payment;
    }
}