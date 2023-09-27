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
        /**
            customerID
            scheduleID
            isFinal
            theoryKnowledge
            practicalDriving
            hazardPerception
            trafficRulesCompliance
            confidenceAndAttitude
            overallAssessment
            additionalComment
         **/

        //  get data auth user and find on table instructor
        $instructor = Instructor::where('userID', auth()->user()->id)->first();
        // revalue isFinal
        if($request->input('isFinal') == 'on'){
            $request->merge(['isFinal' => 1]);
        }else{
            $request->merge(['isFinal' => 0]);
        }

        // if exist redirect else create
        if(Score::where('customerID', $request->input('customerID'))->where('scheduleID', $request->input('scheduleID'))->exists()){
            return redirect()->back()->with('error', 'Score already exist');
        }else{
            $score = new Score();
            $score->scheduleID = $request->input('scheduleID');
            $score->customerID = $request->input('customerID');
            $score->instructorID = $instructor->id;
            $score->isFinal = $request->input('isFinal');
            $score->theoryKnowledge = $request->input('theoryKnowledge');
            $score->practicalDriving = $request->input('practicalDriving');
            $score->hazardPerception = $request->input('hazardPerception');
            $score->trafficRulesCompliance = $request->input('trafficRulesCompliance');
            $score->confidenceAndAttitude = $request->input('confidenceAndAttitude');
            $score->overallAssessment = $request->input('overallAssessment');
            $score->additionalComment = $request->input('additionalComment');
            $score->save();

            // update schedule status
            $schedule = Schedule::find($request->input('scheduleID'));
            $schedule->status = 'need rating';
            $schedule->save();

            return redirect()->back()->with('success', 'Score added successfully');
        }
    }

    // instructor rating
    public function ratingInstructor(Request $request)
    {
        /**
            instructorID
            customerID
            rating
            comment
         **/
        // get data auth user and find on table customer
        $customer = Customer::where('userID', auth()->user()->id)->first();
        // if exist rating where condition scheduleID and customerID redirect else create
        if(rating::where('scheduleID', $request->input('scheduleID'))->where('customerID', $customer->id)->exists()){
            return redirect()->back()->with('error', 'Rating already exist');
        }else{
            $rating = new rating();
            $rating->scheduleID = $request->input('scheduleID');
            $rating->customerID = $customer->id;
            $rating->instructorID = $request->input('instructorID');
            $rating->rating = $request->input('rating');
            $rating->comment = $request->input('comment');
            $rating->save();

            // update schedule status
            $schedule = Schedule::find($request->input('scheduleID'));
            $schedule->status = 'done';
            $schedule->save();

            // update status schedule to completed
            $schedule = Schedule::find($request->input('scheduleID'));
            $schedule->status = 'completed';

            return redirect()->back()->with('success', 'Rating added successfully');
        }
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
