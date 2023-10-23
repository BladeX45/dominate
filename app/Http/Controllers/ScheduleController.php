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
            $schedules = Schedule::all();

            $instructors = instructor::all();

            $scores = Score::all();

            return view('pages.schedules', compact('schedules', 'instructors', 'scores'));
        }
        elseif(Auth::user()->roleID == 2){
            // get customerID
            $customerID = Customer::where('userID', Auth::user()->id)->first();

            // get schedule paginate asc status
            $schedules = Schedule::where('customerID', $customerID->id)->orderBy('status', 'asc')->paginate(10);
            // dd($schedules);
            // get all instructors
            $instructors = instructor::all();

            // get customer score
            $scores = Score::where('customerID', $customerID->id)->get();

            // dd($scores);
            return view('pages.schedules', compact('schedules', 'customerID', 'instructors', 'scores'));
        }
        else{
            $schedules = Schedule::where('instructorID', Auth::user()->roleID)->get();

            $instructors = instructor::all();

            $scores = Score::all();

            return view('pages.schedules', compact('schedules', 'instructors', 'scores'));
        }
    }

    // cancel schedule
    public function cancel(Request $request){
        // dd($request->all());
        // get schedule
        $schedule = Schedule::find($request->scheduleID);
        // dd($schedule);
        // update status
        $schedule->status = 'canceled';
        $schedule->save();
        // dd($schedule);

        // check car type
        if($schedule->carType === 'manual'){
            // get customer
            $customer = Customer::find($schedule->customerID);
            // update manual session
            $customer->ManualSession = $customer->ManualSession + 1;
            $customer->save();
        }
        else{
            // get customer
            $customer = Customer::find($schedule->customerID);
            // update matic session
            $customer->MaticSession = $customer->MaticSession + 1;
            $customer->save();
        }

        // redirect
        return redirect()->back()->with('success', 'Schedule canceled successfully');
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
        // Get customer data
        $customer = Customer::where('userID', auth()->user()->id)->first();
        // Dump and die to inspect the data
        // dd($customer->ManualSession);
        // check request type matic or manual
        if($request->type === 'manual'){
            // check session manual customer
            if($customer->ManualSession <= 0){
                return redirect()->back()->with('error', 'You have no manual session left');
            }
            else{
                // if car mat
                // check if user has schedule at the same date and session
                $schedule = Schedule::where('customerID', $customer->id)->where('date', $request->date)->where('session', $request->session)->first();
                if($schedule){
                    return redirect()->back()->with('error', 'You have schedule at the same date and session');
                }
                // find car where the car is available at $request->date and $request->session from table schedules and availability is available
                $car = Car::whereDoesntHave('schedules', function($query) use ($request){
                    $query->where('date', $request->date)->where('session', $request->session);
                })->where('carStatus', 'available')->where('Transmission', 'manual')->first();
                // create schedule
                Schedule::create([
                    'customerID' => $customer->id,
                    'instructorID' => $request->instructor,
                    'date' => $request->date,
                    'session' => $request->session,
                    'carType' => 'manual',
                    'status' => 'pending',
                    'carID' => $car->id,
                ]);
                // update manual session
                $customer->ManualSession = $customer->ManualSession - 1;
                $customer->save();
                return redirect()->back()->with('success', 'Schedule created successfully');
            }
        }
        else if($request->type === 'matic'){
            // check session matic customer
            if($customer->MaticSession <= 0){
                return redirect()->back()->with('error', 'You have no matic session left');
            }
            else{
                // dd('test');
                // find car where the car is available at $request->date and $request->session from table schedules and availability is available
                $car = Car::whereDoesntHave('schedules', function($query) use ($request){
                    $query->where('date', $request->date)->where('session', $request->session);
                })->where('carStatus', 'available')->where('Transmission', 'automatic')->first();
                // create schedule
                Schedule::create([
                    'customerID' => $customer->id,
                    'instructorID' => $request->instructor,
                    'date' => $request->date,
                    'session' => $request->session,
                    'carType' => 'automatic',
                    'status' => 'pending',
                    'carID' => $car->id,
                ]);
                // update matic session
                $customer->MaticSession = $customer->MaticSession - 1;
                $customer->save();
                return redirect()->back()->with('success', 'Schedule created successfully');
            }
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
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
        $schedules = Schedule::where('instructorID', $instructor->id)->get();
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
