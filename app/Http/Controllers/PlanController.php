<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::all(); // Mengambil semua data plan
        return view('plan.index', ['plans' => $plans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $request->validate([
            'planName' => 'required|string|max:255',
            'planSession' => 'required|integer',
            'planType' => 'required|in:manual,automatic',
            'planPrice' => 'required',
            'planDescription' => 'required|string',
            'planStatus' => 'required|boolean',
        ]);

        // Simpan data ke database
        Plan::create([
            'planName' => $request->planName,
            'planSession' => $request->planSession,
            'planType' => $request->planType,
            'planPrice' => $request->planPrice,
            'planDescription' => $request->planDescription,
            'planStatus' => $request->planStatus,
        ]);

        // Redirect ke halaman index
        return redirect()->route('admin.plans');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return view('plan.show', ['plan' => $plan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('plan.edit', ['plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // find data plan berdasarkan id
        $plan = Plan::find($request->planID);

        // Validasi data yang dikirim dari form
        $request->validate([
            'planName' => 'string|max:255',
            'planSession' => 'integer',
            'planType' => 'in:manual,automatic',
            'planPrice' => 'numeric',
            'planDescription' => 'string',
            'planStatus' => 'boolean',
        ]);
        // Update data pada database

        $plan->update([
            'planName' => $request->planName,
            'planSession' => $request->planSession,
            'planType' => $request->planType,
            'planPrice' => $request->planPrice,
            'planDescription' => $request->planDescription,
            'planStatus' => $request->planStatus,
        ]);

        // return with status
        return back()->withStatus(__('Plan successfully updated.'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $requestm, $id)
    {
        $plan = Plan::find($id); // Mencari data rencana berdasarkan ID
        if ($plan) {
            $plan->delete(); // Menghapus data rencana jika ditemukan
        }
        // Redirect ke halaman index
        return redirect()->route('admin.plans');
    }
}
