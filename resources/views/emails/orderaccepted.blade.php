@component('mail::message')
# Reservasi Anda telah Disetujui!

Reservasi anda telah disetujui oleh Admin.  
Langkah selanjutnya adalah melakukan pembayaran melalui transfer ATM ke rekening :

## BCA xxxxxxxxxx a/n SANSS ADVENTURE
## Jumlah Pembayaran : @money($payment->total)

Setelah pembayaran, silakan upload bukti bayar pada website.

---

# Detail Reservasi

<b>Nama :</b> {{ $payment->user->name }} <br>
<b>No Invoice :</b> {{ $payment->no_invoice }} <br>
<b>Tanggal Pengambilan :</b> 
{{ date('d M Y H:i', strtotime($payment->order->first()->starts)) }}

@component('mail::table')
| Item | Durasi | Harga |
|------|--------|-------|

@foreach ($payment->order as $item)

@if($item->alat_id)

| {{ $item->alat->nama_alat }} | {{ $item->durasi }} Jam | @money($item->harga) |

@elseif($item->service_id)

| {{ $item->service->nama_layanan }} | Paket Layanan | @money($item->harga) |

@endif

@endforeach

@endcomponent

---

Terima kasih telah menggunakan layanan kami.

Thanks,<br>
SANSS ADVENTURE
@endcomponent