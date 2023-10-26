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
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != 1){
            return redirect()->back();
        }

        // get all data from transaction
        $transactions = Transaction::all();
        // dd($transactions);
        $salesData = Transaction::select('planID', DB::raw('SUM(planAmount) as totalSales'))
        ->where('paymentStatus', 'success')
        ->groupBy('planID')
        ->get();

        $totalSales = $salesData->sum('totalSales');

        $percentageData = $salesData->map(function ($item) use ($totalSales) {
            return [
                'Plan' => $item->plan->planName, // Anda perlu memiliki atribut 'name' di model Plan
                'Percentage' => ($item->totalSales / $totalSales) * 100,
            ];
        });

        // get all car
        $cars = Car::all();

        // get all expense
        $expenses = Expense::all();

        // dd($percentageData);

        return view('admin.dashboard', compact('transactions', 'percentageData', 'cars', 'expenses'));
    }

    public function customerDashboard(){
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != 2){
            return redirect()->back();
        }
        // get data customer
        $customer = Customer::where('userID', Auth::user()->id)->first();
        // get all transaction
        $transactions = Transaction::where('userID', Auth::user()->id)->get();
        // get all schedule
        $schedules = Schedule::where('customerID', $customer->id)->get();
        // get data instructor
        $instructors = instructor::all();
        // get overallassessment and scheduleID asc created at
        $scores = Score::where('customerID', $customer->id)->orderBy('scheduleID', 'asc')->get();

        // If you want to retrieve the result as an array, you can use the toArray() method:
        $scores = $scores->toArray();
        // dd($scores);
        $certificates = Certificate::where('customerID', $customer->id)->get();
        // dd($scores);
        return view('layouts.dashboard.customer', compact('customer', 'schedules', 'instructors', 'scores', 'transactions', 'certificates'));
    }

    public function users()
    {
        // check auth role 0 / 1
        switch (auth()->user()->roleID) {
            case 0:
                $users = User::where('roleID', 1)->paginate(10);
                return view('owner.users', compact('users',));
                break;
            case 1:
                // instructor
                $instructors= instructor::all();
                // Mendapatkan semua data pengguna (users) dengan roleID = 3
                $data = DB::table('users')
                    ->join('roles', 'users.roleID', '=', 'roles.roleID')
                    ->where('users.roleID', 3) // Hanya ambil data dengan roleID = 3
                    ->select(
                        // id pengguna
                        'users.id as userID',
                        'users.name as userName', // Kolom 'name' dari tabel 'users'
                        'users.email as userEmail', // Kolom 'email' dari tabel 'users'
                        'roles.roleName' // Kolom 'namaRole' dari tabel 'roles'
                    )
                    ->paginate(10);


                // Mengirimkan data yang telah digabungkan dan dipaginasi ke tampilan
                return view('admin.users', compact('data', 'instructors'));

                break;
            case 2:
                return redirect()->route('customer.dashboard');
                break;
            case 3:
                return redirect()->route('instructor.dashboard');
                break;
            default:
                return redirect()->route('login');
                break;
        }
    }

    // transactions page
    public function indexTransactions(){
        // check admin or not
        // ddd(auth()->user()->roleID);
        // call name on table users

        if(auth()->user()->roleID === '1'){
            $data = DB::table('transactions')
                ->join('users', 'transactions.userID', '=', 'users.id')
                ->join('plans', 'transactions.planID', '=', 'plans.id')
                ->select(
                    'transactions.transactionID as transactionID',
                    'users.name as userName',
                    'transactions.planID as planID',
                    'transactions.created_at as transactionDate',
                    'transactions.planAmount as planAmount',
                    'transactions.paymentStatus as transactionStatus',
                    'transactions.paymentMethod as paymentMethod',
                    'transactions.receiptTransfer as receiptTransfer',
                    'transactions.totalSession as totalSession',
                    'users.name as userName',
                    'plans.planName as planName',
                    'plans.planType as planType',
                    'plans.planPrice as planPrice'
                )
                ->paginate(10);
            return view('admin.transactions', compact('data'));
        }
        echo 'test';
    }

    public function verifyPayment(Request $request){
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != '1'){
            return redirect()->back();
        }


    }

    public function customers(){
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != 1){
            return redirect()->back();
        }
        // role = 2
        $users = User::where('roleID', 2)->paginate(10);
        return view('admin.customers', compact('users'));
    }

    public function assets(){
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != 1){
            return redirect()->back();
        }
        // get car paginate 10
        $cars = Car::paginate(10);
        return view('admin.assets', compact('cars'));

    }

    public function plans(){
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != 1){
            return redirect()->back();
        }

        // get plan paginate 10
        $plans = Plan::paginate(10);
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

            // dd($scores);
            return view('pages.certificate', compact('certificate'));
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
        $instructorId = $request->input('instructor');
        $date = $request->input('date');
        $session = $request->input('session');
        $type = $request->input('type');

        // revalue type to manual or automatic
        if($type == 'manual'){
            $type = 'manual';
        }else{
            $type = 'automatic';
        }

        // Periksa apakah jadwal tersedia berdasarkan instruktur, tanggal, dan sesi
        $isAvailable = !Schedule::where('instructorID', $instructorId)
            ->where('date', $date)
            ->where('session', $session)
            ->exists();

        $car = Car::whereDoesntHave('schedules', function($query) use ($request){
            $query->where('date', $request->date)->where('session', $request->session);
        })->where('carStatus', 'available')->where('Transmission', $type)->first();

        // check if car is available
        if($car == null){
            $isAvailable = false;
        }

        return response()->json(['isAvailable' => $isAvailable]);
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
                $instructors = instructor::find($instructorID);
                // get data score
                $scores = Score::where('customerID', $customerID)->where('scheduleID', $scheduleID)->first();

                // dd($scores);
                // if certificate customer ID and schedule ID isExist then redirect back
                if(Certificate::where('customerID', $customerID)->where('scoreID', $scores->id)->exists()){
                    // redirect to show customer certicate

                    $certificate = Certificate::where('customerID', $customerID)->where('scoreID', $scores->id)->first();
                    return view('pages.certificate', compact('schedules', 'customer', 'scores', 'instructors', 'certificate'));
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
    public function instructorDashboard(){
        // forbidden route if not admin back to previous page
        if(Auth::user()->roleID != 3){
            return redirect()->back();
        }
        // get data instructor
        $instructor = instructor::where('userID', Auth::user()->id)->first();
        // get all schedule
        $schedules = Schedule::where('instructorID', $instructor->id)->get();
        // get data instructor
        $instructors = instructor::all();
        // get overallassessment and scheduleID asc created at
        $scores = Score::where('instructorID', $instructor->id)->orderBy('scheduleID', 'asc')->get();

        // dd($scores);
        // dd($scores);
        // ratings line chart
        $ratings = rating::where('instructorID', $instructor->id)->get();
        // Now, extract and format the data for the chart as previously shown.
        $labels = $ratings->pluck('created_at');
        $ratingsData = $ratings->pluck('rating');

        $formattedLabels = $labels->map(function ($timestamp) {
            return date('Y-m-d', strtotime($timestamp));
        });
        return view('layouts.dashboard.instructor', compact('instructor', 'schedules', 'ratings', 'scores', 'formattedLabels', 'ratingsData'));
    }


    // verificationSend
    public function verificationSend(){

        return view('auth.verify');
    }

    // verification email resend

    // verification email resend
    public function verificationResend(Request $request){
        // get user
        // ddauth
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

