<?php

namespace App\Http\Controllers;

// use model user
use App\Models\Car;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Models\Score;
use App\Models\rating;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Schedule;
use App\Models\instructor;
use App\Models\Certificate;
use App\Models\Transaction;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Admin Pages
    public function adminDashboard()
    {
        // dd('test');
        // Pastikan pengguna adalah admin, jika tidak, alihkan kembali ke halaman sebelumnya
        if (Auth::user()->roleID !== '1') {
            return redirect()->back();
        }

        // Ambil semua transaksi
        $transactions = Transaction::all();

        // Hitung total penjualan
        $totalSales = Transaction::where('paymentStatus', 'success')
            ->select('planID', DB::raw('SUM(planAmount) as totalSales'))
            ->groupBy('planID')
            ->get()
            ->sum('totalSales');

        // Hitung data persentase
        $percentageData = $this->calculatePercentageData($totalSales);

        // Ambil semua data mobil
        $cars = Car::all();

        // Ambil semua biaya
        $expenses = Expense::all();

        // Tampilkan tampilan dasbor admin dan kirim data yang diperlukan
        return view('admin.dashboard', compact('transactions', 'percentageData', 'cars', 'expenses'));
    }

    private function calculatePercentageData($totalSales)
    {
        // Ambil data penjualan
        $salesData = Transaction::where('paymentStatus', 'success')
            ->select('planID', DB::raw('SUM(planAmount) as totalSales'))
            ->groupBy('planID')
            ->get();

        // Hitung persentase untuk setiap item
        return $salesData->map(function ($item) use ($totalSales) {
            return [
                'Plan' => $item->plan->planName, // Mengasumsikan Anda memiliki relasi 'plan' di model Transaction
                'Percentage' => ($item->totalSales / $totalSales) * 100,
                'population' => $item->totalSales,
            ];
        });
    }

