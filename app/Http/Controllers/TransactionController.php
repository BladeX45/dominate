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
    public function expenses(){
        $expenses = Expense::all();

        return view('admin.expense', compact('expenses'));
    }

    // generate unique TransactionID
    public function generateUniqueTransactionIDExpense(){
        $prefix = 'EXP-'; // Prefix untuk ID transaksi

        // 8 random number
        $randomPart = mt_rand(00000000,9999999);

        $uniqueID = $prefix . $randomPart;
        // Pastikan ID ini belum digunakan sebelumnya dalam database
        while (Expense::where('transactionID', $uniqueID)->exists()) {
            $randomPart = mt_rand(00000000,9999999);
            $uniqueID = $prefix . $randomPart;
        }

        return $uniqueID;
    }
    // addExpense
    public function addExpense(Request $request){

        // dd($request->all());

        // transactionnID
        $transactionID = $this->generateUniqueTransactionIDExpense();

        // dd($transactionID);
        $expense = Expense::create([
            'transactionID' => $transactionID,
            'expenseName' => $request->expenseName,
            'expenseAmount' => $request->expenseAmount,
            'expenseDate' => $request->expenseDate,
            'expenseDescription' => $request->expenseDescription,
        ]);

        // get last balance
        $lastBalance = Cashflow::orderBy('id', 'desc')->first();

        // if null
        if($lastBalance == null){
            $lastBalance = Cashflow::create([
                // fk transaction -> nullable
                'expense_id' => $expense->id,
                // debitAmount
                'creditAmount' => $expense->expenseAmount,
                // date
                'date' => Carbon::now(),
                // update balance balance - creditAmount
                'balance' => 0 - $expense->expenseAmount,
            ]);
            return redirect()->back()->with('success', 'Expense added successfully');
        }

        // insert to cashflow
        $cashflow = Cashflow::create([
            // fk transaction -> nullable
            'expense_id' => $expense->id,
            // debitAmount
            'creditAmount' => $expense->expenseAmount,
            // date
            'date' => Carbon::now(),
            // update balance balance - creditAmount
            'balance' => $lastBalance->balance - $expense->expenseAmount,
        ]);
        // dd($expense);
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

    public function customerTransactions(){
        // Memeriksa apakah pengguna sudah login atau belum
        if (Auth::check()) {
            // cek admin or not?
            if(auth()->user()->roleID === 1){
                $data = Transaction::all();
                return view('pages.transactions', ['data' => $data]);
            }
            $data = Transaction::where('userID', Auth::user()->id)->paginate(10);

            return view('pages.transactions', ['data' => $data]);
        } else {
            // Redirect atau tindakan lain jika pengguna belum login
            return redirect()->route('login'); // Ganti 'login' dengan nama rute halaman login
        }
    }

    // upload receipt Transfer
    public function uploadReceipt(Request $request){
        // Validate the incoming request data, e.g., check if a file is uploaded
        dd($request->all());

        $request->validate([
            'evidence' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Adjust validation rules as needed
        ]);

        // if null
        if($request->evidence == null){
            return redirect()->back()->with('error', 'Receipt not found');
        }

        // Check if the user is authenticated or authorized to upload receipts
        // You can add your authentication/authorization logic here

        // Get the uploaded file
        $uploadedFile = $request->file('evidence');

        // Generate a unique filename for the uploaded file
        $filename = uniqid() . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();

        // Move the uploaded file to a storage location (e.g., public storage)
        $uploadedFile->storeAs('receipts', $filename, 'public');

        // update
        $transaction = Transaction::find($request->transactionID);
        $transaction->receiptTransfer = $filename;
        $transaction->save();

        // You would typically associate this with the user's record or the transaction record

        // Redirect or return a response to indicate success
        return redirect()->back()->with('success', 'Receipt uploaded successfully');
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
            'paymentMethod' => 'required|in:transfer,cash',
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
        $transaction->paymentMethod = $request->paymentMethod;; // Anda mungkin perlu mengatur metode pembayaran sesuai dengan proses Anda
        $transaction->paymentStatus = 'Pending'; //  Anda mungkin perlu mengatur status pembayaran sesuai dengan proses Anda
        $transaction->paymentAmount = $totalPrice;
        $transaction->receiptTransfer = null; // Anda mungkin perlu mengatur ini sesuai dengan proses Anda
        $transaction->save();

        // Redirect atau tindakan lain setelah data tersimpan
        return redirect()->route('customer.transactions'); // Ganti 'transaction.success' dengan nama rute yang sesuai

        // Anda juga perlu mendefinisikan metode generateUniqueTransactionID()
        // dan pastikan Anda telah mengimpor model Transaction dan Auth di atas
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

    public function verifyTransaction(Request $request) {
        try {
            $transaction = Transaction::where('transactionID', $request->transactionID)->firstOrFail();
            $transaction->update(['paymentStatus' => 'success']);

            // Find the last balance if it exists
            $lastBalance = Cashflow::orderBy('id', 'desc')->first();
            $balance = $lastBalance ? $lastBalance->balance : 0;

            // Create a new cashflow entry
            Cashflow::create([
                'transaction_id' => $transaction->id,
                'debitAmount' => $transaction->paymentAmount,
                'date' => now(),
                'balance' => $balance + $transaction->paymentAmount,
            ]);

            $customer = Customer::where('userID', $transaction->userID)->firstOrFail();

            $sessionField = ($transaction->planID >= 1 && $transaction->planID <= 4) ? 'ManualSession' : 'MaticSession';
            $customer->update([$sessionField => $transaction->totalSession + $customer->$sessionField]);

            // Redirect or return a response to indicate success
            return redirect()->back()->with('success', 'Transaction verified successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Transaction not found');
        } catch (\Exception $e) {
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
