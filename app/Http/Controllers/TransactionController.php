<?php

namespace App\Http\Controllers;

use to;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Cashflow;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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

    // transaction out
    public function expenses()
    {
        // Pemeriksaan peran: Hanya admin yang dapat mengakses halaman pengeluaran
        if (auth()->user()->roleID === '1') {
            // Ambil semua data pengeluaran
            $expenses = Expense::all();

            // Kirim data pengeluaran ke tampilan
            return view('admin.expense', compact('expenses'));
        } else {
            // Redirect atau berikan respons kesalahan jika bukan admin
            return redirect()->back()->with('error', 'Access denied. You do not have permission to view expenses.');
        }
    }


    // generate unique TransactionID
    public function generateUniqueTransactionIDExpense()
    {
        $prefix = 'EXP-'; // Prefix untuk ID transaksi

        do {
            // 8 random number
            $randomPart = mt_rand(00000000, 9999999);
            $uniqueID = $prefix . $randomPart;
        } while (Expense::where('transactionID', $uniqueID)->exists());

        return $uniqueID;
    }

    public function addExpense(Request $request)
    {
        // Validasi data yang dikirim dari form
        $request->validate([
            'expenseName' => 'required|string|max:255',
            'expenseAmount' => 'required|numeric',
            'expenseDate' => 'required|date',
            'expenseDescription' => 'nullable|string',
        ]);

        // transactionID
        $transactionID = $this->generateUniqueTransactionIDExpense();

        // Create expense record
        $expense = Expense::create([
            'transactionID' => $transactionID,
            'expenseName' => $request->expenseName,
            'expenseAmount' => $request->expenseAmount,
            'expenseDate' => $request->expenseDate,
            'expenseDescription' => $request->expenseDescription,
        ]);

        // Get last balance or create a new cashflow entry if null
        $lastBalance = Cashflow::orderBy('id', 'desc')->first();

        if ($lastBalance == null) {
            $lastBalance = Cashflow::create([
                'expense_id' => $expense->id,
                'creditAmount' => $expense->expenseAmount,
                'date' => Carbon::now(),
                'balance' => 0 - $expense->expenseAmount,
            ]);

            return redirect()->back()->with('success', 'Expense added successfully');
        }

        // Insert to cashflow
        $cashflow = Cashflow::create([
            'expense_id' => $expense->id,
            'creditAmount' => $expense->expenseAmount,
            'date' => Carbon::now(),
            'balance' => $lastBalance->balance - $expense->expenseAmount,
        ]);

        return redirect()->back()->with('success', 'Expense added successfully');
    }

    public function cashFlow(){

        // order by date
        $cashflows = Cashflow::orderBy('date', 'desc')->get();

        return view('admin.cashflow', compact('cashflows'));
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
    public function customerTransactions()
    {
        // Memeriksa apakah pengguna sudah login atau belum
        if (Auth::check()) {
            // cek admin or not?
            if (auth()->user()->roleID === 1) {
                $data = Transaction::all();
                return view('pages.transactions', ['data' => $data]);
            } else {
                $data = Transaction::where('userID', Auth::user()->id)->get();
                return view('pages.transactions', ['data' => $data]);
            }
        } else {
            // Redirect atau tindakan lain jika pengguna belum login
            return redirect()->route('login')->with('error', 'You need to log in to view transactions.'); // Ganti 'login' dengan nama rute halaman login
        }
    }


    // upload receipt Transfer
    public function uploadReceipt(Request $request)
    {
        // Validate the incoming request data, e.g., check if a file is uploaded
        $request->validate([
            'evidence' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Adjust validation rules as needed
        ]);

        // Check if the user is authenticated or authorized to upload receipts
        // You can add your authentication/authorization logic here

        // Get the uploaded file
        $uploadedFile = $request->file('evidence');

        // if null
        if ($uploadedFile == null) {
            return redirect()->back()->with('error', 'Receipt not found');
        }

        // Generate a unique filename for the uploaded file
        $filename = uniqid() . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();

        // Move the uploaded file to a storage location (e.g., public storage)
        $uploadedFile->storeAs('receipts', $filename, 'public');

        // Update the transaction record with the filename
        $transaction = Transaction::find($request->transactionID);

        // Check if the transaction record exists
        if ($transaction) {
            $transaction->receiptTransfer = $filename;
            $transaction->save();

            // You would typically associate this with the user's record or the transaction record

            // Redirect or return a response to indicate success
            return redirect()->back()->with('success', 'Receipt uploaded successfully');
        } else {
            return redirect()->back()->with('error', 'Transaction not found');
        }
    }



    public function generateUniqueTransactionID()
    {
        $prefix = 'TX-'; // Prefix untuk ID transaksi

        do {
            // 8 random number
            $randomPart = mt_rand(00000000, 9999999);
            $uniqueID = $prefix . $randomPart;
        } while (Transaction::where('transactionID', $uniqueID)->exists());

        return $uniqueID;
    }

    public function order(Request $request)
    {
        // Dump and die to inspect the request data
        // dd($request->all());

        // Validation rules
        $validator = Validator::make($request->all(), [
            'transmissionType' => 'required|in:manual,automatic',
            'plan' => 'required|string',
            'amount' => 'required|integer|min:1',
            'totalPrice' => 'required_without:totalSession|numeric|min:0',
            'totalSession' => 'required_without:totalPrice|integer|min:0',
            'paymentMethod' => 'required|in:transfer,cash',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find the matching plan based on transmission type and selected plan
        $matchingPlan = Plan::where('planType', $request->transmissionType)
                            ->where('planName', $request->plan)
                            ->first();

        // Validate if the plan is found
        if (!$matchingPlan) {
            return redirect()->back()->with('error', 'Selected plan not found');
        }

        // Calculate total price and total session
        $totalPrice = $request->totalPrice ?? ($request->amount * $matchingPlan->planPrice);
        $totalSession = $request->totalSession ?? ($request->amount * $matchingPlan->planSession);

        // Create a new transaction record
        $transaction = new Transaction();
        $transaction->userID = Auth::user()->id; // Replace with your method to get the user ID
        $transaction->planID = $matchingPlan->id;
        $transaction->planAmount = $request->amount;
        $transaction->totalSession = $totalSession;
        $transaction->transactionID = $this->generateUniqueTransactionID(); // Replace with your method to generate a unique transaction ID
        $transaction->paymentMethod = $request->paymentMethod;
        $transaction->paymentStatus = 'Pending';
        $transaction->paymentAmount = $totalPrice;
        $transaction->receiptTransfer = null; // Set this according to your process
        $transaction->save();

        // Redirect or perform other actions after saving data
        return redirect()->route('customer.transactions')->with('success', 'Order placed successfully'); // Replace with the appropriate route name
    }



    public function uploadEvidence(Request $request){
        // Validate the incoming request data, e.g., check if a file is uploaded
        $validator = $request->validate([
            'evidence' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Adjust validation rules as needed
        ]);
        // dd($validator);
        if ($validator) {
            // Check if the user is authenticated or authorized to upload receipts
            // Anda dapat menambahkan logika otentikasi/otorisasi Anda di sini

            // Get the uploaded file
            $uploadedFile = $request->file('evidence');

            // Generate a unique filename for the uploaded file
            $filename = uniqid() . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();

            // Pindahkan file yang diunggah ke public/assets/img/receipt/..
            $uploadedFile->storeAs('receipts', $filename, 'public');

            // Perbarui
            $transaction = Transaction::find($request->transactionID);
            $transaction->receiptTransfer = $filename;
            $transaction->save();

            // Redirect atau kembalikan respons untuk menunjukkan kesuksesan
            // dd($transaction);
            return redirect()->back()->with('success', 'Receipt uploaded successfully');
        } else {
            // Validasi gagal, kembalikan pesan kesalahan
            // dd($validator);
            return redirect()->back()->with('error', 'Validation failed. Please check your uploaded file.');
        }
    }


    // rejectEvidence
    public function rejectEvidence(Request $request){
        // find transaction where transactionID == request->transactionID
        $transaction = Transaction::where('transactionID', $request->transactionID)->firstOrFail();
        // update paymentStatus to failed
        $transaction->update(['paymentStatus' => 'failed']);
        // update receiptTransfer to null
        $transaction->update(['receiptTransfer' => null]);


        // You would typically associate this with the user's record or the transaction record

        // Redirect or return a response to indicate success
        return redirect()->back()->with('success', 'Receipt rejected successfully');
    }

    public function verifyTransaction(Request $request)
    {
        try {
            // Cari transaksi berdasarkan ID atau hasilkan ModelNotFoundException jika tidak ditemukan
            $transaction = Transaction::where('transactionID', $request->transactionID)->firstOrFail();

            // Perbarui status pembayaran menjadi 'success'
            $transaction->update(['paymentStatus' => 'success']);

            // Ambil saldo terakhir jika ada
            $lastBalance = Cashflow::orderBy('id', 'desc')->first();
            $balance = $lastBalance ? $lastBalance->balance : 0;

            // Buat entri cashflow baru
            Cashflow::create([
                'transaction_id' => $transaction->id,
                'debitAmount' => $transaction->paymentAmount,
                'date' => now(),
                'balance' => $balance + $transaction->paymentAmount,
            ]);

            // Temukan pelanggan berdasarkan ID pengguna transaksi
            $customer = Customer::where('userID', $transaction->userID)->firstOrFail();

            // Tentukan field sesi berdasarkan jenis rencana
            $sessionField = ($transaction->planID >= 1 && $transaction->planID <= 4) ? 'ManualSession' : 'MaticSession';

            // Perbarui jumlah sesi pelanggan
            $customer->update([$sessionField => $transaction->totalSession + $customer->$sessionField]);

            // Redirect atau kembalikan respons untuk menunjukkan keberhasilan
            return redirect()->back()->with('success', 'Transaction verified successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Tangani ketika transaksi tidak ditemukan
            return redirect()->back()->with('error', 'Transaction not found');
        } catch (\Exception $e) {
            // Tangani kesalahan umum
            return redirect()->back()->with('error', 'An error occurred while verifying the transaction');
        }
    }


    public function invoice(Request $request){
        // dd($request->all());
        $transaction = Transaction::where('transactionID', $request->id)->firstOrFail();
        // dd($transaction);

        // send to email
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];


        return view('invoice', compact('transaction'));
    }

}
