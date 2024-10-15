<?php

namespace App\Livewire;

use App\Models\Logs;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TableRecord extends Component
{
    public $records;
    public $show = false;



    public $showModal = false;

    public $dataModal = [
        'id' => '',
        'name' => '',
        'date' => '',
        'patient_ID' => '',
        'age' => '',
        'phone_number1' => '',
        'phone_number2' => '',
        'financier_number' => '',
        'operation' => '',
        'doctor' => '',
        'amount' => '',
        'doctor_share' => '',
        'anesthesiologists_share' => '',
        'anesthesia' => '',
        'bed' => '',
        'private' => '',
        'notes' => '',
        'done' => '',
    ];

    public $filterData = [
        'name' => '',
        'from_date' => '',
        'to_date' => '',
        'patient_ID' => '',
        'financier_number' => '',
        'operation' => '',
        'doctor' => '',
        'anesthesia' => '',
        'done' => '',
    ];

    public $financier_numbers;
    public $operations;
    public $doctors;
    public $anesthesias;



    public function __construct()
    {
        $this->financier_numbers = Record::select('financier_number')->distinct()->pluck('financier_number')->toArray();
        $this->operations = Record::select('operation')->distinct()->pluck('operation')->toArray();
        $this->doctors = Record::select('doctor')->distinct()->pluck('doctor')->toArray();
        $this->anesthesias = Record::select('anesthesia')->distinct()->pluck('anesthesia')->toArray();
    }

    public function mount(){
        $this->records = Record::get();
        $this->filterData['to_date'] = \Carbon\Carbon::now()->format('Y-m-d');
    }


    public function search($name){
        $this->records = Record::where('name', 'like', '%'.$name.'%')->get();
    }

    public function filter(){
        $this->records = Record::query();
        foreach ($this->filterData as $key => $value) {
            if($value != ''){
                if($key == 'from_date'){
                    $value = \Carbon\Carbon::parse($value)->format('Y-m-d');
                    $this->records = $this->records->where('date', '>=', $value);
                }elseif($key == 'to_date'){
                    $value = \Carbon\Carbon::parse($value)->format('Y-m-d');
                    $this->records = $this->records->where('date', '<=', $value);
                }elseif($key == 'financier_number' || $key == 'operation' || $key == 'doctor' || $key == 'anesthesia' || $key == 'done'){
                    $this->records = $this->records->where($key, '=', $value);
                }else{
                    $this->records = $this->records->where($key, 'like', '%'.$value.'%');
                }
            }
        }
        $this->records = $this->records->get();
    }
    public function resetForm(){
        foreach ($this->filterData as $key => $value) {
            $this->filterData[$key] = '';
        }
        $this->records = Record::get();
    }




    // تأكد من أن الطريقة عامة public
    public function openModal($id)
    {
        $this->showModal = false;

        $record = Record::where('id', $id)->first();
        // تحميل بيانات السجل إلى $dataModal
        $this->dataModal = [
            'id' => $record->id,
            'name' => $record->name,
            'date' => $record->date,
            'patient_ID' => $record->patient_ID,
            'age' => $record->age,
            'phone_number1' => $record->phone_number1,
            'phone_number2' => $record->phone_number2,
            'financier_number' => $record->financier_number,
            'operation' => $record->operation,
            'doctor' => $record->doctor,
            'amount' => $record->amount,
            'doctor_share' => $record->doctor_share,
            'anesthesiologists_share' => $record->anesthesiologists_share,
            'anesthesia' => $record->anesthesia,
            'bed' => $record->bed,
            'private' => $record->private,
            'notes' => $record->notes,
            'done' => $record->done,
        ];
        $this->showModal = true;
    }


    public function amountS($amount)
    {
        if($amount != "" || $amount != null){
            $this->dataModal['amount'] = $amount;
            $this->dataModal['doctor_share'] = ($this->dataModal['amount'] * 0.4);
            $this->dataModal['private'] = ($this->dataModal['amount'] * 0.05);
        }
    }

    public function amountNew($amount)
    {
        $this->show = true;
        if($amount != "" || $amount != null){
            $this->dataModal['doctor_share'] = ($amount  * 0.4);
            $this->dataModal['private'] = ($amount  * 0.05);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
    }


    public function save()
    {
        // حفظ التعديلات في السجل
        $record = Record::where('id', $this->dataModal['id'])->first();

        $record->update($this->dataModal);

        // إغلاق المودال بعد الحفظ
        $this->closeModal();
        $this->mount();
    }



    public function render()
    {
        return view('livewire.table-record');
    }
}
