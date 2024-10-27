<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;


class RecordController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Record::class);
        $financier_numbers = Record::select('financier_number')->distinct()->pluck('financier_number')->toArray();
        $operations = Record::select('operation')->distinct()->pluck('operation')->toArray();
        $doctors = Record::select('doctor')->distinct()->pluck('doctor')->toArray();
        $anesthesias = Record::select('anesthesia')->distinct()->pluck('anesthesia')->toArray();

        return view('dashboard.records.index',compact('financier_numbers','operations','doctors','anesthesias'));
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
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        $this->authorize('delete', $record);
        $record->delete();
        return redirect()->back()->with('success', 'تم حذف المريض بنجاح');
    }


    public function print(Request $request)
    {
        $records = json_decode($request->data, true); // 'true' لتحويلها إلى مصفوفة
        $recordsCollection = collect($records); // تحويل المصفوفة إلى Collection
        if($request->report == 'basic'){
            $pdf = PDF::loadView('dashboard.reports.basic',['records' =>  $recordsCollection],[],[
                'mode' => 'utf-8',
                'format' => 'A4-L',
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


    // Api
    public function getData()
    {
        $data = Record::orderBy('date', 'asc')->get();
        return response()->json($data);
    }

    public function saveData(Request $request)
    {
        $this->authorize('update', Record::class);

        $newRecords = $request->input('newRecords');
        $deletedRecords = $request->input('deletedRecords');

        if($newRecords != []  && $deletedRecords != null){
            foreach ($newRecords as $record) {
                $record['user_id'] = $request->user()->id;
                $record['user_name'] = $request->user()->name;
                Record::create($record);
            }
        }
        if($deletedRecords != [] && $deletedRecords != null){
            foreach ($deletedRecords as $id) {
                $record = Record::find($id);
                if ($record) {
                    $record->delete();
                }
            }
        }

        return response()->json(['message' => 'تم حفظ القاعدة المحدثة']);
    }


    public function update_row(Request $request)
    {
        $this->authorize('update', Record::class);
        $rowData = $request->input('rowData');

        if(isset($rowData['id'])){
                    // تحديث البيانات
            $recordModel = Record::find($rowData['id']);
            if ($recordModel) {
                $recordModel->update($rowData);
            }
            return response()->json(['message' => 'تم حفظ التحديث']);
        }
    }
}
