<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\CashFlow;
use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    public function setModal(Request $request)
{
    $request->validate([
        'startingBalance' => 'required|numeric',
    ]);

    $debitAmount = $request->startingBalance;

    // Get the last balance or initialize it to 0 if it doesn't exist
    $lastBalance = Cashflow::latest('id')->first();

    if ($lastBalance) {
        $balance = $lastBalance->balance + $debitAmount;
    } else {
        $balance = $debitAmount;
    }

    // Create a new cashflow entry
    Cashflow::create([
        'date' => now(),
        'debitAmount' => $debitAmount,
        'balance' => $balance,
    ]);

    return redirect()->back()->with('success', 'Cashflow has been added');
}


}
