<?php

namespace App\Imports;

use App\Models\Record;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class RecordsImport implements ToModel,WithHeadingRow
{
    public function formatDate($date){
        if(is_numeric($date)){
            return Carbon::createFromFormat('Y-m-d', Date::excelToDateTimeObject($date)->format('Y-m-d'));
        }else{
            return $date;
        }
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Record([
            'date' => $this->formatDate($row['altarykh']),
            'name' => $row['alasm'],
            'financier_number' => $row['mmol'],
            'age' => $row['alaamr'],
            'patient_ID' => $row['hoy'],
            'phone_number1' => $row['goal1'],
            'phone_number2' => $row['goal2'],
            'operation' => $row['alaamly'],
            'doctor' => $row['altbyb'],
            'amount' => $row['altklf'],
            'doctor_share' => $row['hs_altbyb'],
            'anesthesiologists_share' => $row['tbyb_altkhdyr'],
            'anesthesia' => $row['hs_altkhdyr'],
            'bed' => $row['almbyt'],
            'private' => $row['khas'],
            'done' => $row['tmt_alaamly'],
            'notes' => $row['mlahthat'],
            'notes_2' => $row['mlahthat_thanoy'],
        ]);
    }
}
