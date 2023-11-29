<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Customer;
use App\Models\Schedule;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\rating;

class ScoreController extends Controller
{
    // customer Score
    public function addCustomerScore(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'customerID' => 'required|exists:customers,id',
            'scheduleID' => 'required|exists:schedules,id',
            'isFinal' => 'nullable|boolean',
            'theoryKnowledge' => 'required|numeric',
            'practicalDriving' => 'required|numeric',
            'hazardPerception' => 'required|numeric',
            'trafficRulesCompliance' => 'required|numeric',
            'confidenceAndAttitude' => 'required|numeric',
            'overallAssessment' => 'required|numeric',
            'additionalComment' => 'nullable|string',
        ]);

        // Get data instructor based on the authenticated user
        $instructor = Instructor::where('userID', auth()->user()->id)->first();

        // Revalue isFinal based on the request
        $isFinal = $request->has('isFinal') ? 1 : 0;

        // Check if the score already exists
        if (Score::where('customerID', $request->customerID)->where('scheduleID', $request->scheduleID)->exists()) {
            return redirect()->back()->with('error', 'Score already exists');
        }

        // Create a new score
        $score = new Score([
            'scheduleID' => $request->scheduleID,
            'customerID' => $request->customerID,
            'instructorID' => $instructor->id,
            'isFinal' => $isFinal,
            'theoryKnowledge' => $request->theoryKnowledge,
            'practicalDriving' => $request->practicalDriving,
            'hazardPerception' => $request->hazardPerception,
            'trafficRulesCompliance' => $request->trafficRulesCompliance,
            'confidenceAndAttitude' => $request->confidenceAndAttitude,
            'overallAssessment' => $request->overallAssessment,
            'additionalComment' => $request->additionalComment,
        ]);

        $score->save();

        // Update schedule status to 'need rating'
        $schedule = Schedule::find($request->scheduleID);
        $schedule->status = 'need rating';
        $schedule->save();

        return redirect()->back()->with('success', 'Score added successfully');
    }


    // instructor rating
    public function ratingInstructor(Request $request)
    {
        // Get data of authenticated user from the Customer model
        $customer = Customer::where('userID', auth()->user()->id)->first();
    
        // Check if a rating already exists for the given schedule and customer
        if (Rating::where('scheduleID', $request->input('scheduleID'))
            ->where('customerID', $customer->id)
            ->exists()) {
            return redirect()->back()->with('error', 'Rating already exists');
        }
    
        // Create a new rating
        $rating = Rating::create([
            'scheduleID' => $request->input('scheduleID'),
            'customerID' => $customer->id,
            'instructorID' => $request->input('instructorID'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Update schedule status to 'completed' if found
        if ($schedule = Schedule::find($request->input('scheduleID'))) {
            $schedule->update(['status' => 'completed']);
            return redirect()->back()->with('success', 'Rating added successfully');
        }
    
        // If the schedule is not found, redirect back with an error message
        return redirect()->back()->with('error', 'Schedule not found');
    }
    
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
    public function show(Score $score)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Score $score)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Score $score)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Score $score)
    {
        //
    }
}
