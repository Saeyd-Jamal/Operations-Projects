<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Logs::class);
        $logs = Logs::paginate(100);
        return view('dashboard.logs', compact('logs'));
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
    public function show(Logs $logs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logs $logs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logs $logs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logs $logs)
    {
        //
    }
}
