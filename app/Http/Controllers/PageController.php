<?php

namespace App\Http\Controllers;

// use model user
use App\Models\Car;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Models\instructor;
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
        return view('admin.dashboard');
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

    /**
     * Display upgrade page
     *
     * @return \Illuminate\View\View
     */
    public function upgrade()
    {
        return view('pages.upgrade');
    }
}
