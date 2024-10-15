<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Record;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;


class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.records.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'patient_ID' => 'required|integer',
            'age' => 'integer|min:0|max:150',
            'phone_number1' => 'required',
            'operation' => 'required',
            'doctor' => 'required',
            'amount' => 'required',
        ]);
        $request->merge([
            'user_id' => $request->user()->id,
            'user_name' => $request->user()->name
        ]);
        Record::create($request->all());

        return redirect()->back()->with('success', 'تم إضافة مريض جديد بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        $record->delete();
        return redirect()->back()->with('success', 'تم حذف المريض بنجاح');
    }


    public function print(Request $request)
    {
        $records = json_decode($request->data, true); // 'true' لتحويلها إلى مصفوفة
        $recordsCollection = collect($records); // تحويل المصفوفة إلى Collection

        Logs::create([
            'type' => 'print',
            'message' => 'تم طباعة تقرير : ' . $request->report,
            'user_id' => $request->user()->id,
            'user_name' => $request->user()->name,
        ]);

        if($request->report == 'basic'){
            $pdf = PDF::loadView('dashboard.reports.basic',['records' =>  $recordsCollection],[],[
                'mode' => 'utf-8',
                'format' => 'A4',
                'default_font_size' => 12,
                'default_font' => 'Arial',
            ]);
            return $pdf->stream();
        }
        if($request->report == 'mali'){
            $pdf = PDF::loadView('dashboard.reports.mali',['records' =>  $recordsCollection],[],[
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'default_font_size' => 12,
                'default_font' => 'Arial',
            ]);
            return $pdf->stream();
        }
    }
}
