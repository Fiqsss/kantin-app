<?php

use function Livewire\Volt\{state};
use App\Models\Cart;
use App\Models\Transaction;
use Livewire\Attributes\On;

use Livewire\Volt\Component;
new class extends Component {
    public $cartTotal = 0;
    public $payTotal = 0;
    public $title;
    public function mount($title)
    {
        $this->updateCartTotal();
        $this->title = $title;
    }

    public function with()
    {
        return [
            'qty' => Cart::sum('qty'),
        ];
    }

    #[On('updateCartTotal')]
    public function updateCartTotal()
    {
        $this->cartTotal = Cart::sum('qty');
        $this->payTotal = Transaction::where('status' , 'pending')->count();
    }
};

?>

<div class="pt-10">
    <div class="containt mx-auto bg-blue flex justify-start px-10">
        <a wire:navigate href="/">
            <div
                class="kotak-menu flex justify-center items-center rounded-full w-14 h-14 relative  @if ($title == 'Home') border-[#22C7A9]@else border-slate-400 @endif border-[3px] mx-2">
                <i
                    class="fa-solid fa-house @if ($title == 'Home') text-[#22C7A9] @else text-slate-500 @endif "></i>
            </div>
        </a>

        <a wire:navigate href="/cart">
            <div
                class="kotak-menu flex justify-center items-center rounded-full w-14 h-14 relative  @if ($title == 'Cart') border-[#22C7A9] @else border-slate-400 @endif border-[3px] mx-2">
                <i
                    class="fa-solid fa-cart-shopping @if ($title == 'Cart') text-[#22C7A9] @else text-slate-500 @endif "></i>
                @if ($qty != null)
                    <div
                        class="h-7 w-7 right-[-1rem] top-[-1rem] bg-red-600 absolute text-white flex justify-center items-center rounded-full">
                        {{ $cartTotal }}
                    </div>
                @endif
            </div>
        </a>
        <a wire:navigate href="/payment">
            <div
                class="kotak-menu flex justify-center items-center rounded-full w-14 h-14 relative  @if ($title == 'Payment') border-[#22C7A9] @else border-slate-400 @endif border-[3px] mx-2">
                <i
                    class="fas fa-wallet  @if ($title == 'Payment') text-[#22C7A9] @else text-slate-500 @endif "></i>
                @if ($payTotal != null )
                    <div
                        class="h-7 w-7 right-[-1rem] top-[-1rem] bg-red-600 absolute text-white flex justify-center items-center rounded-full">
                        <h1>{{ $payTotal }}</h1>
                    </div>
                @endif
            </div>
        </a>
    </div>
</div>
