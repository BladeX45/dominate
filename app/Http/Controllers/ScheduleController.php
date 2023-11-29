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
        if(Auth::user()->roleID == 1 || Auth::user()->roleID == 0){
            $schedules = Schedule::orderBy('date', 'desc')->paginate(15);

            $instructors = Instructor::all();

            $scores = Score::all();

            return view('pages.schedules', compact('schedules', 'instructors', 'scores'));

        }
        elseif(Auth::user()->roleID == 2){
            // get customerID
            $customerID = Customer::where('userID', Auth::user()->id)->first();

            // get schedule paginate asc status
            $schedules = Schedule::where('customerID', $customerID->id)->orderBy('status', 'asc')->paginate(15);
            // dd($schedules);
            // get all instructors
            $instructors = instructor::all();

            // get customer score
            $scores = Score::where('customerID', $customerID->id)->get();

            // dd($scores);
            return view('pages.schedules', compact('schedules', 'customerID', 'instructors', 'scores'));
        }
        else{
            $schedules = Schedule::where('instructorID', Auth::user()->roleID)->paginate(15);

            $instructors = instructor::all();

            $scores = Score::all();

            return view('pages.schedules', compact('schedules', 'instructors', 'scores'));
        }
    }

    // cancel schedule
    public function cancel(Request $request) {
        // Find the schedule by ID and update its status
        $schedule = Schedule::where('id', $request->scheduleID)->first();
        if ($schedule) {
            $schedule->update(['status' => 'canceled']);

            // Find the customer by ID
            $customer = Customer::find($schedule->customerID);
            if ($customer) {
                // Update the session based on car type
                $sessionType = ($schedule->carType === 'manual') ? 'ManualSession' : 'MaticSession';
                $customer->$sessionType += 1;
                $customer->save();
            }

            return redirect()->back()->with('success', 'Schedule canceled successfully');
        }

        // Handle the case when the schedule is not found
        return redirect()->back()->with('error', 'Schedule not found');
    }


    /**
     * Check availability of schedule.
     */
    public function checkAvailability(Request $request)
    {
        dd($request->all());
        $instructorId = $request->input('instructor');
        $date = $request->input('date');
        $session = $request->input('session');

        // Periksa apakah jadwal tersedia berdasarkan instruktur, tanggal, dan sesi
        $isAvailable = !Schedule::where('instructorID', $instructorId)
            ->where('date', $date)
            ->where('session', $session)
            ->exists();

        return response()->json(['isAvailable' => $isAvailable]);
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
        $customer = Customer::where('userID', auth()->user()->id)->first();

        $date = $request->input('date');
        $session = $request->input('session');
        $instructor = $request->input('instructor');

        $existingSchedule = Schedule::where('date', $date)
            ->where('session', $session)
            ->where('instructorID', $instructor)
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
            ->first();
    }

    private function createSchedule($customer, $instructor, $date, $session, $transmission, $sessionValue)
    {
        $car = $this->findAvailableCar($date, $session, $transmission);

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
        return Car::whereDoesntHave('schedules', function ($query) use ($date, $session) {
            $query->where('date', $date)->where('session', $session);
        })->where('carStatus', 'available')->where('Transmission', $transmission)->first();
    }

    private function updateSession($customer, $sessionType, $value)
    {
        // revalue session type value

        $customer->$sessionType = $customer->$sessionType + $value;
        $customer->save();
    }



    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    // schedules for instructor
    public function instructorSchedules(){
        // ddd(Auth::user()->id);
        $instructor = instructor::where('userID', Auth::user()->id)->first();
        $schedules = Schedule::where('instructorID', $instructor->id)->paginate(15);
        // rating
        $ratings = rating::where('instructorID', $instructor->id)->get();
        // score
        $scores = Score::all();

        return view('instructor.schedules', compact('schedules', 'scores','ratings'));
    }

    // train
    public function train(Request $request){
        // update status schedule
        $schedule = Schedule::find($request->scheduleID);
        $schedule->status = 'trained';
        $schedule->save();

        // redirect
        return redirect()->back()->with('success', 'Schedule trained successfully');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
