@extends('app')
@section('contain')
    <div class="container mx-auto min-h-svh flex justify-center items-center">
        <div
            class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-center mb-4">
                <img class="img-fluid w-1/2 bg-light " src="{{ asset('svg/correct-success-tick-svgrepo-com.svg') }}" alt="">
            </div>
            <div class="flow-root">
                <h3 class="text-2xl font-bold text-center text-white">Pembayaran Berhasil</h3>
            </div>
            <div class="w-full flex justify-center items-center mt-4">
                <a class="" href="/">
                    <button class="shadow-md px-5 rounded md:h-[3rem] h-[2rem] text-white text-xl bg-lime-500">
                        Kembali ke Menu
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection
