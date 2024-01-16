<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Score;
use App\Models\rating;
use App\Models\Customer;
use App\Models\Schedule;
use App\Models\instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan peran (role) pengguna saat ini
        $userRoleID = Auth::user()->roleID;

        if ($userRoleID == 1 || $userRoleID == 0) {
            // Jika pengguna memiliki peran sebagai admin atau superadmin
            $schedules = Schedule::orderBy('date', 'desc')->get();
            $instructors = Instructor::all();
            $scores = Score::all();

            return view('pages.schedules', compact('schedules', 'instructors', 'scores'));
        } elseif ($userRoleID == 2) {
            // Jika pengguna memiliki peran sebagai customer
            $customerID = Customer::where('userID', Auth::user()->id)->first();
            $schedules = Schedule::where('customerID', $customerID->id)->orderBy('status', 'asc')->get();
            $instructors = Instructor::all();
            $scores = Score::where('customerID', $customerID->id)->get();

            return view('pages.schedules', compact('schedules', 'customerID', 'instructors', 'scores'));
        } else {
            // Jika pengguna memiliki peran sebagai instruktur
            $schedules = Schedule::where('instructorID', $userRoleID)->get();
            $instructors = Instructor::all();
            $scores = Score::all();

            return view('pages.schedules', compact('schedules', 'instructors', 'scores'));
        }
    }


    // cancel schedule
    public function cancel(Request $request) {
        // Cari jadwal berdasarkan ID dan perbarui statusnya
        $schedule = Schedule::find($request->scheduleID);



        if ($schedule) {
            // Perbarui status menjadi 'canceled'
            $schedule->update(['status' => 'canceled']);

            // Cari pelanggan berdasarkan ID
            $customer = Customer::find($schedule->customerID);

            if ($customer) {
                // Perbarui sesi berdasarkan jenis mobil
                $sessionType = ($schedule->car->Transmission === 'manual') ? 'ManualSession' : 'MaticSession';
                $customer->$sessionType += 1;
                $customer->save();
            }

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Schedule canceled successfully');
        }

        // Handle kasus ketika jadwal tidak ditemukan
        return redirect()->back()->with('error', 'Schedule not found');
    }



    /**
     * Check availability of schedule.
     */
    public function checkAvailability(Request $request)
    {
        $instructorId = $request->input('instructor');
        $date = $request->input('date');
        $session = $request->input('session');
        $transmission = $request->input('type');

        // Periksa apakah jadwal tersedia berdasarkan instruktur, tanggal, dan sesi
        $isAvailable = !Schedule::where('instructorID', $instructorId)
        ->where('date', $date)
        ->where('session', $session)
        ->get();

        // find available car
        $isAvailable = !$this->findAvailableCar($date, $session, $transmission);


        // check data $isAvailable if there is data with status is canceled with foreach
        // foreach ($isAvailable as $key => $value) {
        //     if($value->status === 'canceled'){
        //         $isAvailable = true;
        //     }
        //     else{
        //         $isAvailable = false;
        //     }
        // }


        return response()->json(['isAvailable' => $isAvailable]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = Customer::where('userID', auth()->user()->id)->first();

        $date = $request->input('date');
        $session = $request->input('session');
        $instructor = $request->input('instructor');
        $type = $request->type;
        // dd($type);

        $existingSchedule = Schedule::where('date', $date)
            ->where('session', $session)
            ->where('instructorID', $instructor)
            ->where('status', '!=', 'canceled')
            ->first();

        if ($existingSchedule) {
            return $this->redirectWithError('Schedule is Full Book');
        }

        if ($request->type === 'manual') {
            return $this->createManualSchedule($customer, $date, $session, $instructor);
        } elseif ($request->type === 'matic') {
            return $this->createAutomaticSchedule($customer, $date, $session, $instructor);
        } else {
            return $this->redirectWithError('Something went wrong');
        }
    }

    private function redirectWithError($message)
    {
        return redirect()->back()->with('error', $message);
    }

    private function createManualSchedule($customer, $date, $session, $instructor)
    {
        if ($customer->ManualSession <= 0) {
            return $this->redirectWithError('You have no manual session left');
        }

        $schedule = $this->findScheduleByCustomer($customer, $date, $session);

        if ($schedule) {
            return $this->redirectWithError('You have a schedule at the same date and session');
        }

        return $this->createSchedule($customer, $instructor, $date, $session, 'manual', -1);
    }

    private function createAutomaticSchedule($customer, $date, $session, $instructor)
    {
        if ($customer->MaticSession <= 0) {
            return $this->redirectWithError('You have no automatic session left');
        }

        return $this->createSchedule($customer, $instructor, $date, $session, 'automatic', -1);
    }

    private function findScheduleByCustomer($customer, $date, $session)
    {
        return Schedule::where('customerID', $customer->id)
            ->where('date', $date)
            ->where('session', $session)
            ->where('status', '!=', 'canceled')
            ->first();
    }

    private function createSchedule($customer, $instructor, $date, $session, $transmission, $sessionValue)
    {
        $car = $this->findAvailableCar($date, $session, $transmission);
        // return response()->json($car);

        if (!$car) {
            return $this->redirectWithError("No available $transmission car for the selected date and session");
        }

        Schedule::create([
            'customerID' => $customer->id,
            'instructorID' => $instructor,
            'date' => $date,
            'session' => $session,
            'status' => 'pending',
            'carID' => $car->id,
        ]);

        // realue tramission
        if($transmission === 'manual'){
            $transmission = 'Manual';
        }
        else{
            $transmission = 'Matic';
        }
        $this->updateSession($customer, $transmission . 'Session', $sessionValue);

        return redirect()->back()->with('success', 'Schedule created successfully');
    }

    private function findAvailableCar($date, $session, $transmission)
    {
        // where the car is not in the schedule where the date, session
        // if the the schedule is canceled, the car is available
        // if the schedule is not canceled, the car is not available
        return Car::whereNotIn('id', function ($query) use ($date, $session) {
            $query->select('carID')
                ->from('schedules')
                ->where('date', $date)
                ->where('session', $session)
                ->where('status', '!=', 'canceled');
        })->where('transmission', $transmission)->first();

    }

    private function updateSession($customer, $sessionType, $value)
    {
        // revalue session type value

        $customer->$sessionType = $customer->$sessionType + $value;
        $customer->save();
    }


    // schedules for instructor
    public function instructorSchedules()
    {
        // Get instructor data based on the logged-in user
        $instructor = Instructor::where('userID', Auth::user()->id)->first();

        // Get schedules paginated for better display
        $schedules = Schedule::where('instructorID', $instructor->id)->get();

        // Get ratings specific to the instructor
        $ratings = Rating::where('instructorID', $instructor->id)->get();

        // Get all scores (consider filtering by instructor if needed)
        $scores = Score::all();

        return view('instructor.schedules', compact('schedules', 'scores', 'ratings'));
    }

    // train
    public function train(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'scheduleID' => 'required|exists:schedules,id',
        ]);

        // Cari jadwal berdasarkan ID
        $schedule = Schedule::find($request->scheduleID);

        // Periksa apakah jadwal ditemukan
        if ($schedule) {
            // Update status jadwal menjadi 'trained'
            $schedule->status = 'trained';
            $schedule->save();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Schedule trained successfully');
        } else {
            // Redirect dengan pesan kesalahan jika jadwal tidak ditemukan
            return redirect()->back()->with('error', 'Schedule not found');
        }
    }
}
