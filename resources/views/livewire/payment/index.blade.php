<?php

use Livewire\Volt\Component;
use App\Models\Nota;
use App\Models\Transaction;
new class extends Component {
    public function with()
    {
        return [
            'notas' => Transaction::latest()->get(),
            'title' => 'Payment',
        ];
    }

    public function snapToken()
    {
    }
};
?>

<div class="container mx-auto pt-20">
    <livewire:components.cart-bar :title="$title" />
    @if ($notas->count() == null)
        <div class="container mx-auto flex justify-center items-center px-5 h-svh">
            <h1 class="text-3xl fs-10 fw-bold text-center text-white">Belum Ada Pesanan</h1>
        </div>
    @else
        <div>
            <div class="grid grid-cols-1 gap-3 p-5 relative">
                @foreach ($notas as $item)
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 w-full flex my-4 ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-s-lg">
                                        Kode Transaksi
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-e-lg">
                                        Total Item
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-e-lg">
                                        Total Pembayaran
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white dark:bg-gray-800">
                                    <td class="px-6 py-4">
                                        {{ $item->ts_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->total_item }} Pcs
                                    </td>
                                    <td class="px-6 py-4">
                                        Rp.{{ number_format($item->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="/checkout/p/{{ $item->ts_number }}">
                                            <button
                                                class="shadow-md md:w-[4rem] rounded md:h-[3rem] w-[2rem] h-[2rem] text-white text-3xl bg-lime-500">
                                                <i class="far fa-credit-card"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
