<?php

use Livewire\Volt\Component;
use App\Models\Menu;
use App\Models\Transaction;
use App\Models\Nota;
use App\Models\Cart;

new class extends Component {
    public $ts_number;
    public function with()
    {
        return [
            'notas' => Cart::latest()->get(),
            'transactions' => Transaction::where('ts_number', $this->ts_number)->first(),
        ];
    }
};

?>
<div class="container mx-auto min-h-svh flex justify-center items-center">
    <div
        class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-center mb-4">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Pembayaran</h5>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <li class="py-3 sm:py-4">
                    <div class="flex items-center">
                        {{-- <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="Neil image">
                        </div> --}}
                        <div class="flex-1 min-w-0 ms-4">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Total Item
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{ $transactions->total_item }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            {{ 'Rp.' . number_format($transactions->total_price) }}
                        </div>
                    </div>
                </li>
                <div class="btn-checkout flex justify-center items-center pt-4">
                    <a id="pay-button" href="#"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Bayar
                    </a>
                </div>
            </ul>
        </div>
    </div>
</div>
@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $transactions->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    window.location.href = '{{ route('success' , $transactions->id) }}'
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endsection
