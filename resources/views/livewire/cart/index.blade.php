<?php

use function Livewire\Volt\{state};
use Livewire\Volt\Component;
use App\Models\Menu;
use App\Models\Transaction;
use App\Models\Nota;
use App\Models\Cart;

new class extends Component {
    public function with()
    {
        return [
            'menus' => Cart::latest()->get(),
            'title' => 'Cart',
            'qty' => Cart::sum('qty'),
        ];
    }

    public function removeFromCart($id)
    {
        Cart::where('id', $id)->delete();
        $this->dispatch('updateCartTotal');
    }

    public function checkout()
    {
        // $this->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'email' => 'required|email',
        //     'phone' => 'required',
        //     'city' => 'required',
        // ]);

        $cart = Cart::all();
        $ts_number = 'CD_' . rand(1, 99999);
        $transaction = Transaction::create([
            'ts_number' => $ts_number,
            'status' => 'Pending',
        ]);
        foreach ($cart as $item) {
            Nota::create([
                'menu_id' => $item['menu_id'],
                'transaction_id' => Transaction::where('ts_number', $ts_number)->first()->id,
                'qty' => $item->qty,
                'total' => $item->total,
            ]);
        }

        $transactionId = Transaction::where('ts_number', $ts_number)->first()->id;
        $totalItem = Nota::where('transaction_id', $transactionId)->sum('qty');
        $totalPrice = Nota::where('transaction_id', $transactionId)->sum('total');

        // snap token
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $totalPrice,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        Transaction::where('ts_number', $ts_number)->update([
            'total_item' => $totalItem,
            'total_price' => $totalPrice,
            'snap_token' => $snapToken,
        ]);
        // end snap token

        Cart::truncate();

        return redirect('/');
    }
};
?>
<div>
    <div class="container mx-auto pt-20">
        <livewire:components.cart-bar :title="$title" />
        @if ($qty == null)
            <div class="container mx-auto flex justify-center items-center px-5 h-svh">
                <h1 class="text-3xl fs-10 fw-bold text-center text-white">😊 Silahkan Pilih Menu Terlebih dahulu 😊</h1>
            </div>
        @else
            <div class="grid grid-cols-1 gap-3 p-5 relative">
                @foreach ($menus as $menu)
                    <div
                        class="h-[7rem] md:h-[15rem]  bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 w-full flex my-4 ">
                        <div class="flex justify-center w-[50%] md:w-[20%]">
                            <div class="flex items-center">
                                <img class="object-cover w-[7rem] rounded-lg h-[7rem] md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"
                                    src="{{ asset('img/menu/' . $menu->menu->foto) }}" alt="">
                            </div>
                        </div>
                        <div class="harga-wrapperr w-full flex items-center ps-3">
                            <div class="isi w-full flex justify-between">
                                <div class="isi-wrap">
                                    <div class="title">
                                        <a href="#">
                                            <h5 class="text-xl mb-2 font-bold tracking-tight text-white ">
                                                {{ $menu->menu->name }}</h5>
                                        </a>
                                    </div>
                                    <div class=" flex justify-between items-center text-white">
                                        <p class="text-lg">x {{ $menu->qty }} = Rp.{{ number_format($menu->total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="text-center flex justify-center items-center mx-2 md:mx-3">
                                    <button
                                        class="shadow-md md:w-[4rem] rounded md:h-[4rem] w-[2rem] h-[2rem] text-white text-3xl bg-white"
                                        wire:click='removeFromCart({{ $menu->id }})'>
                                        <i class="fa-solid fa-trash w-5 p-0 m-0" style="color: #ff1a30;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="container cursor-pointer checkout flex justify-center w-full fixed bottom-5 ">
                    <a wire:click.prevent='checkout'
                        class="flex justify-center items-center h-[4rem] bg-[#22C7A9] rounded-full w-[80%] text-white font-bold text-2xl">Check
                        Out</a>
                </div>
            </div>
        @endif
    </div>
</div>