<<<<<<< HEAD

    public function customerDashboard(){
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != 2){
            return redirect()->back();
=======
    public function customerDashboard()
    {
        // Forbidden route if the user is not a customer
        if (Auth::user()->roleID != '2') {
            return redirect()->back()->with('error', 'Access denied. You do not have permission to view the customer dashboard.');
>>>>>>> b284fced387bacca9cc93bf5cc5baeb34dc7c681
        }

        // Get customer data based on the authenticated user
        $customer = Customer::where('userID', Auth::user()->id)->first();

        // Get all transactions for the customer
        $transactions = Transaction::where('userID', Auth::user()->id)->get();

        // Get all schedules for the customer
        $schedules = Schedule::where('customerID', $customer->id)->get();

        // Get all instructors
        $instructors = Instructor::all();

        // Get overall assessment and scheduleID ordered by created_at
        $scores = Score::where('customerID', $customer->id)->orderBy('scheduleID', 'asc')->get();

        // Convert scores to an array if needed
        $scores = $scores->toArray();

        // Get all certificates for the customer
        $certificates = Certificate::where('customerID', $customer->id)->get();

        return view('layouts.dashboard.customer', compact('customer', 'schedules', 'instructors', 'scores', 'transactions', 'certificates'));
    }

    public function users()
    {
<<<<<<< HEAD
        // Periksa peran pengguna yang sedang login (roleID)
=======
        // dd(now());
        // check auth role 0 / 1
>>>>>>> b284fced387bacca9cc93bf5cc5baeb34dc7c681
        switch (auth()->user()->roleID) {
            case 0:
                // Jika peran adalah 0 (owner), ambil daftar pengguna dengan peran 1 (instructor)
                $users = User::where('roleID', 1)->get();
                return view('owner.users', compact('users'));
                break;
            case 1:
                // Jika peran adalah 1 (instructor), ambil daftar instruktur dan pengguna dengan peran 3 (customer)
                $instructors = Instructor::all();
                $data = DB::table('users')
                    ->join('roles', 'users.roleID', '=', 'roles.roleID')
                    ->where('users.roleID', 3) // Hanya ambil data dengan roleID = 3 (customer)
                    ->select(
                        'users.id as userID',
                        'users.name as userName',
                        'users.email as userEmail',
                        'roles.roleName'
                    )
                    ->paginate(10);

                // Kirim data ke tampilan admin.users
                return view('admin.users', compact('data', 'instructors'));
                break;
            case 2:
                // Jika peran adalah 2 (customer), alihkan ke dashboard pelanggan
                return redirect()->route('customer.dashboard');
                break;
            case 3:
                // Jika peran adalah 3 (instructor), alihkan ke dashboard instruktur
                return redirect()->route('instructor.dashboard');
                break;
            default:
                // Jika tidak ada peran yang cocok, alihkan ke halaman login
                return redirect()->route('login');
                break;
        }
    }


    // transactions page

    public function indexTransactions()
    {
        // Periksa apakah pengguna adalah admin
        if (auth()->user()->roleID === '1') {
            // Query untuk mengambil data transaksi dengan informasi tambahan dari tabel users dan plans
            $data = DB::table('transactions')
                ->join('users', 'transactions.userID', '=', 'users.id')
                ->join('plans', 'transactions.planID', '=', 'plans.id')
                ->select(
                    'transactions.transactionID as transactionID',
                    'users.name as userName',
                    'transactions.planID as planID',
                    'transactions.created_at as transactionDate',
                    'transactions.planAmount as planAmount',
                    'transactions.paymentAmount as paymentAmount',
                    'transactions.paymentStatus as transactionStatus',
                    'transactions.paymentMethod as paymentMethod',
                    'transactions.receiptTransfer as receiptTransfer',
                    'transactions.totalSession as totalSession',
                    'plans.planName as planName',
                    'plans.planType as planType',
                    'plans.planPrice as planPrice'
                )
                ->get();

            // Kirim data transaksi ke tampilan
            return view('admin.transactions', compact('data'));
        } else {
            // Jika pengguna bukan admin, redirect dengan pesan kesalahan
            return redirect()->back()->with('error', 'Access denied. You do not have permission to view transactions.');
        }
    }


    public function verifyPayment(Request $request){
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != '1'){
            return redirect()->back();
        }


    }
    public function customers(){
        // Cek apakah pengguna yang mengakses memiliki peran admin (roleID 1)
        if(Auth::user()->roleID != 1){
            // Jika tidak, maka redirect kembali ke halaman sebelumnya
            return redirect()->back();
        }

        // Jika pengguna memiliki peran admin, maka lanjutkan
        // Mencari semua pengguna dengan peran roleID 2
        $users = User::where('roleID', 2)->get();

        // Menampilkan tampilan 'admin.customers' dan menyertakan data pengguna yang telah ditemukan
        return view('admin.customers', compact('users'));
    }


    public function assets(){
        // Cek apakah pengguna saat ini adalah admin (roleID = 1)
        if (Auth::user()->roleID != 1) {
            // Jika bukan admin, larikan pengguna kembali ke halaman sebelumnya
            return redirect()->back();
        }

        // Jika pengguna adalah admin, lanjutkan untuk mengambil data kendaraan
        $cars = Car::all();

        // Kemudian kirim data kendaraan ke tampilan (view) 'admin.assets'
        return view('admin.assets', compact('cars'));
    }


    public function plans(){
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != 1){
            return redirect()->back();
        }

        // get plan paginate 10
        $plans = Plan::all();
        return view('admin.plans', compact('plans'));
    }
    // End Admin Pages
    /**
     * Display icons page
     *
     * @return \Illuminate\View\View
     */
    public function icons()
    {
        return view('pages.icons');
    }

    /**
     * Display maps page
     *
     * @return \Illuminate\View\View
     */
    public function maps()
    {
        return view('pages.maps');
    }
    public function pricing()
    {
        // Mengambil semua data dari tabel 'plans' dengan planType 'manual'
        $dataManual = Plan::where('planType', 'manual')->get();

        // Mengambil semua data dari tabel 'plans' dengan planType 'matic'
        $dataMatic = Plan::where('planType', 'automatic')->get();
        $data = Plan::all();

        return view('pages.pricing', compact('dataManual', 'dataMatic', 'data'));
    }


    /**
     * Display tables page
     *
     * @return \Illuminate\View\View
     */
    public function tables()
    {
        return view('pages.tables');
    }

    /**
     * Display notifications page
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('pages.notifications');
    }

    /**
     * Display rtl page
     *
     * @return \Illuminate\View\View
     */
    public function rtl()
    {
        return view('pages.rtl');
    }

    /**
     * Display typography page
     *
     * @return \Illuminate\View\View
     */
    public function typography()
    {
        return view('pages.typography');
    }

    // welcome page
    public function welcome()
    {
        // Mengambil semua data dari tabel 'plans' dengan planType 'manual'
        $dataManual = Plan::where('planType', 'manual')->get();

        // Mengambil semua data dari tabel 'plans' dengan planType 'matic'
        $dataMatic = Plan::where('planType', 'automatic')->get();

        // Mengambil semua data rating dari tabel 'ratings' asc
        $ratings = rating::orderBy('created_at', 'asc')->get();

        // dd($ratings);

        return view('welcome', compact('dataManual', 'dataMatic', 'ratings'));
    }

    // checCertificate with certificate number
    public function checkCertificate(Request $request){
        // get input
        $certificateNumber = $request->input('certificateNumber');
        // get data certificate
        $certificate = Certificate::where('certificateNumber', $certificateNumber)->first();
        // if certificate isExist then redirect to show certificate
        if($certificate != null){
            // get data customer

            // get first schedule where customerID = certificate customerID
            $schedulesFirst = Schedule::where('customerID', $certificate->customerID)->orderBy('date', 'asc')->first();

            // get last schedule before certificate date where customerID = certificate customerID
            $schedulesLast = Schedule::where('customerID', $certificate->customerID)->where('date', '<', $certificate->certificateDate)->orderBy('date', 'desc')->first();
            dd($schedulesLast);


            // return view certificate
            return view('pages.certificate', compact('certificate', 'schedulesFirst' , 'schedulesLast'));
        }
        // if certificate is notExist then redirect back
        return redirect()->back()->with('error', 'Certificate not found!');
    }
    /**
     * Display upgrade page
     *
     * @return \Illuminate\View\View
     */
    public function upgrade()
    {
        return view('pages.upgrade');
    }
    public function checkAvailability(Request $request)
    {
        // Get request parameters
        $instructorId = $request->input('instructor');
        $date = $request->input('date');
        $session = $request->input('session');
        $type = $request->input('type');

        // Map the type to 'manual' or 'automatic'
        $type = ($type === 'manual') ? 'manual' : 'automatic';

        // Check instructor availability
        $instructorAvailability = !$this->isInstructorScheduleConflict($instructorId, $date, $session);



        // Check car availability
        $carAvailability = $this->isCarAvailable($type, $date, $session);

        // Determine overall availability
        $isAvailable = $instructorAvailability && $carAvailability;

        return response()->json(['isAvailable' => $isAvailable]);
    }


    protected function isInstructorScheduleConflict($instructorId, $date, $session)
    {
        return Schedule::where('instructorID', $instructorId)
            ->where('date', $date)
            ->where('session', $session)
            ->exists();
    }

    // create function isCarAvailable with request parameter
    // find car where carStatus = available and transmission = request type and doesnt have schedule with date and session
    protected function isCarAvailable($type, $date, $session)
    {
        return Car::where('carStatus','=', 'available')
            ->where('Transmission', $type)
            ->whereDoesntHave('schedules', function ($query) use ($date, $session) {
                $query->where('date', $date)->where('session', $session);
            })
            ->exists();
    }


    // certificate page
    public function certificate(Request $request){
        // check auth role 0 / 1
        switch (auth()->user()->roleID) {
            case 0:
                return redirect()->route('owner.dashboard');
                break;
            case 1:
                return redirect()->route('admin.dashboard');
                break;
            case 2:

                // get input
                $customerID = $request->input('customerID');
                $scheduleID = $request->input('scheduleID');
                $instructorID = $request->input('instructorID');
                // generating number certificate unique and pattern sequential
                $number = 'CERT-'.date('Y').'-'.date('m').'-'.date('d').'-'.rand(1000, 9999);

                // get data customer
                $customer = Customer::find($customerID);
                // get data schedule
                $schedules = Schedule::find($scheduleID);
                // get data instructor
                $instructors = Instructor::find($instructorID);
                // get data score
                $scores = Score::where('customerID', $customerID)->where('scheduleID', $scheduleID)->first();

                // dd($scores);
                // if certificate customer ID and schedule ID isExist then redirect back
                if(Certificate::where('customerID', $customerID)->where('scoreID', $scores->id)->exists()){
                    // redirect to show customer certicate

                    // get data schedule first
                    $schedulesFirst = Schedule::where('customerID', $customerID)->orderBy('date', 'asc')->first();

                    $certificate = Certificate::where('customerID', $customerID)->where('scoreID', $scores->id)->first();

                    // get data schedule last before certificate
                    $schedulesLast = Schedule::where('customerID', $customerID)->orderBy('date', 'desc')->first();

                    return view('pages.certificate', compact('schedules', 'customer', 'scores', 'instructors', 'certificate', 'schedulesFirst', 'schedulesLast'));
                }


                // if certificate number isExist then create new number
                if(Certificate::where('certificateNumber', $number)->exists()){
                    $number = 'CERT-'.date('Y').'-'.date('m').'-'.date('d').'-'.rand(1000, 9999);
                }
                // dd($schedules);
                // create certificate pdf
                $certificate = Certificate::create([
                    'certificateNumber' => $number,
                    'customerID' => $customerID,
                    'scoreID' => $scores->id,
                    // certificateDate
                    'certificateDate' => date('Y-m-d'),
                ]);


                return view('pages.certificate', compact('schedules', 'customer', 'scores', 'instructors', 'certificate'));
                break;
            case 3:
                return redirect()->route('instructor.dashboard');
                break;
            default:
                return redirect()->route('login');
                break;
        }
    }

    // dashboard instructor
    public function instructorDashboard()
    {
        // Forbidden route if the user is not an instructor
        if (Auth::user()->roleID != '3') {
            return redirect()->back()->with('error', 'Access denied. You do not have permission to view the instructor dashboard.');
        }

        // Get data instructor
        $instructor = Instructor::where('userID', Auth::user()->id)->first();

        // Get all schedules ordered by Date
        $schedules = Schedule::where('instructorID', $instructor->id)->orderBy('date', 'asc')->get();

        // Get overall assessment and scheduleID ordered by created_at
        $scores = Score::where('instructorID', $instructor->id)->orderBy('scheduleID', 'asc')->get();

        // Ratings line chart
        $ratings = Rating::where('instructorID', $instructor->id)->get();

        // Extract and format data for the chart
        $formattedLabels = $ratings->pluck('created_at')->map(function ($timestamp) {
            return date('Y-m-d', strtotime($timestamp));
        });

        $ratingsData = $ratings->pluck('rating');

        return view('layouts.dashboard.instructor', compact('instructor', 'schedules', 'ratings', 'scores', 'formattedLabels', 'ratingsData'));
    }


    // verificationSend
    public function verificationSend(){

        return view('auth.verify');
    }

    // verification email resend
    public function verificationResend(Request $request){
        $user = User::find(Auth::user()->id);
        // send email verification
        $user->sendEmailVerificationNotification();
        // redirect back
        return redirect()->back()->with('success', 'Email verification has been sent!');
    }


    // verification verify
    public function verificationVerify(Request $request){
        // get user
        $user = User::find(Auth::user()->id);
        // check if user is verified
        if($user->hasVerifiedEmail()){
            return redirect()->route('customer.dashboard')->with('success', 'Email already verified!');
        }
        // verify email
        $user->markEmailAsVerified();
        // redirect back
        return redirect()->route('customer.dashboard')->with('success', 'Email verified!');
    }
}

