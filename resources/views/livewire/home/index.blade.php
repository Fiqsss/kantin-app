<?php
use function Livewire\Volt\{state};
use Livewire\Volt\Component;
use App\Models\Menu;
use App\Models\Cart;
use function Livewire\Volt\{with, usesPagination};
new class extends Component {
    public $cartTotal = 0;
    public $payTotal = 0;
    public $title;
    // public function mount()
    // {
    //     $this->updateCartTotal();
    // }

    public function with()
    {
        return [
            'qty' => Cart::sum('qty'),
            'menus' => Menu::latest()->get(),
            'jumlah' => Cart::latest()->get(),
            'title' => 'Home',
        ];
    }

    public function addToCart($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return;
        }
        $existingCartItem = Cart::where('menu_id', $id)->first();

        if ($existingCartItem) {
            $existingCartItem->qty += 1;
            $existingCartItem->total += $menu->price;
            $existingCartItem->save();
        } else {
            Cart::create([
                'menu_id' => $id,
                'qty' => 1,
                'total' => $menu->price, // Hitung total harga awal
            ]);
        }

        $this->dispatch('updateCartTotal');
    }

    public function dellToCart($id)
    {
        $cart = Cart::where('menu_id', $id)->first();

        if ($cart->qty > 1) {
            $cart->qty -= 1;
            $cart->total -= $cart->menu->price;
            $cart->save();
        } else {
            $cart->delete();
        }
        $this->dispatch('updateCartTotal');
    }
};
?>
<div class="container mx-auto mt-10 px-4">
    <livewire:components.cart-bar :title="$title">
        @foreach ($menus as $menu)
            <div
                class=" h-[15rem] border border-gray-200 rounded-lg shadow-lg bg-gray-800 dark:border-gray-700 w-full flex my-4 ">
                <div class="flex justify-center w-[50%] md:w-[20%]">
                    <div class="flex items-center">
                        <img class="w-[6rem] h-[6rem] bg-black rounded-full" src="{{ asset('img/menu/' . $menu->foto) }}"
                            alt="">
                    </div>
                </div>
                <div class="harga-wrapperr w-full flex items-center ps-3">
                    <div class="isi w-full flex justify-between">
                        <div class="isi-wrap">
                            <div class="title">
                                <a href="#">
                                    <h5 class="text-xl mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $menu->name }}</h5>
                                </a>
                            </div>
                            <div class=" flex justify-between items-center text-white">
                                <p class="text-lg">Rp.{{ $menu->price }}</p>
                            </div>
                        </div>
                        <div class="btn flex items-center mx-2 md:mx-3">
                            <button wire:click="addToCart({{ $menu->id }})"
                                class="bg-[black] md:w-[4rem] rounded md:h-[4rem] w-[3rem]
                                h-[3rem] bg-cyan-500 hover:bg-cyan-600 text-white text-3xl">
                                +
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
</div>
