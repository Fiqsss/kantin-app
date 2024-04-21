<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class CheckoutController extends Controller
{
    public function success(Transaction $transactions, $id)
    {
        $transactions = Transaction::where('id', $id)->first();
        $transactions->status = 'success';
        $transactions->save();
        return view('Page.checkoutsuccess', [
            'title' => 'Checkout Success',
            'transactions' => $transactions,
        ]);
    }
}
