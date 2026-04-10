@component('mail::message')

# Pembayaran Berhasil!

Pembayaran anda telah terkonfirmasi.  
Silakan ambil alat atau layanan pada tanggal dan jam pengambilan yang tertera pada detail reservasi.

---

# Detail Reservasi

<b>Nama :</b> {{ $payment->user->name }} <br>
<b>No Invoice :</b> {{ $payment->no_invoice }} <br>
<b>Tanggal Pengambilan :</b> {{ date('d M Y H:i', strtotime($payment->order->first()->starts)) }}

@component('mail::table')
| Item | Durasi | Harga |
|------|--------|-------|

@foreach ($payment->order as $item)

@if($item->alat_id)

| {{ $item->alat->nama_alat }} | {{ $item->durasi / 24 }} Hari | @money($item->harga) |

@elseif($item->service_id)

| {{ $item->service->nama_layanan }} | Paket Layanan | @money($item->harga) |

@endif

@endforeach

@endcomponent

<b>Telah Melakukan Pembayaran sebesar @money($payment->total)</b>

<br><br>

Terima kasih telah menggunakan layanan kami.

Thanks,<br>
Sanss Adventure

@endcomponent