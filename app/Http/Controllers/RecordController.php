<?php

namespace App\Http\Controllers;

use App\Imports\RecordsImport;
use App\Models\Logs;
use App\Models\Record;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;


class RecordController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Record::class);
        return view('dashboard.records.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Record::class);
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
     * Show the form for editing the specified resource.
     */
    public function edit(Record $record)
    {
        $this->authorize('update', Record::class);
        $financier_numbers = Record::select('financier_number')->distinct()->pluck('financier_number')->toArray();
        $operations = Record::select('operation')->distinct()->pluck('operation')->toArray();
        $doctors = Record::select('doctor')->distinct()->pluck('doctor')->toArray();
        $anesthesias = Record::select('anesthesia')->distinct()->pluck('anesthesia')->toArray();
        return view('dashboard.records.edit', compact('record', 'financier_numbers', 'operations', 'doctors', 'anesthesias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        $this->authorize('update', Record::class);

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
        $record->update($request->all());

        return redirect()->route('records.index')->with('success', 'تم تعديل بيانات المريض');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        $this->authorize('delete', Record::class);
        $record->delete();
        return redirect()->back()->with('success', 'تم حذف المريض بنجاح');
    }


    public function import(Request $request)
    {
        $this->authorize('import', Record::class);
        $file = $request->file('file');
        if (!$file) {
            return redirect()->back()->with('error', 'Please select a file to upload.');
        }
        Excel::import(new RecordsImport, $file);

        return redirect()->route('records.index')->with('success', 'تم رفع ملف الإكسيل بنجاح');
    }


    public function print(Request $request)
    {
        $this->authorize('export', Record::class);
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
