<?php

namespace App\Http\Controllers;

use App\Imports\RecordsImport;
use App\Models\Financier;
use App\Models\Logs;
use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Yajra\DataTables\Facades\DataTables;

class RecordController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view', Record::class);
        if($request->ajax()) {
            // جلب بيانات المستخدمين من الجدول
            $records = Record::query()->orderBy('date', 'asc');;
            // التصفية بناءً على التواريخ
            if ($request->from_date != null && $request->to_date != null) {
                $records->whereBetween('date', [$request->from_date, $request->to_date]);
            }

            if ($request->from_age != null && $request->to_age != null) {
                $records->whereBetween('age', [$request->from_age, $request->to_age]);
            }

            if($request->fieldNull != null) {
                $records->whereNull($request->fieldNull);
            }

            return DataTables::of($records)
                    ->addIndexColumn()  // إضافة عمود الترقيم التلقائي
                    ->addColumn('financier', function ($record) {
                        $financier = Financier::where('financier_number', $record->financier_number)->first();
                        if($financier != null) {
                            return $financier->name;
                        }
                    })
                    ->addColumn('edit', function ($record) {
                        return $record->id;
                    })
                    ->addColumn('delete', function ($record) {
                        return $record->id;
                    })
                    ->make(true);
        }

        $names = Record::select('name')->distinct()->pluck('name')->toArray();
        $financiers = Record::select('financier_number')->distinct()->pluck('financier_number')->toArray();
        $operations = Record::select('operation')->distinct()->pluck('operation')->toArray();
        $doctors = Record::select('doctor')->distinct()->pluck('doctor')->toArray();
        $anesthesias = Record::select('anesthesia')->distinct()->pluck('anesthesia')->toArray();
        $user_names = Record::select('user_name')->distinct()->pluck('user_name')->toArray();
        return view('dashboard.records.index', compact('names', 'financiers', 'operations', 'doctors', 'anesthesias', 'user_names'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Record::class);
        $record = new Record();
        if($request->ajax()) {
            $record->date = Carbon::now()->format('Y-m-d');
            $record->user = $record->user;
            return response()->json($record);
        }
        // return view('dashboard.projects.allocations.create', compact('allocation'));
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
            'done' => $request->done ? 1 : 0,
            'user_id' => $request->user()->id,
            'user_name' => $request->user()->name
        ]);
        Record::create($request->all());
        if($request->ajax()) {
            return response()->json(['message' => 'تم الإضافة بنجاح']);
        }
        return redirect()->back()->with('success', 'تم إضافة مريض جديد بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Record $record)
    {
        $this->authorize('update', Record::class);
        if($request->ajax()) {
            $record->user = $record->user;
            return response()->json($record);
        }
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
        $request->merge([
            'done' => $request->done ? 1 : 0,
        ]);
        $record->update($request->all());
        if($request->ajax()) {
            return response()->json(['message' => 'تم التحديث بنجاح']);
        }
        return redirect()->route('records.index')->with('success', 'تم تعديل بيانات المريض');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('delete', Record::class);
        $record = Record::findOrFail($id);
        $record->delete();
        if($request->ajax()) {
            return response()->json(['message' => 'تم حذف المريض بنجاح']);
        }
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
