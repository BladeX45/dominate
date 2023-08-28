<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function customerTransactions(){
        // Memeriksa apakah pengguna sudah login atau belum
        if (Auth::check()) {
            // cek admin or not?
            if(auth()->user()->roleID === 1){
                $data = Transaction::all();
                return view('pages.transactions', ['data' => $data]);
            }
            $data = Transaction::where('userID', Auth::user()->id)->get();
            return view('pages.transactions', ['data' => $data]);
        } else {
            // Redirect atau tindakan lain jika pengguna belum login
            return redirect()->route('login'); // Ganti 'login' dengan nama rute halaman login
        }
    }

    public function generateUniqueTransactionID()
    {
        $prefix = 'TX-'; // Prefix untuk ID transaksi

        // 8 random number
        $randomPart = mt_rand(00000000,9999999);

        $uniqueID = $prefix . $randomPart;
        // Pastikan ID ini belum digunakan sebelumnya dalam database
        while (Transaction::where('transactionID', $uniqueID)->exists()) {
            $randomPart = mt_rand(00000000,9999999);
            $uniqueID = $prefix . $randomPart;
        }

        return $uniqueID;
    }

    // order
    public function order(Request $request){
        // Contoh data dari form transmisi
        $transmissionType = $request->transmissionType;
        $selectedPlan = $request->plan;
        $planNameToCheck = $request->planName;

        // Validasi data permintaan
        $validator = Validator::make($request->all(), [
            'transmissionType' => 'required|in:manual,automatic',
            'plan' => 'required|string',
            'amount' => 'required|integer|min:1',
            'totalPrice' => 'required_without:totalSession|numeric|min:0',
            'totalSession' => 'required_without:totalPrice|integer|min:0',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil data dari tabel plans berdasarkan jenis transmisi dan opsi yang dipilih
        $matchingPlan = Plan::where('planType', $transmissionType)
                            ->where('planName', $selectedPlan)
                            ->first();

        // Menghitung total harga dan total sesi
        $totalPrice = $request->totalPrice ?? ($request->amount * $matchingPlan->planPrice);
        $totalSession = $request->totalSession ?? ($request->amount * $matchingPlan->totalSession);

        // Simpan data transaksi ke database
        $transaction = new Transaction();
        $transaction->userID = Auth::user()->id; // Ganti dengan cara Anda untuk mendapatkan ID pengguna yang sedang login
        $transaction->planID = $matchingPlan->id;
        $transaction->planAmount = $request->amount;
        $transaction->totalSession = $totalSession;
        $transaction->transactionID = $this->generateUniqueTransactionID(); // Ganti dengan cara Anda untuk menghasilkan ID transaksi unik
        $transaction->paymentMethod = 'transfer bank'; // Anda perlu mendapatkan ini dari formulir juga
        $transaction->paymentStatus = 'Pending'; // Anda mungkin perlu mengatur status pembayaran sesuai dengan proses Anda
        $transaction->paymentAmount = $totalPrice;
        $transaction->receiptTransfer = null; // Anda mungkin perlu mengatur ini sesuai dengan proses Anda
        $transaction->save();

        // Redirect atau tindakan lain setelah data tersimpan
        return redirect()->route('customer.transactions'); // Ganti 'transaction.success' dengan nama rute yang sesuai

        // Anda juga perlu mendefinisikan metode generateUniqueTransactionID()
        // dan pastikan Anda telah mengimpor model Transaction dan Auth di atas
    }


}
